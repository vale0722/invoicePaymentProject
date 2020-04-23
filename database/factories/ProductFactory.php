<?php

use App\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'sku' => $faker->unique()->numerify('S#K###'),
        'name' => $faker->jobTitle,
        'category' => $faker ->jobTitle,
        'price' => rand(1000, 10000000),
    ];
});
