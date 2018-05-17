<?php

namespace App\Http\Controllers\Quan;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Quan\QuanService;
use App\Member;
use App\MyQuan;
use Illuminate\Http\Request;

class MemberController extends ApiController {

	public function all(Request $req) {
		$userid = $req->member->id;
		QuanService::gift_back($userid);
		return MyQuan::with('quan')->where('user_id', $userid)->orderBy('id', 'desc')->get();
	}

	public function share() {
		$app = app('wechat.official_account');
		$app->setUrl('http://zunyu.weixin.dlwanglong.com');
		$config = $app->jssdk->buildConfig(array('onMenuShareAppMessage'), false);
		$values = [
			'config' => $config,
		];
		return view('quan_share', $values);
	}

	// public function send(Request $req) {
	// 	if (!$req->filled('quans')) {
	// 		return $this->failed('请选择卡券');
	// 	}

	// 	if (!$req->filled('tel')) {
	// 		return $this->failed('请填写被赠者手机号码');
	// 	}

	// 	$tel = $req->input('tel');
	// 	$quans = $req->input('quans');

	// 	if ($tel == $req->member->tel) {
	// 		return $this->failed('不能赠送给自己');
	// 	}

	// 	// 查找会员
	// 	$hasTel = Member::where('tel', $tel)->first();
	// 	if (is_null($hasTel)) {
	// 		return $this->failed('该会员不存在，请确保被赠者手机号码正确。<br>温馨地址：可在右下角我中查看会员电话。');
	// 	}

	// 	$quanIds = [];
	// 	foreach ($quans as $key => $value) {
	// 		$quanIds[] = $value['quan_id'];
	// 	}

	// 	// 获取赠送者卡券
	// 	$mid = $req->member->id;
	// 	$active = MyQuan::where('user_id', $mid)->whereIn('id', $quanIds)->get();
	// 	$activeKeyById = [];
	// 	foreach ($active as $key => $value) {
	// 		$activeKeyById[$value->quan_id] = $value;
	// 	}

	// 	// 获取被赠者卡券
	// 	$passive = MyQuan::where('user_id', $hasTel->id)->whereIn('id', $quanIds)->get();
	// 	// 以卡券id为键名
	// 	$passiveKeyById = [];
	// 	foreach ($passive as $key => $value) {
	// 		$passiveKeyById[$value->quan_id] = $value;
	// 	}

	// 	foreach ($quans as $key => $value) {
	// 		// 保存赠送者
	// 		$activeSaved = $this->quan_minus($activeKeyById, $value);
	// 		if (!$activeSaved) {
	// 			continue;
	// 		}
	// 		$passiveSaved = $this->quan_add($passiveKeyById, $value, $hasTel->id);
	// 	}

	// 	return $this->message('success');
	// }

	// private function quan_add($passiveKeyById, $value, $mid) {
	// 	$quan_id = $value['quan_id'];
	// 	if (isset($passiveKeyById[$quan_id])) {
	// 		$my_quan_id = $passiveKeyById[$quan_id]->id;
	// 		$quan = MyQuan::find($my_quan_id);
	// 		$quan->num = $quan->num + $value['num'];
	// 		return $quan->save();
	// 	} else {
	// 		$quan = new MyQuan;
	// 		$quan->user_id = $mid;
	// 		$quan->quan_id = $quan_id;
	// 		$quan->num = $value['num'];
	// 		$res = $quan->save();
	// 	}
	// }

	// private function quan_minus($activeKeyById, $value) {
	// 	$quan_id = $value['quan_id'];
	// 	$my_quan_id = $activeKeyById[$quan_id]->id;
	// 	$quan = MyQuan::find($my_quan_id);
	// 	$quan->num = $quan->num - $value['num'];
	// 	if ($quan->num < 0) {
	// 		return false;
	// 	}
	// 	return $quan->save();
	// }

}
