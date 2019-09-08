<?php

use Faker\Generator as Faker;

$factory->define(App\Organization::class, function (Faker $faker) {
    return [
        'title' => $faker->company,
        'country' => $faker->country,
        'city' => $faker->city
    ];
});
