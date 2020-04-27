<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Seller;
use Faker\Generator as Faker;
use Faker\Provider\es_Es\Person;

$factory->define(Seller::class, function (Faker $faker) {
    $faker->addProvider(new Person($faker));
    return [
        'documentType' => 'CC',
        'document' => $faker->unique()->ean8,
        'name' => $faker->name,
        'surname' => $faker->lastname,
        'company' => $faker->company,
        'country' => $faker->country,
        'department' => $faker->state,
        'city' => $faker->city,
        'address' => $faker->streetAddress,
        'mobile' => $faker->isbn10,
    ];
});
