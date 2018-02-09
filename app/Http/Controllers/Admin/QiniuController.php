<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Storage;

class QiniuController extends ApiController {

	public function index(Request $req) {
		if (!$req->filled('name')) {
			return $this->failed('参数不正确');
		}

		$name = $req->input('name');
		$disk = Storage::disk('qiniu');
		$token = $disk->getDriver()->uploadToken($name);
		return $this->success($token);
	}

}
