<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\ApiController;
use App\Member;
use App\MyQuan;
use App\Order;
use App\OrderQuan;
use App\OrderWuliu;
use Illuminate\Http\Request;

class OrderController extends ApiController {

	public function add_order(Request $req) {
		if (!$req->filled('order_type', 'quans')) {
			return $this->failed('参数不正确');
		}

		$mid = $req->member->id; // 会员id

		$quans = $req->input('quans'); // 卡券数据
		if (!is_array($quans)) {
			return $this->failed('卡券不正确');
		}

		if (empty($quans)) {
			return $this->failed('卡券不正确');
		}

		// 检查卡券数量是否足够
		if (!$this->quan_num_true($quans, $mid)) {
			return $this->failed('卡券不足');
		}

		$types = ['express', 'custom'];
		$type = $req->input('order_type');
		if (!in_array($type, $types)) {
			return $this->failed('订单类型不存在！');
		}

		$coding = date('YmdHis') . rand(1000, 9999);

		$order = new Order;
		if ($type == 'express') {
			if (!$req->filled("adress")) {
				return $this->failed('快递地址不能为空');
			}

			$order->adress = $req->input('adress');
		}

		$order->member_id = $req->member->id;
		$order->coding = $coding;
		$order->status = 1;
		$order->order_type = $type;
		$res = $order->save();

		// 保存卡券数据
		foreach ($quans as $key => $value) {
			$orderQuan = new OrderQuan;
			$orderQuan->name = $value['name'];
			$orderQuan->order_id = $order->id;
			$orderQuan->quan_id = $value['id'];
			$orderQuan->num = $value['num'];
			$orderQuan->save();
		}

		$this->quan_minus($quans, $req->member->id); // 订单成功减少卡券数量

		return $this->message('success');
	}

	// 减券
	private function quan_minus($quans, $mid) {
		foreach ($quans as $key => $value) {
			$quan = MyQuan::find($value['id']);
			if ($quan->num <= 0) {
				continue;
			}
			$quan->num = $quan->num - 1;
			$quan->save();
		}
	}

	private function quan_num_true($quans, $mid) {
		$quanIds = [];
		foreach ($quans as $key => $value) {
			if ($value['num'] == 0) {
				continue;
			}
			$quanIds[] = $value['id'];
		}

		/*
			where user_id 只获取该会员的卡券 防止使用其他人的卡券
		*/
		$get = MyQuan::where('user_id', $mid)->whereIn('quan_id', $quanIds)->get()->toArray();
		if (empty($get)) {
			return false;
		}

		$reset = [];
		foreach ($get as $key => $value) {
			$reset[$value['id']] = $value;
		}

		foreach ($quans as $key => $value) {
			if ($reset[$value['id']]['num'] < $value['num']) {
				return false;
			}
		}

		return true;
	}

	public function myorder(Request $req) {
		$mid = $req->member->id;
		$pagesize = $req->input('pagesize', 10);

		$where = [];
		if ($req->filled('status')) {
			$where['status'] = $req->input('status');
		}
		$where['member_id'] = $mid;

		return Order::with('quan')->with('wuliu')->where($where)->orderBy('id', 'desc')->paginate($pagesize);
	}

	public function list(Request $req) {
		$pagesize = $req->input('pagesize', 10);
		return Order::with('quan')->with('member')->orderBy('status', 'asc')->orderBy('id', 'desc')->paginate($pagesize);
	}

	private function set_order_status($id, $status) {
		$order = Order::find($id);
		$order->status = $status;
		$res = $order->save();
		if ($res) {
			return $this->message('success');
		}

		return $this->failed('发生未知错误，操作失败。');
	}
	// 发货
	public function send_out(Request $req, $id) {
		return $this->set_order_status($id, 2);
	}

	public function express_send_out(Request $req, $id) {
		if (!$req->filled('company', 'coding')) {
			return $this->failed('参数不正确');
		}

		$wuliu = new OrderWuliu;
		$wuliu->order_id = $id;
		$wuliu->company = $req->input('company');
		$wuliu->coding = $req->input('coding');
		$res = $wuliu->save();
		if (!$res) {
			return $this->failed('发生未知错误，操作失败。');
		}

		return $this->set_order_status($id, 2);
	}

	// 收货
	public function confirm($id) {
		$res = $this->set_order_status($id, 3);
		if ($res) {
			return $this->message('success');
		}

		return $this->failed('发生未知错误，操作失败。');
	}

	public function address(Request $req) {
		$app = app('wechat.official_account');
		$config = $app->jssdk->buildConfig(array('onMenuShareAppMessage'), false);
		$values = [
			'config' => $config,
		];
		return view('share', $values);
	}

}
