<?php

use Faker\Generator as Faker;

$factory->define(App\Application::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
    ];
});
