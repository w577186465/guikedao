<?php

namespace App\Http\Controllers\Quan;

use App\Http\Controllers\ApiController;
use App\Quan;
use Illuminate\Http\Request;

class IndexController extends ApiController {

	public function add(Request $req) {
		if (!$req->filled('name', 'money')) {
			return $this->failed("参数不正确");
		}

		$quan = new Quan;
		$quan->name = $req->input('name');
		$quan->money = $req->input('money');
		$res = $quan->save();
		if ($res) {
			return $this->message('success');
		}

		return $this->failed("发生未知错误，添加失败。");
	}

	public function edit(Request $req, $id) {
		$quan = Quan::find($id);
		$data = $req->only(['name', 'money']);
		foreach ($data as $key => $value) {
			$quan->$key = $value;
		}
		$res = $quan->save();
		if ($res) {
			return $this->message('success');
		}

		return $this->failed('发生未知错误，修改失败。');
	}

	public function list(Request $req) {
		$pagesize = $req->input('pagesize', 10);
		return Quan::orderBy('id', 'desc')->paginate($pagesize);
	}

	public function all(Request $req) {
		return Quan::orderBy('id', 'desc')->get();
	}

}
