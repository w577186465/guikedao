<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\ApiController;
use App\Member;
use App\UserGroup;
use Illuminate\Http\Request;

class UserController extends ApiController {

	public function index(Request $req) {
		$where = $req->only('province', 'city', 'region');
		$where['status'] = $req->input('status', 1);
		$member = Member::where($where)->paginate(10);
		$group = UserGroup::get();
		$data = [
			'member' => $member,
			'group' => $group,
		];
		return $this->success($data);
	}

	public function list(Request $req) {
		$where = $req->only('province', 'city', 'region');
		$where['status'] = $req->input('status', 1);
		$member = Member::where($where)->paginate(10);
		return $this->success($member);
	}

	public function examine(Request $req) {
		if (!$req->filled(['ids', 'ok'])) {
			return $this->failed('参数不正确');
		}
		$ids = $req->input('ids');

		$status = -1;
		if ($req->input('ok') == 'true') {
			$status = 1;
		}

		$res = Member::whereIn('id', $ids)->update(['status' => $status]);
		if ($res) {
			return $this->message('操作成功');
		}

		return $this->message('操作失败');
	}

}
