<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('orders', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('member_id')->index();
			$table->string('coding')->index();
			$table->integer('status')->index(); // 订单状态
			$table->string('order_type')->index(); // 订单类型 快递或到店
			$table->string('adress')->nullable(); // 快递地址
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('orders');
	}
}
