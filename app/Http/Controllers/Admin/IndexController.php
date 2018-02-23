<?php

namespace App\Http\Controllers\Admin;

use App\Article;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

class IndexController extends ApiController {

	public function index(Request $req) {
		$data = [];
		$data['article'] = Article::limit(8)->orderBy('view', 'desc')->get();
		return $this->success($data);
	}

}
