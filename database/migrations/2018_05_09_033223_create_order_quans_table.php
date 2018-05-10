<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderQuansTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('order_quans', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->integer('order_id')->index();
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
		Schema::dropIfExists('order_quans');
	}
}
