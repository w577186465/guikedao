<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\ApiController;
use App\Member;
use App\UserGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends ApiController {

	public function index(Request $req) {
		$where = $req->only('province', 'city', 'region');
		$status = $req->input('status');
		if ($req->filled('status')) {
			if (preg_match('/^\d+$/', $status)) {
				$where['status'] = $req->input('status');
			} elseif ($status == 'member') {
				$where[] = ['status', '>', 0];
			}
		}

		if ($req->filled('apply_status')) {
			$where['apply_status'] = $req->input('apply_status');
		}

		$member = Member::with('group')->with('apply')->where($where)->paginate(10);
		$group = UserGroup::get();
		$data = [
			'member' => $member,
			'group' => $group,
		];
		return $this->success($data);
	}

	public function list(Request $req) {
		$where = $req->only('province', 'city', 'region');
		$status = $req->input('status');
		if ($req->filled('status')) {
			if (preg_match('/^\d+$/', $status)) {
				$where['status'] = $req->input('status');
			} elseif ($status == 'member') {
				$where[] = ['status', '>', 0];
			}
		}

		return $where;

		if ($req->filled('apply_status')) {
			$where['apply_status'] = $req->input('apply_status');
		}

		$member = Member::with('group')->with('apply')->where($where)->paginate(10);
		return $this->success($member);
	}

	public function examine(Request $req) {
		if (!$req->filled(['id', 'ok'])) {
			return $this->failed('参数不正确');
		}

		$id = $req->input('id');
		$m = Member::find($id);
		if ($req->input('ok') != 'true') {
			$m->apply_status = -1;
			$m->save();
			return $this->message('操作成功');
		}

		$m->status = $m->apply_id;
		$m->apply_status = 1;
		$res = $m->save();

		if ($res) {
			return $this->message('操作成功');
		}

		return $this->message('操作失败');
	}

	public function member_count(Request $req) {
		if (!$req->filled('city')) {
			return $this->failed('参数不正确');
		}

		$city = $req->input('city');
		$data = [];
		$chuji = Member::where('city', $city)->where('status', 1)
			->select(DB::raw('count(region) as user_count, status, region'))
			->groupBy('region', 'status', 'region')
			->get();

		$data['chuji'] = $chuji;

		$gaoji = Member::where('city', $city)->where('status', 2)
			->select(DB::raw('count(region) as user_count, status, region'))
			->groupBy('region', 'status', 'region')
			->get();

		$data['gaoji'] = $gaoji;

		return $this->success($data);
	}

	public function shenhe_count() {
		$count = Member::where('status', 2)->count();
		return $this->success($count);
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
