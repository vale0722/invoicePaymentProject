<?php

namespace App\Http\Controllers;

use App\Payment;
use App\invoice;
use Illuminate\Http\Request;
use Dnetix\Redirection\PlacetoPay;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    /**
    * Display the payment history.
    *
    * @return \Illuminate\Http\Response
    */
    public function index(Request $request, Invoice $invoice)
    {
        Log::info('Someone has Logged in to view payment history', [
            'invoice' => $invoice->id,
            'ipAddress' => $request->ip(),
            'userAgent' => $request->header('User-Agent'),
            ]);
        return view("invoices.payments.index", compact('invoice'));
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Dnetix\Redirection\PlacetoPay $placetopay
    * @param  \App\Invoice  $invoice
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request, Invoice $invoice, PlacetoPay $placetopay)
    {
        if ($invoice->total == 0) {
            Log::info('Tried to pay an invoice without products', [
                'invoice' => $invoice->id,
                'ipAddress' => $request->ip(),
                'userAgent' => $request->header('User-Agent'),
                'date' => date('c'),
                ]);
            return redirect()->route('invoice.show', $invoice);
        }
        if ($invoice->isPaid() || $invoice->isAnnulated()) {
            Log::info('Tried to pay an paid or annuled invoice', [
                'invoice' => $invoice->id,
                'ipAddress' => $request->ip(),
                'userAgent' => $request->header('User-Agent'),
                'date' => date('c'),
                ]);
            return redirect()->route('invoice.show', $invoice);
        }

        $payment = Payment::create(['invoice_id' => $invoice->id]);
        $requestPayment = [
            'buyer' => [
                'name' => $invoice->client->name,
                'surname' => $invoice->client->surname,
                'email' => $invoice->client->email,
                'documentType' => $invoice->client->documentType,
                'document' => $invoice->client->document,
                'mobile' => $invoice->client->mobile,
                'address' => [
                    'street' => $invoice->client->address,
                ]
            ],
            'payment' => [
                'reference' => $invoice->reference,
                'description' => $invoice->title,
                'amount' => [
                    'currency' => 'COP',
                    'total' => $invoice->total,
                ],
            ],
            'expiration' => date('c', strtotime('+2 days')),
            'ipAddress' => $request->ip(),
            'userAgent' => $request->header('User-Agent'),
            'returnUrl' => route('payment.update', $payment),
        ];

        $response = $placetopay->request($requestPayment);
        if ($response->isSuccessful()) {
            $this->updateData($request, $response, $payment, $invoice);
            return redirect($response->processUrl());
        }
        Log::info($response->status()->message(), [
                'invoice' => $invoice->id,
                'payment' => $payment->id,
                'ipAddress' => $request->ip(),
                'userAgent' => $request->header('User-Agent'),
                ]);
        return redirect()->route('invoice.show', $invoice)
            ->withError($response->status()->message());
    }

    /**
     * Update invoice status
     *
     * @param  \Dnetix\Redirection\PlacetoPay $placetopay
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Payment $payment, PlacetoPay $placetopay)
    {
        $response = $placetopay->query($payment->request_id);
        $payment->status = $response->status()->status();
        $payment->setReason($response->status()->status());
        $payment->message = $response->status()->message();
        $payment->update();

        $invoice = $payment->invoice;
        $invoice->state = $payment->reason;
        if ($response->isSuccessful()) {
            if ($response->status()->isApproved()) {
                $date = date(
                    "Y-m-d H:i:s",
                    strtotime($response->status()->date())
                );
                if ($invoice->receipt_date == null) {
                    $invoice->receipt_date = $date;
                }
                $invoice->payment_date = $date;
                $payment->payment_date = $date;
                $payment->update();
            }
        }
        $invoice->update();
        Log::alert('Payment attempt was updated', [
            'invoice' => $payment->invoice->id,
            'payment' => $payment->id,
            'ipAddress' => $request->ip(),
            'userAgent' => $request->header('User-Agent'),
            ]);
        return view(
            "invoices.payments.index",
            compact('invoice')
        )->with('success', 'Proceso finalizado');
    }

    /**
     * continue paying an invoice
     *
     * @param Payment $payment
     * @param PlacetoPay $placetopay
     */
    public function show(Request $request, Payment $payment, PlacetoPay $placetopay)
    {
        if (!$payment->isPending() || $payment->invoice->isAnnulated) {
            Log::info('El intento de pago no está en proceso o la factura está anulada', [
                'invoice' => $payment->invoice->id,
                'payment' => $payment->id,
                'ipAddress' => $request->ip(),
                'userAgent' => $request->header('User-Agent'),
                ]);
            return redirect()->route('payment.index', $payment->invoice)
                ->withError('El intento de pago no está en proceso o la factura está anulada');
        }
        $requestPayment = $placetopay->query($payment->request_id);
        $response = $placetopay->request($requestPayment->request);
        if ($response->isSuccessful()) {
            $this->updateData($request, $response, $payment, $payment->invoice);
            return redirect($response->processUrl());
        }
        Log::alert($response->status()->message(), [
                    'invoice' => $payment->invoice->id,
                    'payment' => $payment->id,
                    'ipAddress' => $request->ip(),
                    'userAgent' => $request->header('User-Agent'),
                    ]);
        return redirect()->route('payment.index', $payment->invoice)
            ->withError($response->status()->message());
    }

    /**
     * Before redirection with placetopay,
     * data update
     *
     * @param $requestPayment
     * @param Payment $payment
     * @param Invoice $invoice
     */
    private function updateData($request, $requestPayment, Payment $payment, Invoice $invoice)
    {
        $payment = Payment::where('id', $payment->id)->first();
        $payment->status = $requestPayment->status()->status();
        $payment->setReason($requestPayment->status()->status());
        $payment->message = $requestPayment->status()->message();
        $payment->invoice->state = $payment->reason;
        $payment->request_id = $requestPayment->requestId();
        $payment->processUrl = $requestPayment->processUrl();
        $payment->update();
        $payment->invoice->update();
        Log::info('PlacetoPay Redirect', [
            'invoice' => $invoice->id,
            'payment' => $payment->id,
            'ipAddress' => $request->ip(),
            'userAgent' => $request->header('User-Agent'),
            ]);
    }
}
