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
    Route::get('/login', function () {
        $user = session('wechat.oauth_user'); // 拿到授权用户资料
        $openid = $user['default']['original']['openid'];
        ?>
        	<script>
        		window.localStorage.openid = '<?php echo $openid; ?>';
        		window.location.href = '/#/sign/center';
        	</script>
        <?php
    });
});