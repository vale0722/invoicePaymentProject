<?php

namespace Tests\Feature\Invoice;

use App\Client;
use App\Seller;
use App\Invoice;
use App\Product;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StoreInvoiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function canSeeCreateInvoiceView()
    {
        $this->get(route('invoice.create'))->assertViewIs('invoices.create');
    }

    /**
     * @test
     */
    public function canCreateAnInvoice()
    {
        $client = factory(Client::class)->create();
        $seller = factory(Seller::class)->create();
        $product = factory(Product::class)->create();
        $this->post(route('invoice.store'), [
            'reference' => '#RT',
            'title' => 'Invoice test',
            'client' => $client->id,
            'seller' => $seller->id,
            'product' => $product->id,
            'quantity' => '3'
        ])
        ->assertRedirect()
        ->assertSessionHasNoErrors();
        $this->assertDatabaseHas('invoices', [
            'reference' => '#RT',
            'title' => 'Invoice test'
        ]);
    }

    /**
     * @test
     */
    public function canCreateAnInvoiceProduct()
    {
        $client = factory(Client::class)->create();
        $seller = factory(Seller::class)->create();
        $invoice = factory(Invoice::class)->create();
        $product = factory(Product::class)->create();
        $this->post(route('invoice.product.store', $invoice), [
            'product' => $product->id,
            'quantity' => '3',
        ])
            ->assertRedirect()
            ->assertSessionHasNoErrors();
        $this->assertDatabaseHas('invoice_product', [
            'invoice_id' => $invoice->id,
            'product_id' => $product->id,
            'quantity' => '3'
        ]);
    }
}
