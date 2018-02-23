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

Route::any('/wechat', 'Web\WeChatController@serve');

Route::group(['middleware' => ['wechat.oauth']], function () {
	Route::get('/login', 'Web\LoginController@login');
});

// Route::get('/login', 'Web\LoginController@login');

Route::get('/test', function () {
	$user = session('wechat.oauth_user');
	$user['default']['original']['openid'];
	print_r($user);
});