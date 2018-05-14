<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\ApiController;
use App\Member;
use Illuminate\Http\Request;

class MemberController extends ApiController {

	// 注册会员
	public function register(Request $req) {
		$message = ['type' => 'register']; // 返回json
		if (!$req->filled('name', 'tel')) {
			$message['status'] = 'error';
			$message['message'] = '参数不正确';
			$values = [
				'message' => $message,
			];
			return view('member_register', $values);
		}

		$tel = $req->input('tel');
		$hasTel = Member::where('tel', $tel)->first();
		if (!is_null($hasTel)) {
			$message['status'] = 'error';
			$message['message'] = '手机号码已存在';
			$values = [
				'message' => $message,
			];
			return view('member_register', $values);
		}

		$user = session('wechat.oauth_user');
		$openid = $user['default']['original']['openid'];

		// 会员已存在 直接返回登录信息
		$hasOpenid = Member::where('openid', $openid)->first();
		if (!is_null($hasOpenid)) {
			$message['status'] = 'success';
			$message['openid'] = $openid;
			$values = [
				'message' => $message,
			];
			return view('member_register', $values);
		}

		$data = $req->only(['name', 'tel']);
		$member = new Member;
		$member->openid = $openid;
		$member->name = $data['name'];
		$member->tel = $data['tel'];
		$res = $member->save();

		// 返回json
		if ($res) {
			$message['status'] = 'success';
			$message['openid'] = $openid;
		} else {
			$message['status'] = 'error';
		}
		$values = [
			'message' => $message,
		];
		return view('member_register', $values);
	}

	public function login() {
		$user = session('wechat.oauth_user');
		$openid = $user['default']['original']['openid'];
		$find = Member::where('openid', $openid)->first();
		// 返回数据
		$message = [
			'type' => 'login',
		];
		if ($find) {
			$message['status'] = 'success';
			$message['data'] = $openid;
		} else {
			$message['status'] = 'error';
			$message['message'] = '用户不存在';
		}

		$values = ['message' => $message];
		return view('member_login', $values);
	}

	public function edit(Request $req, $id) {
		$form = $req->only(['name', 'tel']);
		$member = Member::find($id);
		foreach ($form as $key => $v) {
			$member->$key = $v;
		}
		$res = $member->save();
		if ($res) {
			return $this->message('success');
		}

		return $this->failed('发生未知错误，操作失败。');
	}

	public function list(Request $req) {
		$pagesize = $req->input('pagesize', 10);
		$member = Member::orderBy('id', 'desc')->paginate($pagesize);
		return $this->success($member);
	}

}
