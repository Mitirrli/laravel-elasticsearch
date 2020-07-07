<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
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

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'age' => $faker->numberBetween(5, 100),
        'city' => $faker->city,
        'introduction' => $faker->unique()->text(100),
        'created_at' => $faker->dateTimeBetween('-3 year', '-1 year'),
        'updated_at' => $faker->dateTimeBetween('-1 year', '-5 month'),
    ];
});
