<?php
use App\Client;
use App\Seller;
use App\Invoice;
use Carbon\Carbon;
use Faker\Generator as Faker;

/** @var Factory $factory */

$factory->define(Invoice::class, function (Faker $faker) {
    $now = Carbon::now()->format('Y-m-d H:i:s');
    return [
        'title' => $faker->name,
        'client_id' => factory(Client::class)->create(),
        'seller_id' => factory(Seller::class)->create(),
        'reference' => $faker->unique()->numerify('F####'),
        'duedate' => date('Y-m-d H:i:s',
            strtotime('+ 30 days', strtotime($now))),
    ];
});
$factory->state(Invoice::class, 'annulate', [
       'annulate' => 'motivo x',
    ]);
