<?php

namespace Tests\Feature\Invoice;

use App\Client;
use App\Seller;
use App\Invoice;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AnnuleInvoiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function canAnnulAnInvoice()
    {
        $client = factory(Client::class)->create();
        $seller = factory(Seller::class)->create();
        $invoice = factory(Invoice::class)->create();
        $this->post(route('invoice.annulate', $invoice), [
            'reason' => 'Motivo x'
        ])
            ->assertRedirect()
            ->assertSessionHasNoErrors();
        $this->assertDatabaseHas('invoices', [
            'id' => $invoice->id,
            'annulate' => 'Motivo x'
        ]);
    }

    /**
     * @test
     */
    public function canCancelAnnulmentOfAnInvoice()
    {
        $client = factory(Client::class)->create();
        $seller = factory(Seller::class)->create();
        $invoice = factory(Invoice::class)->create();
        $invoice->annulate = 'motivo x';
        $invoice->update();
        $this->get(route('home'))->assertSeeText('Anulada');
        $this->get(route('invoice.annulate.cancel', $invoice))
        ->assertRedirect(route('home'));
        $this->get(route('home'))->assertSeeText('No Pago');
    }
}
