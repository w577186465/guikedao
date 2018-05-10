<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('/', function () {
	return view('welcome');
});

Route::group([], function () {
	Route::group(['namespace' => 'Quan'], function () {
		Route::get('/quan/share', 'MemberController@share')->name('quan/share');
	});
});

Route::any('/wechat', 'Web\WeChatController@serve');