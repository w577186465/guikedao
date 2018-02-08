<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\ApiController;
use App\UserGroup;
use Illuminate\Http\Request;

class UserController extends ApiController {

	public function index () {
		$group = UserGroup::get();
		$data = [
			'group' => $group,
		];
		return $this->success($data);
	}

}
