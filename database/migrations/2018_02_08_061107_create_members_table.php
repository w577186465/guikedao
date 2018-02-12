<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembersTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('members', function (Blueprint $table) {
			$table->increments('id');
			$table->string('openid')->unique();
			$table->string('avatar')->default('');
			$table->string('name')->index()->default('');
			$table->integer('sex')->index()->default(0);
			$table->bigInteger('tel', 11)->index()->default(0);
			$table->integer('province')->index()->default(0);
			$table->integer('city')->index()->default(0);
			$table->integer('region')->index()->default(0);
			$table->string('regiondesc')->default('');
			$table->string('adress')->default('');
			$table->string('certnumber')->index()->default('');
			$table->integer('status')->index()->default(0); // 0普通会员 1高级会员 2审核中 -1 审核驳回
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('members');
	}
}
