<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\ApiController;
use App\Member;
use Illuminate\Http\Request;

class MemberController extends ApiController {

	public function item($openid) {
		$member = Member::with('group')->where('openid', $openid)->first();
		if (!isset($member->id)) {
			$res = array('msg' => '无权限');
			return response($res, 401);
		}
		return $this->success($member);
	}

	public function add() {
		$m = new Member;
		$m->openid = chr(mt_rand(33, 126));
		$m->save();
	}

	public function signup(Request $req) {
		if (!$req->filled(['openid', 'avatar', 'name', 'sex', 'tel', 'region', 'adress', 'certnumber'])) {
			return $this->failed('信息填写不正确');
		}
		$openid = $req->input('openid');
		$member = [];
		$member['avatar'] = $req->input('avatar');
		$member['tel'] = $req->input('tel');
		if ($req->filled(['province', 'city', 'region'])) {
			$member['province'] = $req->input('province');
			$member['city'] = $req->input('city');
			$member['region'] = $req->input('region');
		}
		$member['regiondesc'] = $req->input('regiondesc');
		$member['adress'] = $req->input('adress');

		if ($req->filled('apply_id')) {
			$member['apply_id'] = $req->input('apply_id');
			$member['apply_status'] = 0;
		}

		$get = Member::where('openid', $openid)->first();

		if ($get->apply_status < 0) {
			$member['apply_status'] = 0;
		}

		if ($get->status < 1) {
			$member['sex'] = $req->input('sex');
			$member['name'] = $req->input('name');
			$member['certnumber'] = $req->input('certnumber');
		}

		$res = Member::where('openid', $openid)->update($member);

		if ($res) {
			return $this->message('申请成功，请等待审核');
		}
		return $this->failed('申请失败，请重试');
	}

}