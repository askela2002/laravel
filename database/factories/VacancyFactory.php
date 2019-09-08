<?php

use Faker\Generator as Faker;

$factory->define(App\Vacancy::class, function (Faker $faker) {
    return [
        'vacancy_name' => $faker->jobTitle,
        "workers_amount" => $faker->numberBetween(1,10),
        "salary" => $faker->numberBetween(400, 1000)
    ];
});
