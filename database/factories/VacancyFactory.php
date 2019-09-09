<?php

use Faker\Generator as Faker;

$factory->define(App\Vacancy::class, function (Faker $faker) {
    return [
        'vacancy_name' => $faker->jobTitle,
        "workers_amount" => $faker->numberBetween(0,5),
        "salary" => $faker->numberBetween(400, 1000)
    ];
});
