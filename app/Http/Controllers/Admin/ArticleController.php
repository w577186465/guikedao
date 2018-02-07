<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

class ArticleController extends ApiController {

	public function add_data() {
		$category = Category::paginate(10);
		$data = [
			'category' => $category
		];
		return $this->success($data);
	}

	public function add(Request $req) {

	}

}
