<?php

use App\Client;
use App\Seller;
use App\Product;
use App\Invoice;
use Illuminate\Database\Seeder;

class InvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $client = factory(Client::class)->create();
        $seller = factory(Seller::class)->create();
        for ($i = 1; $i < 6; $i++) {
            $invoice = factory(Invoice::class)->create([
                'title' => 'Factura ' . $i,
                'client_id' => $client->id,
                'seller_id' => $seller->id,
            ]);
            for ($j = 1; $j < 3; $j++) {
                $product = factory(Product::class)->create();
                $quantity = rand(1, 5);
                $invoice->products()->attach($product->id, [
                    'quantity' => $quantity,
                    'total_value' => $quantity + $product->price,
                    'unit_value' => $product->price,
                ]);
            }
            $invoice->update(
                [
                'subtotal' => $invoice->subtotal,
                'vat' => $invoice->vat,
                'total'=> $invoice->total
                ]
            );
            $invoice->update();
        }
    }
}
