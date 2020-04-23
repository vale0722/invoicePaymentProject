<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Client;
use Faker\Generator as Faker;
use Faker\Provider\es_Es\Person;

$factory->define(Client::class, function (Faker $faker) {
    $faker->addProvider(new Person($faker));
    return [
        'documentType' => 'CC',
        'document' => $faker->unique()->ean8,
        'name' => $faker->name,
        'surname' => $faker->lastname,
        'country' => $faker->country,
        'department' => $faker->state,
        'city' => $faker->city,
        'email' => $faker->unique()->email,
        'address' => $faker->streetAddress,
        'mobile' => $faker->isbn10,
    ];
});
