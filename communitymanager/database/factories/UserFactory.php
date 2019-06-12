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

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => bcrypt('password'),
        'mobile'=> $faker->e164PhoneNumber,
        'role' => rand(0,1),
        'photo'=> $faker->unique()->imageUrl($width = 640, $height = 480 ,'people'), 
        'remember_token' => str_random(10),
    ];
});
