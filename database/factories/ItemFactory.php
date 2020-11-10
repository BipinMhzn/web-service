<?php

/** @var Factory $factory */

use App\Item;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Item::class, function (Faker $faker) {
    return [
        'name' => $faker->firstName,
        'description' => $faker->sentence,
        'rate' => $faker->numberBetween(100, 1000),
    ];
});
