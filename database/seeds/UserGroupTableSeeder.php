<?php

use Illuminate\Database\Seeder;

class UserGroupTableSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		DB::table('user_groups')->insert([
			'name' => '管理员',
			'alias' => 'admin',
		]);
	}
}
