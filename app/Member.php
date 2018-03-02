<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Member extends Model {
	public function group() {
		return $this->hasOne('App\UserGroup', 'id', 'status');
	}

	public function apply() {
		return $this->hasOne('App\UserGroup', 'id', 'apply_id');
	}
}
