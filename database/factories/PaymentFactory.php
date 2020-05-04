<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Payment;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(Payment::class, function (Faker $faker) {

    return [
        'invoice_id' => 1,
        'status' => 'status test',
        'reason' => 'reason test',
        'message' => 'message test',
        'request_id' => $faker->bothify('?###'),
        'processUrl' => 'url test' . $faker->bothify('?###'),
        'payment_date' => Carbon::now()->format('Y-m-d H:i:s'),
    ];
});
