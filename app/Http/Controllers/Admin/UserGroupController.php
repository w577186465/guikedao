<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\ApiController;
use App\UserGroup;
use Illuminate\Http\Request;

class UserGroupController extends ApiController {

	public function add(Request $req) {
		if (!$req->filled('name') || !$req->filled('alias')) {
			return $this->failed('信息填写不正确');
		}

		$m = new UserGroup;
		$m->name = $req->input('name');
		$m->alias = $req->input('alias');
		$res = $m->save();
		if ($res) {
			return $this->message('添加成功');
		}

		return $this->failed('添加失败');
	}

	public function index() {
		$group = UserGroup::get();
		return $this->success($group);
	}

}
