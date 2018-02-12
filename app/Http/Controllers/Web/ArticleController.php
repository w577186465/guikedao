<?php

namespace App\Http\Controllers\Web;

use App\Article;
use App\Category;
use App\UserGroup;
use App\Member;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

class ArticleController extends ApiController {

	public function index(Request $req) {
		$catid = $req->input('catid', false);

		$where = [];
		if ($catid) {
			$where['category_id'] = $catid;
		}
		$article = Article::where($where)->orderBy('updated_at', 'desc')->paginate(10);
		$data = [
			'article' => $article,
		];

		return $this->success($data);
	}

	public function single(Request $req, $id) {
		if (!filled('openid')) {
			return $this->message('无权限，请登录。', 403);
		}

		$openid = $req->input('openid');
		
		$article = Article::find($id);

		// 判断文章是否允许初级会员访问
		$allow = false;
		$permissions = explode(',', $article->permission);
		foreach ($permissions as $key => $value) {
			if ($value == 1) {
				$allow = true;
				break;
			}
		}

		$user = Member::where('openid', $openid)->first();
		if ($user->status != 1 && !$allow) {
			return $this->message('无权限，请申请未高级会员', 401);
		}

		$article->view = $article->view + 1;

		if ($user->status == 1) {
			$article->gview = $article->gview + 1;
		}
		$article->save();

		return $this->success($article);
	}

	public function list() {
		$article = Article::orderBy('updated_at', 'desc')->paginate(10);
		return $this->success($article);
	}

	public function category() {
		$category = Category::orderBy('id', 'desc')->get();
		$data = [];
		foreach ($category as $key => $value) {
			$data[$value->id] = $value->name;
		}

		return $this->success($data);
	}

	// 添加页面数据
	public function add_data() {
		$category = Category::orderBy('updated_at', 'desc')->paginate(10);
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

}
