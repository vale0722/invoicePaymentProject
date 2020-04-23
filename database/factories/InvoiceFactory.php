<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Invoice;
use Faker\Generator as Faker;

$factory->define(Invoice::class, function (Faker $faker) {
    $now = new \DateTime();
    $now = $now->format('Y-m-d H:i:s');
    return [
        'reference' => $faker->unique()->numerify('F####'),
        'state' => 'Por Defecto',
        'duedate' => date('Y-m-d H:i:s', strtotime('+ 30 days', strtotime($now))),
    ];
});
