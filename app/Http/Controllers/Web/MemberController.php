<?php

namespace App\Http\Controllers\Web;

use App\Member;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

class MemberController extends ApiController {

	public function item($openid) {
		$member = Member::where('openid', $openid)->first();
		return $this->success($member);
	}

	public function add() {
		$m = new Member;
		$m->openid = chr(mt_rand(33, 126));
		$m->save();
	}

	public function signup(Request $req) {
		if (!$req->filled(['avatar', 'name', 'sex', 'tel', 'region', 'adress', 'certnumber'])) {
			return $this->failed('信息填写不正确');
		}

		$regions = $req->input('region');
		$region = $regions[len($regions)-1];
		$member = Member::where('openid', $openid)->first();
		$member->avatar = $req->input('avatar');
		$member->name = $req->input('name');
		$member->sex = $req->input('sex');
		$member->tel = $req->input('tel');
		$member->region = $region;
		$member->adress = $req->input('adress');
		$member->certnumber = $req->input('certnumber');
		$member->status = 2;
		$res = $member->save();
		if ($res) {
			return $this->message('申请成功，请等待审核');
		}
		return $this->failed('申请失败，请重试');
	}

}