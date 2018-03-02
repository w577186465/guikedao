<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVotesToMembersTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::table('members', function (Blueprint $table) {
			$table->integer("apply_id")->default(0);
			$table->integer("apply_status")->default(0);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table('members', function (Blueprint $table) {
			$table->dropColumn(['apply_id', 'apply_status']);
		});
	}
}
