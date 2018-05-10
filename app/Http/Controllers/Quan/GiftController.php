<?php

namespace App\Http\Controllers\Quan;

use App\Gift;
use App\GiftQuan;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\Quan\QuanService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class GiftController extends ApiController {

	public function produce(Request $req) {
		if (!$req->filled('quans')) {
			return $this->failed('请选择卡券');
		}

		$quans = $req->input('quans');
		$mid = $req->member->id;

		// 减掉卡券
		$res = QuanService::minus($mid, $quans);
		if ($res['status'] == 'error') {
			return $this->failed($res['message']);
		}

		$gift = new Gift;
		$gift->member_id = $mid;
		if ($req->filled('receiver')) {
			$gift->receiver = $req->input('receiver');
		}
		$gift->coding = md5(date('YmdHis') . rand(1000, 9999));
		$res = $gift->save();
		if (!$res) {
			return $this->failed('发生未知错误，操作失败。');
		}

		// 保存卡券信息
		foreach ($quans as $key => $value) {
			$quan = new GiftQuan;
			$quan->name = $value['name'];
			$quan->gift_id = $gift->id;
			$quan->quan_id = $value['quan_id'];
			$quan->num = $value['num'];
			$quan->save();
		}

		return $this->success($gift->id);
	}

	public function receive(Request $req, $coding) {
		$gift = Gift::with('quans')->where('coding', $coding)->first();
		$quans = $gift->quans;
		$mid = $req->member->id;
		if ($gift->status == 1) {
			$msg = '已经被人领走了...';
			if ($gift->receiver == $mid) {
				$msg = '你已经领过了哦';
			}
			return $this->failed($msg);
		} elseif ($gift->status == 2) {
			$this->failed('该礼包超过24小时未领取，已失效。');
		}

		$now = Carbon::now();
		if ($gift->created_at->diffInDays($now) > 0) {
			Gift::where('coding', $coding)->update(['status' => 2]);
			return $this->failed('该礼包超过24小时未领取，已失效。');
		}

		Gift::where('coding', $coding)->update(['receiver' => $mid, 'status' => 1]);

		$res = QuanService::add($mid, $quans);
		if ($res['status'] == 'error') {
			return $this->failed($res['message']);
		}

		return $this->message('success');
	}

	public function gift(Request $req, $id) {
		$gift = Gift::with('quans')->find($id);
		if (!isset($gift->id)) {
			return $this->failed('礼包不存在');
		}
		if ($req->member->id != $gift->member_id) {
			return $this->failed('您无权访问该页面！');
		}

		return $gift;
	}

	public function gift_bycoding(Request $req, $coding) {
		$gift = Gift::with('quans')->where('coding', $coding)->first();
		if ($gift->status == 1) {
			$msg = '已经被人领走了...';
			if ($gift->receiver == $req->member->id) {
				$msg = '你已经领过了哦';
			}
			return $this->failed($msg);
		}

		$now = Carbon::now();
		if ($gift->created_at->diffInDays($now) > 0) {
			Gift::where('coding', $coding)->update(['status' => 1]);
			return $this->failed('该礼包超过24小时未领取，已失效。');
		}

		return Gift::with('quans')->where('coding', $coding)->first();
	}

	public function list(Request $req) {
		$pagesize = $req->input('pagesize', 10);
		$mid = $req->member->id;
		QuanService::gift_back($mid);

		$where = [];
		$where['member_id'] = $mid;
		if ($req->filled('status')) {
			$where['status'] = $req->input('status');
		}

		if ($req->input('status') == 1) {
			return Gift::with('receive')->where($where)->paginate($pagesize);
		} else {
			return Gift::where($where)->paginate($pagesize);
		}
	}

}
