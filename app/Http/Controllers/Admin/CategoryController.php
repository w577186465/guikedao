<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

class CategoryController extends ApiController {

	public function index() {
		$data = Category::paginate(10);
		return $this->success($data);
	}

	public function add(Request $req) {
		if (!$req->filled('name') || !$req->filled('alias')) {
			return $this->failed('信息填写不正确');
		}

		$cat = new Category;
		$cat->name = $req->input('name');
		$cat->alias = $req->input('alias');
		$cat->pid = $req->input('pid', 0);
		$res = $cat->save();

		if ($res) {
			return $this->success('添加成功');
		}

		return $this->failed('添加失败');
	}

}
