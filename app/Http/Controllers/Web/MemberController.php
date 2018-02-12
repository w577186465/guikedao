<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\ApiController;
use App\Member;
use Illuminate\Http\Request;

class MemberController extends ApiController {

	public function item($openid) {
		$member = Member::where('openid', $openid)->first();
		if (!isset($member->id)) {
			return $this->failed('会员不存在');
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
		$member['province'] = $req->input('province');
		$member['city'] = $req->input('city');
		$member['region'] = $req->input('region');
		$member['regiondesc'] = $req->input('regiondesc');
		$member['adress'] = $req->input('adress');

		$get = Member::where('openid', $openid)->first();
		
		if ($get->status != 1) {
			$member['sex'] = $req->input('sex');
			$member['name'] = $req->input('name');
			$member['certnumber'] = $req->input('certnumber');
			$member['status'] = 2;
		}

		$res = Member::where('openid', $openid)->update($member);

		if ($res) {
			return $this->message('申请成功，请等待审核');
		}
		return $this->failed('申请失败，请重试');
	}

}