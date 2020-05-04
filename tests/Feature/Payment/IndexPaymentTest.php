<?php

namespace Tests\Feature\Payment;

use Tests\TestCase;
use App\Invoice;
use App\Payment;
use Illuminate\Foundation\Testing\RefreshDatabase;

class IndexPaymentTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function youCanSeeAMessageIfThereAreNoPaymentAttempts()
    {
        $invoice = factory(Invoice::class)->create();
        $this->get(route('invoice.show', $invoice))
            ->assertSeeText('NO HA REALIZADO NINGÚN INTENTO DE PAGO');
    }

    /**
     * @test
     */
    public function youCannotSeeAttemptsToPayOtherInvoices()
    {
        $invoice1 = factory(Invoice::class)->create();
        $payment1 = factory(Payment::class)->create([
            'invoice_id' => $invoice1->id
        ]);
        $invoice2 = factory(Invoice::class)->create();
        $payment2 = factory(Payment::class)->create([
            'invoice_id' => $invoice2->id
        ]);
        $response = $this->get(route('invoice.show', $invoice1));
        $response->assertSeeText($payment1->invoice->reference);
        $response->assertDontSeeText($payment2->invoice->reference);
    }

    /**
     * @test
     */
    public function youCanSeeThePaymentHistory()
    {
        $invoice = factory(Invoice::class)->create();
        $payment = factory(Payment::class)->create();
        $response = $this->get(route('invoice.show', $invoice));
        $response->assertSeeText($payment->id);
        $response->assertSeeText($payment->message);
    }
}
