<?php

namespace App\Http\Controllers\Admin;

use App\Article;
use App\Http\Controllers\ApiController;
use App\Member;
use Illuminate\Http\Request;

class IndexController extends ApiController {

	public function index(Request $req) {
		$data = [];
		$data['count'] = Member::where('status', '>', -1)
			->where('status', '<', 2)
			->count();
		$data['p_count'] = Member::where('status', 0)->count();
		$data['g_count'] = $data['count'] - $data['p_count'];

		$data['article'] = Article::limit(8)->orderBy('view', 'desc')->get();
		return $this->success($data);
	}

}
