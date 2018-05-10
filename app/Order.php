<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model {
	public function quan() {
		// return $this->hasMany('App\OrderQuan', 'id', 'order_id');
		return $this->hasMany('App\OrderQuan');
	}

	public function wuliu() {
		return $this->hasOne('App\OrderWuliu');
	}

	public function member() {
		return $this->hasOne('App\Member', 'id', 'member_id');
	}
}
