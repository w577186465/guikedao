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
});

Route::get('/login', function () {

})->name('login'); // 分类