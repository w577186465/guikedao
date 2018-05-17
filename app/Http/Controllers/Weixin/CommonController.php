<?php

namespace App\Http\Controllers\Weixin;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

class CommonController extends ApiController {

	public function jssdk_config(Request $req) {
		$jsApiList = $req->input('jsApiList', []);
		$app = app('wechat.official_account');
		if ($req->filled('url')) {
			$app->jssdk->setUrl($req->input('url'));
		}
		$config = $app->jssdk->buildConfig($jsApiList, false);
		return $config;
	}

}
