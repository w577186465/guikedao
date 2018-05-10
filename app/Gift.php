<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gift extends Model {
	public function quans() {
		return $this->hasMany('App\GiftQuan');
	}

	public function member() {
		return $this->hasOne('App\Member', 'id', 'member_id');
	}

	public function receive() {
		return $this->hasOne('App\Member', 'id', 'receiver');
	}
}
