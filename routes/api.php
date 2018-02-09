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

Route::group(['namespace' => 'Admin', 'middleware' => 'auth:api'], function () {
	// 分类
	Route::get('/admin/category', 'CategoryController@index')->name('admin-category');
	Route::post('/admin/category/add', 'CategoryController@add')->name('admin-category-add');
	Route::post('/admin/category/edit', 'CategoryController@edit')->name('admin-category-edit');
	Route::get('/admin/category/delete/{id}', 'CategoryController@delete')->name('admin-category-delete');

	// 文章
	Route::get('/admin/article', 'ArticleController@index')->name('admin-article');
	Route::get('/admin/article/add', 'ArticleController@add_data')->name('admin-article-add-data');

	// 会员
	Route::get('/admin/member', 'UserController@index')->name('admin-member');

	// 会员组
	Route::get('/admin/member/group', 'UserGroupController@index')->name('admin-usergroup');
	Route::post('/admin/member/group/add', 'UserGroupController@add')->name('admin-usergroup-add');
	Route::post('/admin/member/group/edit', 'UserGroupController@edit')->name('admin-usergroup-edit');
	Route::get('/admin/member/group/delete/{id}', 'UserGroupController@delete')->name('admin-usergroup-delete');

	// 七牛上传
	Route::post('/admin/qiniu/upload_token', 'QiniuController@index')->name('admin-qiniu-uploadtoken');
});

Route::get('/login', function () {

})->name('login'); // 分类