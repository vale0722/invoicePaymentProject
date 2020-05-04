<?php

namespace App\Http\Controllers;

use App\Payment;
use App\Invoice;
use http\Env\Response;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Events\LogInvoiceEvent;
use App\Events\LogPaymentEvent;
use Dnetix\Redirection\PlacetoPay;
use Dnetix\Redirection\Exceptions\PlacetoPayException;

/**
 * Class PaymentController
 * @package App\Http\Controllers
 */
class PaymentController extends Controller
{
    /**
    * Display the payment history.
    * @param Invoice $invoice
     * @param Request $request
    * @return Response
    */
    public function index(Request $request, Invoice $invoice)
    {
        event(new LogInvoiceEvent(
            'Someone has Logged in to view payment history',
            $invoice->id,
            $request->ip(),
            $request->header('User-Agent'),
            'info'
        ));
        return view("invoices.show", compact('invoice'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param PlacetoPay $placetopay
     * @param Invoice $invoice
     * @return Response
     * @throws PlacetoPayException
     */
    public function store(Request $request, Invoice $invoice, PlacetoPay $placetopay)
    {
        if ($invoice->total == 0) {
            event(new LogInvoiceEvent(
                'Tried to pay an invoice without products',
                $invoice->id,
                $request->ip(),
                $request->header('User-Agent'),
                'info'
            ));
            return redirect()->route('invoice.show', $invoice);
        }

        if ($invoice->isPaid() || $invoice->isAnnulated()) {
            event(new LogInvoiceEvent(
                'Tried to pay an paid or annuled invoice',
                $invoice->id,
                $request->ip(),
                $request->header('User-Agent'),
                'info'
            ));
            return redirect()->route('invoice.show', $invoice);
        }

        $payment = Payment::create(['invoice_id' => $invoice->id]);
        $requestPayment = [
            'buyer' => [
                'name' => $invoice->client->name,
                'surname' => $invoice->client->surname,
                'email' => $invoice->client->email,
                'documentType' => $invoice->client->document_type,
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
            $this->updateData($request, $response, $payment);
            return redirect($response->processUrl());
        }

        event(new LogPaymentEvent(
            $response->status()->message(),
            $payment->id,
            $invoice->id,
            $request->ip(),
            $request->header('User-Agent'),
            'info'
        ));
        return redirect()->route('invoice.show', $invoice)
            ->withError($response->status()->message());
    }

    /**
     * Update invoice status
     *
     * @param Request $request
     * @param  PlacetoPay $placetopay
     * @param  Payment  $payment
     * @return View
     */
    public function update(Request $request, Payment $payment, PlacetoPay $placetopay)
    {
        $response = $placetopay->query($payment->request_id);
        $payment->status = $response->status()->status();
        $payment->setReason($response->status()->status());
        $payment->message = $response->status()->message();
        $payment->update();

        $invoice = $payment->invoice;
        $invoice->setStatus($payment->reason);
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

        event(new LogPaymentEvent(
            'Payment attempt was updated',
            $payment->id,
            $invoice->id,
            $request->ip(),
            $request->header('User-Agent'),
            'info'
        ));
        return view(
            "invoices.show",
            compact('invoice')
        )->with('success', 'Proceso finalizado');
    }

    /**
     * continue paying an invoice
     *
     * @param Request $request
     * @param Payment $payment
     * @param PlacetoPay $placetopay
     * @return  Response
     */
    public function show(Request $request, Payment $payment, PlacetoPay $placetopay)
    {
        if (!$payment->isPending() || $payment->isApproved() || $payment->invoice->isAnnulated()) {
            event(new LogPaymentEvent(
                'Someone tried to proceed with a no-process payment or an overdue invoice',
                $payment->id,
                $payment->invoice->id,
                $request->ip(),
                $request->header('User-Agent'),
                'alert'
            ));
            return redirect()->route('invoice.show', $payment->invoice);
        }

        $response = $placetopay->query($payment->request_id);

        if ($response->isSuccessful()) {

            return redirect($payment->processUrl);
        }

        event(new LogPaymentEvent(
            $response->status()->message(),
            $payment->id,
            $payment->invoice->id,
            $request->ip(),
            $request->header('User-Agent'),
            'info'
        ));

        return redirect()->route('invoice.show', $payment->invoice)
            ->withError($response->status()->message());
    }

    /**
     * Before redirection with placetopay,
     * data update
     * @param $request
     * @param $requestPayment
     * @param Payment $payment
     */
    private function updateData($request, $requestPayment, Payment $payment)
    {
        $payment = Payment::where('id', $payment->id)->first();
        $payment->setReason($requestPayment->status()->status());
        $payment->message = $requestPayment->status()->message();
        $payment->invoice->setStatus($payment->reason);
        $payment->request_id = $requestPayment->requestId();
        $payment->processUrl = $requestPayment->processUrl();
        $payment->update();
        $payment->invoice->update();
        event(new LogPaymentEvent(
            'PlacetoPay Redirect',
            $payment->id,
            $payment->invoice->id,
            $request->ip(),
            $request->header('User-Agent'),
            'info'
        ));
    }
}
