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
	Route::get('/category', 'CategoryController@index')->name('admin-category');
	Route::post('/category/add', 'CategoryController@add')->name('admin-category-add');

	// 文章
	Route::get('/article/add', 'ArticleController@add_data')->name('admin-article-add-data');

	// 会员
	Route::get('/member/group', 'UserGroupController@index')->name('admin-usergroup');
	Route::post('/member/group/add', 'UserGroupController@add')->name('admin-usergroup-add');
});

Route::get('/login', function () {

})->name('login'); // 分类