<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		DB::table('users')->insert([
			'name' => 'admin',
			'email' => 'passwoo@163.com',
			'password' => bcrypt('admin'),
		]);
	}
}
