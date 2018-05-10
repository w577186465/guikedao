<?php

namespace App\Http\Controllers\Quan;

use App\Gift;
use App\MyQuan;
use App\Quan;
use Carbon\Carbon;

class QuanService {

	/*
		    $quans 格式 [[quan_id => ,]]
	*/

	static $my_quans;

	private static function success() {
		return [
			'status' => 'success',
		];
	}

	private static function failed($msg) {
		return [
			'status' => 'error',
			'message' => $msg,
		];
	}

	public static function handle($t = 'add', $mid, $quans) {
		// 获取目标卡券ids
		$quanIds = [];
		foreach ($quans as $key => $value) {
			$quanIds[] = $value['quan_id'];
		}

		self::$my_quans = self::get_my_quans($mid, $quanIds);
		if ($t == 'minus') {
			// 判断卡券是否合法
			if (!self::is_myquan($mid, $quanIds)) {
				return self::failed('卡券不合法');
			}

			// 判断卡券数量
			if (!self::quan_true($mid, $quans)) {
				return self::failed('卡券不足');
			}
		}

		$data = self::$my_quans; // 目标卡券数据

		foreach ($quans as $key => $value) {
			// 存在更新
			if (isset($data[$value['quan_id']])) {
				$my_quan_id = $data[$value['quan_id']]->id;
				$quan = MyQuan::find($my_quan_id);

				// 判断操作类型
				if ($t == 'add') {
					$quan->num = $quan->num + $value['num']; // 增加卡券
				}
				if ($t == 'minus') {
					// 减少
					$quan->num = $quan->num - $value['num']; // 减少卡券
				}
				$res = $quan->save();
			} else {
				// 会员无此卡券 减少时跳过，增加时新增
				if ($t == 'minus') {
					continue;
				}
				$quan = new MyQuan;
				$quan->user_id = $mid;
				$quan->quan_id = $id;
				$quan->num = $value['num'];
				$res = $quan->save();
			}
		}

		return self::success();
	}

	static function is_myquan($mid, $ids) {
		if (count(self::$my_quans) == count($ids)) {
			return true;
		}

		return false;
	}

	static function quan_true($mid, $quans) {
		$my_quans = self::$my_quans;
		foreach ($quans as $key => $value) {
			$mynum = $my_quans[$value['quan_id']]->num;
			if ($mynum < $value['num']) {
				return false;
			}
		}

		return true;
	}

	// 让数据以id作为键名
	static function get_my_quans($mid, $ids) {
		$data = MyQuan::where('user_id', $mid)->whereIn('quan_id', $ids)->get();
		$res = [];
		foreach ($data as $key => $value) {
			$res[$value->quan_id] = $value;
		}

		return $res;
	}

	public static function minus($mid, $quans) {
		return self::handle('minus', $mid, $quans);
	}

	public static function add($mid, $quans) {
		return self::handle('add', $mid, $quans);
	}

	// 礼包退回
	public static function gift_back($mid) {
		$yesterday = Carbon::now()->subDays(1);
		$timeouts = Gift::where('member_id', $mid)->where('status', 0)->where('created_at', '<', $yesterday)->get();
		foreach ($timeouts as $key => $value) {
			$gift = Gift::find($value->id);
			self::add($mid, $gift->quans);
			$gift->status = 2;
			$gift->save();
		}
	}
}
