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
        'email' => $faker->unique()->safeEmail,
        'password' => bcrypt('111111'), // secret
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'country' => $faker->country,
        'city' => $faker->city,
        'phone' => $faker->phoneNumber,
        'role' => $faker->randomElement($array = array ('worker','employer'))

    ];
});
