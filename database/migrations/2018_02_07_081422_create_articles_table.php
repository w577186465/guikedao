<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('articles', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('category_id')->index();
			$table->string('title')->index();
			$table->string('thumb');
			$table->string('description');
			$table->mediumText('content');
			$table->string('permission')->index();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('articles');
	}
}
