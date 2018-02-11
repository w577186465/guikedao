<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Article::class, function (Faker $faker) {
    return [
        'title' => $faker->text,
        'thumb' => $faker->text,
        'description' => $faker->imageUrl(),
        'content' => $faker->text,
        'category_id' => 2,
        'permission' => '2',
    ];
});
