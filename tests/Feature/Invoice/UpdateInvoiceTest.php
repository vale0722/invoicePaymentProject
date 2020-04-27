<?php

namespace Tests\Feature\Invoice;

use App\Client;
use App\Seller;
use App\Invoice;
use Tests\TestCase;
use App\Actions\StatusAction;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateInvoiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function canSeeEditInvoiceView()
    {
        $client = factory(Client::class)->create();
        $seller = factory(Seller::class)->create();
        $invoice = factory(Invoice::class)->create();
        $this->get(route('invoice.edit', $invoice))->assertViewIs('invoices.edit');
    }

    /**
     * @test
     */
    public function canEditANoAnnuledInvoice()
    {
        $client = factory(Client::class)->create();
        $seller = factory(Seller::class)->create();
        $invoice = factory(Invoice::class)->create();
        $this->put(route('invoice.update', $invoice), [
            'reference' => '#RTU',
            'title' => 'Invoice test update',
            'stateReceipt' => '1'
        ])
        ->assertRedirect()
        ->assertSessionHasNoErrors();
        $this->assertDatabaseHas('invoices', [
            'reference' => '#RTU',
            'title' => 'Invoice test update'
        ]);
    }
    
    /**
     * @test
     */
    public function canNotEditAnAnnuledInvoice()
    {
        $client = factory(Client::class)->create();
        $seller = factory(Seller::class)->create();
        $invoice = factory(Invoice::class)->create();
        $invoice->annulate = 'motivo x';
        $invoice->update();
        $this->put(route('invoice.update', $invoice), [
            'reference' => '#RTU',
            'title' => 'Invoice test update',
            'stateReceipt' => '1'
        ])
        ->assertRedirect(route('home'));
        $this->assertDatabaseMissing('invoices', [
            'reference' => '#RTU',
            'title' => 'Invoice test update'
        ]);
    }

    /**
     * @test
     */
    public function canNotEditAnPaidInvoice()
    {
        $client = factory(Client::class)->create();
        $seller = factory(Seller::class)->create();
        $invoice = factory(Invoice::class)->create();
        $invoice->state =  StatusAction::APPROVED();
        $invoice->update();
        $this->put(route('invoice.update', $invoice), [
            'reference' => '#RTU',
            'title' => 'Invoice test update',
            'stateReceipt' => '1'
        ])
        ->assertRedirect(route('home'));
        $this->assertDatabaseMissing('invoices', [
            'reference' => '#RTU',
            'title' => 'Invoice test update'
        ]);
    }

    /**
     * @test
     */
    public function canNotEditAnInvoiceInPaidProccess()
    {
        $client = factory(Client::class)->create();
        $seller = factory(Seller::class)->create();
        $invoice = factory(Invoice::class)->create();
        $invoice->state =  StatusAction::PENDING();
        $invoice->update();
        $this->put(route('invoice.update', $invoice), [
            'reference' => '#RTU',
            'title' => 'Invoice test update',
            'stateReceipt' => '1'
        ])
        ->assertRedirect(route('home'));
        $this->assertDatabaseMissing('invoices', [
            'reference' => '#RTU',
            'title' => 'Invoice test update'
        ]);
    }
}
