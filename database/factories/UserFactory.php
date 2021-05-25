<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

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
        'mobile' => $faker->unique()->safeEmail,
        'password' => $faker->password,
        'openid' => $faker->unique()->safeEmail,
        'session_key' => $faker->session_key,
        'remember_token' => Str::random(10),
    ];
});
