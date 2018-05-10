<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MyQuan extends Model {
	public function quan() {
		return $this->hasOne('App\Quan', 'id', 'quan_id');
	}
}
