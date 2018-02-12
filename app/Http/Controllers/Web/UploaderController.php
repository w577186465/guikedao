<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

class UploaderController extends ApiController {

	public function upload(Request $req) {
		$file = $req->file('file');
		$date = date("Y/m");
		$path = $file->store('images/' . $date);
		$path = env('APP_URL') . '/storage/' . $path;
		return $this->success($path);
	}

}