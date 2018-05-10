<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGiftsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('gifts', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('member_id')->index();
			$table->string('coding')->index();
			$table->integer('receiver')->nullable();
			$table->integer('status')->default(0);
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('gifts');
	}
}
