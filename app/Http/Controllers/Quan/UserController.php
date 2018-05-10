<?php

namespace App\Http\Controllers\Quan;

use App\Http\Controllers\ApiController;
use App\Member;
use App\MyQuan;
use EasyWeChat\Kernel\Messages\Text;
use Illuminate\Http\Request;

class UserController extends ApiController {

	public function add(Request $req) {
		if (!$req->filled('user_id', 'quan_id', 'num')) {
			return $this->failed("参数不正确");
		}

		$user_id = $req->input('user_id');
		$quan_id = $req->input('quan_id');
		$member = Member::find($user_id);
		$openId = $member->openid;

		$old = MyQuan::where('user_id', $user_id)->where('quan_id', $quan_id)->first(); // 获取原有优惠券信息
		if (is_null($old)) {
			$quan = new MyQuan;
			$num = $req->input('num');
		} else {
			$quan = MyQuan::find($old->id);
			$num = $req->input('num') + $old->num;
		}

		$quan->user_id = $user_id;
		$quan->quan_id = $quan_id;
		$quan->num = $num;
		$res = $quan->save();
		if ($res) {
			$text = new Text('您好！overtrue。');
			$app = app('wechat.official_account');
			$app->template_message->send([
				'touser' => 'onIIQxIpMOr-U_7U3EN5ScYj3cQQ',
				'template_id' => 'XM5Qfl3YTLgSWzBy872naqY3AUCCRgXd028rtIYzqF0',
				'url' => 'https://easywechat.org',
				'data' => [],
			]);
			// $app->customer_service->message($text)->to($openId)->send();
			return $this->message('success');
		}
		return $this->failed("发生未知错误，添加失败。");
	}

	public function edit(Request $req, $id) {
		$quan = MyQuan::find($id);
		$data = $req->only(['user_id', 'quan_id', 'num']);
		if (empty($data)) {
			return $this->failed('参数不正确');
		}

		foreach ($data as $key => $value) {
			$quan->$key = $value;
		}
		$res = $quan->save();
		if ($res) {
			return $this->message('success');
		}

		return $this->failed('发生未知错误，修改失败。');
	}

	public function all(Request $req, $id) {
		$pagesize = $req->input('pagesize', 10);
		return MyQuan::with('quan')->where('user_id', $id)->orderBy('id', 'desc')->get();
	}

}
