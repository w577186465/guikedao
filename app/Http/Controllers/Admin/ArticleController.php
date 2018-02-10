<?php

namespace App\Http\Controllers\Admin;

use App\Article;
use App\Category;
use App\Http\Controllers\ApiController;
use App\UserGroup;
use Illuminate\Http\Request;

class ArticleController extends ApiController {

	public function index() {
		$article = Article::paginate(10);
		$category = Category::paginate(10);
		$data = [
			'articles' => $article,
			'category' => $category,
		];
		return $this->success($data);
	}

	public function add_data() {
		$category = Category::paginate(10);
		$usergroup = UserGroup::get();
		$data = [
			'category' => $category,
			'group' => $usergroup,
		];
		return $this->success($data);
	}

	public function add(Request $req) {
		if (!$req->has(['category_id', 'title', 'thumb', 'description', 'content', 'permission'])) {
			return $this->failed('信息录入不正确');
		}

		$permission = implode($req->input('permission'), ',');

		$m = new Article;
		$m->category_id = $req->input('category_id');
		$m->title = $req->input('title');
		$m->thumb = $req->input('thumb');
		$m->description = $req->input('description');
		$m->content = $req->input('content');
		$m->permission = $permission;
		$res = $m->save();
		if ($res) {
			return $this->message('添加成功');
		}

		return $this->failed('添加失败');
	}

	public function delete($id) {
		$res = Article::destroy($id);
		if ($res) {
			return $this->message('删除成功');
		}

		return $this->failed('删除失败');
	}

}
