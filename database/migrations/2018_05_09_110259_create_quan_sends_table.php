<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuanSendsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('gift_quans', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->integer('gift_id')->index();
			$table->integer('quan_id')->index();
			$table->integer('num');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('gift_quans');
	}
}
