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

	public function edit(Request $req) {
		if (!$req->filled('name') || !$req->filled('alias') || !$req->filled('id')) {
			return $this->failed('信息填写不正确');
		}
		$id = $req->input('id');
		$m = UserGroup::find($id);
		$m->name = $req->input('name');
		$m->alias = $req->input('alias');
		$res = $m->save();
		if ($res) {
			return $this->message('修改成功');
		}

		return $this->failed('修改失败');
	}
	
	public function delete($id) {
		$res = UserGroup::destroy($id);
		if ($res) {
			return $this->message('删除成功');
		}

		return $this->failed('删除失败');
	}

	public function index() {
		$group = UserGroup::get();
		return $this->success($group);
	}

}
