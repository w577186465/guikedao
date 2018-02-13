<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::middleware('auth:api')->get('/user', function (Request $request) {
	return $request->user();
});

Route::group(['namespace' => 'Admin', 'middleware' => ['auth:api', 'scope:admin']], function () {
	// 分类
	Route::get('/admin/category', 'CategoryController@index')->name('admin-category');
	Route::post('/admin/category/add', 'CategoryController@add')->name('admin-category-add');
	Route::post('/admin/category/edit', 'CategoryController@edit')->name('admin-category-edit');
	Route::get('/admin/category/delete/{id}', 'CategoryController@delete')->name('admin-category-delete');

	// 文章
	Route::get('/admin/article', 'ArticleController@index')->name('admin-article');
	Route::get('/admin/article/list', 'ArticleController@list')->name('admin-article-list');
	Route::get('/admin/article/add', 'ArticleController@add_data')->name('admin-article-add-data'); // 获取添加页面数据
	Route::get('/admin/article/edit/{id}', 'ArticleController@edit_data')->name('admin-article-edit-data'); // 获取修改页面数据
	Route::post('/admin/article/add', 'ArticleController@add')->name('admin-article-add'); // 提交添加
	Route::post('/admin/article/edit/{id}', 'ArticleController@edit')->name('admin-article-edit'); // 提交修改
	Route::get('/admin/article/delete/{id}', 'ArticleController@delete')->name('admin-article-delete');

	// 会员
	Route::get('/admin/member', 'UserController@index')->name('admin-member');
	Route::get('/admin/member/list', 'UserController@list')->name('admin-member-list');
	Route::get('/admin/member/examine', 'UserController@examine')->name('admin-member-examine');

	// 会员组
	Route::get('/admin/member/group', 'UserGroupController@index')->name('admin-usergroup');
	Route::post('/admin/member/group/add', 'UserGroupController@add')->name('admin-usergroup-add');
	Route::post('/admin/member/group/edit', 'UserGroupController@edit')->name('admin-usergroup-edit');
	Route::get('/admin/member/group/delete/{id}', 'UserGroupController@delete')->name('admin-usergroup-delete');

	// 七牛上传
	Route::post('/admin/qiniu/upload_token', 'QiniuController@index')->name('admin-qiniu-uploadtoken');

	// 本地上传
	Route::post('/admin/uploader', 'UploaderController@upload')->name('admin-uploader');
});

Route::group(['namespace' => 'Web', 'middleware' => ['weixin']], function () {
	// 文章
	Route::get('/article', 'ArticleController@index')->name('article'); // 列表
	Route::get('/article/{id}', 'ArticleController@single')->name('article-single')->where('id', '[0-9]+'); // 详情页
	Route::get('/article/category', 'ArticleController@category')->name('article-category'); // 文章分类

	// 会员
	Route::get('/member/{openid}', 'MemberController@item')->name('member-item');
	Route::post('/member/add', 'MemberController@add')->name('member-add');
	Route::post('/member/signup', 'MemberController@signup')->name('member-signup');

	Route::post('/uploader', 'UploaderController@upload')->name('uploader');
});

Route::get('/login', function () {
})->name('login'); // 登录

Route::get('/register', function () {
})->name('register'); // 注册