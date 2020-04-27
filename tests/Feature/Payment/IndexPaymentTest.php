<?php

namespace Tests\Feature\Payment;

use Tests\TestCase;
use App\Client;
use App\Seller;
use App\Invoice;
use App\Payment;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class IndexPaymentTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function theRouteIndexPaymentLeadsToThePaymentIndex()
    {
        factory(Client::class)->create();
        factory(Seller::class)->create();
        $invoice = factory(Invoice::class)->create();
        $this->get(route('payment.index', $invoice))->assertViewIs('invoices.payments.index');
    }

    /**
     * @test
     */
    public function youCanSeeAMessageIfThereAreNoPaymentAttempts()
    {
        factory(Client::class)->create();
        factory(Seller::class)->create();
        $invoice = factory(Invoice::class)->create();
        $this->get(route('payment.index', $invoice))
            ->assertSeeText('NO HA REALIZADO NINGÚN INTENTO DE PAGO');
    }

    /**
     * @test
     */
    public function youCannotSeeAttemptsToPayOtherInvoices()
    {
        factory(Client::class)->create();
        factory(Seller::class)->create();
        $invoice1 = factory(Invoice::class)->create();
        $payment1 = factory(Payment::class)->create([
            'invoice_id' => $invoice1->id
        ]);
        $invoice2 = factory(Invoice::class)->create();
        $payment2 = factory(Payment::class)->create([
            'invoice_id' => $invoice2->id
        ]);
        $response = $this->get(route('payment.index', $invoice1));
        $response->assertSeeText($payment1->invoice->reference);
        $response->assertDontSeeText($payment2->invoice->reference);
    }

    /**
     * @test
     */
    public function youCanSeeThePaymentHistory()
    {
        factory(Client::class)->create();
        factory(Seller::class)->create();
        $invoice = factory(Invoice::class)->create();
        $payment = factory(Payment::class)->create();
        $response = $this->get(route('payment.index', $invoice));
        $response->assertSeeText($payment->reason);
        $response->assertSeeText($payment->id);
        $response->assertSeeText($payment->message);
    }
}
