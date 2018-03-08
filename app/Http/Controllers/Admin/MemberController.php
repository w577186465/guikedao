<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\ApiController;
use App\Member;
use Illuminate\Http\Request;

class MemberController extends ApiController {

	public function edit(Request $req, $id) {
		$form = $req->only(['name', 'sex', 'tel', 'certnumber', 'status']);
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

}
