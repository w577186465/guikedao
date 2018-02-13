<?php

/*
 * This file is part of the overtrue/laravel-wechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Http\Middleware;

use Closure;
use http\Env\Request;

/**
 * Class OAuthAuthenticate.
 */
class OAuthWeixin {
	/**
	 * Handle an incoming request.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param \Closure                 $next
	 * @param string|null              $scopes
	 *
	 * @return mixed
	 */
	public function handle($request, Closure $next) {
		$user = session('wechat.oauth_user');
        $openid = $user['default']['original']['openid'];

        $Authorization = $user['default']['original']['openid'];

		if ($user && $Authorization == $request->header('Authorization')) {
			return $next($request);
		} else {
			$res = array('msg' => '无权限');
			return response($res, 401);
		}

	}

}