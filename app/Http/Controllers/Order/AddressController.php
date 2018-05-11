<?php

namespace App\Http\Controllers\Order;

use App\Address;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

class AddressController extends ApiController {

	public function add(Request $req) {
		if (!$req->filled('name', 'tel', 'region', 'address', 'zip')) {
			return $this->failed('参数不正确');
		}

		$data = $req->only('name', 'tel', 'region', 'address', 'zip');
		$mid = $req->member->id;
		$address = new Address;
		$address->member_id = $mid;
		foreach ($data as $key => $value) {
			$address->$key = $value;
		}

		$res = $address->save();
		if ($res) {
			return $this->message('success');
		}

		return $this->failed('发生未知错误，操作失败。');
	}

	public function myaddress(Request $req) {
		$mid = $req->member->id;
		return Address::where('member_id', $mid)->get();
	}

	public function address(Request $req, $id) {
		$mid = $req->member->id;
		$address = Address::find($id);
		if ($address->member_id != $mid) {
			return;
		}

		return $address;
	}

	public function edit(Request $req, $id) {
		$mid = $req->member->id;
		$address = Address::find($id);
		if ($address->member_id != $mid) {
			return;
		}

		$data = $req->only('name', 'tel', 'address', 'zip');
		if (empty($data)) {
			return $this->failed('参数不正确');
		}
		foreach ($data as $key => $value) {
			$address->$key = $value;
		}

		if ($req->filled('region')) {
			$address->region = $req->input('region');
		}

		$res = $address->save();
		if ($res) {
			return $this->message('success');
		}

		return $this->failed('发生未知错误，操作失败。');
	}

	public function destroy(Request $req, $id) {
		$mid = $req->member->id;
		$address = Address::find($id);
		if ($address->member_id != $mid) {
			return;
		}

		return Address::destroy($id);
	}

}
