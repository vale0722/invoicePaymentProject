<?php

namespace Tests\Feature\Invoice;

use App\Client;
use App\Seller;
use App\Invoice;
use App\Product;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShowInvoiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function YouCanSeeAnInvoice()
    {
        $invoice = factory(Invoice::class)->create();
        $response = $this->get(route('invoice.show', $invoice));
        $response->assertSuccessful();
        $response->assertViewHas('invoice');
    }

    /**
     * @test
     */
    public function YouCanSeeDetailsOfAnInvoice()
    {
        $invoice = factory(Invoice::class)->create();
        $response = $this->get(route('invoice.show', $invoice));
        $response->assertSuccessful();
        $response->assertSeeText($invoice->title);
        $response->assertSeeText($invoice->reference);
        $response->assertSeeText($invoice->client->document);
        $response->assertSeeText($invoice->seller->document);
    }

    /**
     * @test
     */
    public function YouCanSeeTheProductsOfAnInvoice()
    {
        $invoice = factory(Invoice::class)->create();
        for ($j = 1; $j < 3; $j++) {
            $product = factory(Product::class)->create();
            $quantity = rand(1, 5);
            $invoice->products()->attach($product->id, [
                'quantity' => $quantity,
                'total_value' => $quantity * $product->price,
                'unit_value' => $product->price,
            ]);
        }
        $response = $this->get(route('invoice.show', $invoice));
        $response->assertSuccessful();
        foreach ($invoice->products() as $product) {
            $response->assertSeeText($product);
        }
    }
}
