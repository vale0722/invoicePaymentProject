<?php

namespace Tests\Feature\Invoice;

use App\Invoice;
use Tests\TestCase;
use App\Constans\InvoicesStatuses;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateInvoiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function canSeeEditInvoiceView()
    {
        $invoice = factory(Invoice::class)->create();
        $this->get(route('invoice.edit', $invoice))->assertViewIs('invoices.edit');
    }

    /**
     * @test
     */
    public function canEditANoAnnuledInvoice()
    {
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
        $invoice = factory(Invoice::class)->state('annulate')->create();
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
        $invoice = factory(Invoice::class)->create([
            'status' => InvoicesStatuses::PAID,
        ]);
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
        $invoice = factory(Invoice::class)->create([
            'status' => InvoicesStatuses::PENDING,
        ]);
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
