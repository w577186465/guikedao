<?php

use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		DB::table('categories')->insert([
			'name' => '风水',
			'alias' => 'fengshui',
			'pid' => 0,
		]);
		DB::table('categories')->insert([
			'name' => '国学',
			'alias' => 'guoxue',
			'pid' => 0,
		]);
	}
}
