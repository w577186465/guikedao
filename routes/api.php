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

// 后台
Route::group(['middleware' => ['auth:api', 'scope:admin']], function () {
	// 首页
	Route::group(['namespace' => 'User'], function () {
		Route::get('/admin/index', 'IndexController@index')->name('admin-index');
	});

	// 会员
	Route::group(['namespace' => 'User'], function () {
		// 管理员
		Route::post('/admin/user/change', 'UserController@user_change')->name('admin-user-change'); // 改改管理员信息

		// 会员
		Route::get('/admin/member', 'UserController@index')->name('admin-member');
		Route::get('/admin/member/list', 'MemberController@list')->name('admin-member-list');
		Route::post('/admin/member/edit/{id}', 'MemberController@edit')->name('admin-member-edit');
	});

	// 卡券
	Route::group(['namespace' => 'Quan'], function () {
		Route::post('/admin/quan/add', 'IndexController@add')->name('admin-quan-add'); // 新增卡券
		Route::post('/admin/quan/edit/{id}', 'IndexController@edit')->name('admin-quan-edit'); // 修改卡券
		Route::get('/admin/quan/list', 'IndexController@list')->name('admin-quan-list'); // 卡券列表 分页
		Route::get('/admin/quan/all', 'IndexController@all')->name('admin-quan-all'); // 卡券列表 所有

		Route::post('/admin/user_quan/add', 'UserController@add')->name('admin-quan-add'); // 赠送卡券
		// Route::post('/admin/user_quan/edit/{id}', 'UserController@edit')->name('admin-quan-edit'); // 修改卡券
		Route::get('/admin/user_quan/all/{id}', 'UserController@all')->name('admin-quan-all'); // 卡券列表 全部
	});

	// 订单
	Route::group(['namespace' => 'Order'], function () {
		Route::get('/admin/order/list', 'OrderController@list')->name('admin-order-list');
		Route::get('/admin/order/address/{id}', 'OrderController@address')->name('admin-order-wuliu'); // 到店发货
		Route::get('/admin/order/send_out/{id}', 'OrderController@send_out')->name('admin-order-sendout'); // 到店发货
		Route::post('/admin/order/express_send_out/{id}', 'OrderController@express_send_out')->name('admin-order-express-sendout'); // 到店发货
	});

	// 文件上传
	Route::group(['namespace' => 'Uploader'], function () {
		// 七牛上传
		Route::post('/admin/qiniu/upload_token', 'QiniuController@index')->name('admin-qiniu-uploadtoken');

		// 本地上传
		Route::post('/admin/uploader', 'UploaderController@upload')->name('admin-uploader');
	});
});

// 微信登录可访问
Route::group(['middleware' => ['web', 'weixin']], function () {
	Route::group(['namespace' => 'Quan'], function () {
		Route::get('/my_quan/all', 'MemberController@all')->name('admin-quan-all'); // 卡券列表 全部
		// Route::post('/my_quan/send', 'MemberController@send')->name('admin-quan-send'); // 卡券列表 全部
		Route::post('/gift/produce', 'GiftController@produce')->name('gift-produce'); // 生成礼包
		Route::get('/gift/{id}', 'GiftController@gift')->where(['id' => '[0-9]+'])->name('gift-info'); // 获取礼包信息
		Route::get('/gift/coding/{coding}', 'GiftController@gift_bycoding')->name('gift-info-bycoding'); // 通过单号获取
		Route::get('/gift/receive/{coding}', 'GiftController@receive')->name('gift-bycoding'); // 领取礼包
		Route::get('/gift/list', 'GiftController@list')->name('my-gift-list'); // 领取礼包
	});

	Route::group(['namespace' => 'Order'], function () {
		// Route::get('/order/adress', 'OrderController@address')->name('admin-quan-all');
		Route::post('/order/add_order', 'OrderController@add_order')->name('add-order'); // 用户提交订单
		Route::get('/order/myorder', 'OrderController@myorder')->name('my-order'); // 用户订单记录
		Route::get('/order/confirm/{id}', 'OrderController@confirm')->name('order-confirm');
		Route::get('/order/cancel/{id}', 'OrderController@cancel')->name('order-cancel'); // 取消订单

		// 收货地址
		Route::post('/address/add', 'AddressController@add')->name('address-add');
		Route::post('/address/edit/{id}', 'AddressController@edit')->name('address-edit');
		Route::get('/address/destroy/{id}', 'AddressController@destroy')->name('address-destroy');
		Route::get('/address/info/{id}', 'AddressController@address')->name('address');
		Route::get('/address/myaddress', 'AddressController@myaddress')->name('myaddress');
	});

	Route::group(['namespace' => 'Weixin'], function () {
		Route::post('/weixin/jssdk_config', 'CommonController@jssdk_config')->name('weixin-jssdk-config');
	});
});

Route::group(['middleware' => ['web', 'wechat.oauth']], function () {
	Route::get('/member/register', 'User\MemberController@register')->name('member-register'); // 注册
	Route::get('/member/login', 'User\MemberController@login')->name('member-login');
});

Route::get('/register', function () {
})->name('register'); // 注册

Route::get('/test', function (Request $request) {
	print_r($request->fullUrl());
})->name('test'); // 注册

Route::get('/sign-in', function () {
})->name('login');
