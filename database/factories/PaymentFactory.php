<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Payment;
use Faker\Generator as Faker;

$factory->define(Payment::class, function (Faker $faker) {
    $now = new \DateTime();
    $now = $now->format('Y-m-d H:i:s');
    return [
        'invoice_id' => 1,
        'status' => 'status test',
        'reason' => 'reason test',
        'message' => 'message test',
        'request_id' => $faker->bothify('?###'),
        'processUrl' => 'url test' . $faker->bothify('?###'),
        'payment_date' => $now,
    ];
});
