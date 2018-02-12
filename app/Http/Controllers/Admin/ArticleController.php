<?php

namespace App\Http\Controllers\Admin;

use App\Article;
use App\Category;
use App\UserGroup;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

class ArticleController extends ApiController {

	public function index() {
		$article = Article::orderBy('id', 'desc')->paginate(10);
		$category = Category::paginate(10);
		$data = [
			'article' => $article,
			'category' => $category,
		];
		return $this->success($data);
	}

	public function list() {
		$article = Article::orderBy('id', 'desc')->paginate(10);
		return $this->success($article);
	}

	// 添加页面数据
	public function add_data() {
		$category = Category::orderBy('id', 'desc')->paginate(10);
		$usergroup = UserGroup::get();
		$data = [
			'category' => $category,
			'group' => $usergroup,
		];
		return $this->success($data);
	}

	// 提交添加
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

	// 修改页面数据
	public function edit_data($id) {
		$article = Article::find($id);
		$permission = explode(',', $article->permission);

		foreach ($permission as $key => $value) {
			$permission[$key] = (int)$value;
		}

		$article->permission = $permission;
		
		$category = Category::get();
		$group = UserGroup::get();
		$data = [
			'article' => $article,
			'category' => $category,
			'group' => $group,
		];
		return $this->success($data);
	}

	// 提交添加
	public function edit(Request $req, $id) {
		if (!$req->has(['category_id', 'title', 'thumb', 'description', 'content', 'permission'])) {
			return $this->failed('信息录入不正确');
		}

		$permission = implode($req->input('permission'), ',');

		$m = Article::find($id);
		$m->category_id = $req->input('category_id');
		$m->title = $req->input('title');
		$m->thumb = $req->input('thumb');
		$m->description = $req->input('description');
		$m->content = $req->input('content');
		$m->permission = $permission;
		$res = $m->save();
		if ($res) {
			return $this->message('修改成功');
		}

		return $this->failed('修改失败');
	}

	public function delete($id) {
		$res = Article::destroy($id);
		if ($res) {
			return $this->message('删除成功');
		}

		return $this->failed('删除失败');
	}

}
