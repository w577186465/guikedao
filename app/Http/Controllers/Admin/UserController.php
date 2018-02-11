<?php

namespace App\Http\Controllers\Admin;

use App\UserGroup;
use App\Member;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

class UserController extends ApiController {

	public function index () {
		$member = Member::paginate(10);
		$group = UserGroup::get();
		$data = [
			'member' => $member,
			'group' => $group,
		];
		return $this->success($data);
	}

}
