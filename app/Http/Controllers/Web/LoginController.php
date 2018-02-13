<?php

namespace App\Http\Controllers\Web;

use App\Member;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{

    /**
     * 处理微信的请求消息
     *
     * @return string
     */
    public function login() {
        $user = session('wechat.oauth_user'); // 拿到授权用户资料
        $openid = $user['default']['original']['openid'];

        // 查找用户
        $member = Member::where('openid', $openid)->first();
        // 不存在用户时新增用户
        if (!$member) {
            $m = new Member;
            $m->openid = $openid;
            $m->save();
        }
        ?>
          <script>
            window.localStorage.openid = '<?php echo $openid; ?>';
            window.location.href = '/#/sign/center';
          </script>
        <?php
    });
}