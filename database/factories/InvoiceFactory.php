<?php

use App\Invoice;
use Faker\Generator as Faker;
use App\Actions\StatusAction;

$factory->define(Invoice::class, function (Faker $faker) {
    $now = new \DateTime();
    $now = $now->format('Y-m-d H:i:s');
    return [
        'title' => $faker->name,
        'reference' => $faker->bothify('?###'),
        'client_id' => 1,
        'seller_id' => 1,
        'reference' => $faker->unique()->numerify('F####'),
        'state' => StatusAction::BDEFAULT(),
        'duedate' => date('Y-m-d H:i:s', strtotime('+ 30 days', strtotime($now))),
    ];
});
