<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\ApiController;
use App\Member;
use Illuminate\Http\Request;

class UserController extends ApiController {

	public function index(Request $req) {
		$pagesize = $req->input("pagesize", 10);
		$member = Member::orderBy("id", "desc")->paginate($pagesize);
		return $this->success($member);
	}

	public function user_change(Request $req) {
		$user = $req->user();
		if (!$req->filled('username')) {
			return $this->failed('账号不能为空');
		}

		$user->name = $req->input('username');
		if ($req->filled('password')) {
			$user->password = bcrypt($req->input('password'));
		}

		$res = $user->save();
		if ($res) {
			return $this->message('success');
		}
	}

}
