<?php

namespace App\Http\Controllers;

use App\Client;
use App\Seller;
use App\Invoice;
use App\Product;
use Illuminate\Http\Request;
use App\Events\LogInvoiceEvent;
use App\Constans\InvoicesStatuses;
use App\Http\Requests\Invoice\InvoiceStoreRequest;
use App\Http\Requests\Invoice\InvoiceUpdateRequest;
use App\Http\Requests\Invoice\InvoiceAnnulateRequest;

class InvoiceController extends Controller
{
    /**
     * Displays a list of invoices
     */
    public function index()
    {
        $invoices = Invoice::all();
        return view('invoices.index', compact('invoices'));
    }

    /**
     * Displays a specific invoice
     *
     * @param App\Invoice  $invoice
     */
    public function show(Invoice $invoice)
    {
        return view('invoices.show', compact('invoice'));
    }

    /**
    * Create view of an invoice
    */
    public function create()
    {
        $clients = Client::getCachedClientList();
        $sellers = Seller::getCachedSellerList();
        $products = Product::getCachedProductsList();
        return view('invoices.create', compact(
            'clients',
            'sellers',
            'products'
        ));
    }

    /**
     * Store an invoice
     *
     * @param App\Http\Requests\Invoice\InvoiceStoreRequest $request
     */
    public function store(InvoiceStoreRequest $request)
    {
        $invoice = new Invoice();
        $invoice->title = $request->input('title');
        $invoice->reference = $request->input('reference');
        $invoice->client_id = $request->input('client');
        $invoice->seller_id = $request->input('seller');
        $invoice->state = InvoicesStatuses::BDEFAULT();
        $invoice->duedate = date(
            "Y-m-d H:i:s",
            strtotime($invoice->created_at . "+ 30 days")
        );
        $invoice->save();

        $product = Product::find($request->input('product'));
        $invoice->products()->attach($product->id, [
            'quantity' => $request->input('quantity'),
            'unit_value' => $product->price,
            'total_value' => $request->input('quantity') * $product->price,
         ]);
        $invoice->update();
         
        return redirect()->route('invoice.edit', $invoice);
    }

    /**
     * Edit view of an invoice
     *
     * @param App\Invoice $invoice
     */
    public function edit(Invoice $invoice)
    {
        if (!$invoice->isPaid() && !$invoice->isPending()) {
            $clients = Client::getCachedClientList();
            $sellers = Seller::getCachedSellerList();
            return view('invoices.edit', compact(
                'invoice',
                'clients',
                'sellers'
            ));
        } else {
            return redirect()->route('home')
                ->withErrors('La factura no se puede editar');
        }
    }

    /**
     * Update an invoice
     *
     * @param App\Invoice $invoice
     */
    public function update(Invoice $invoice, InvoiceUpdateRequest $request)
    {
        if (!$invoice->isPaid()
            && !$invoice->isPending()
            && !$invoice->isAnnulated()) {
            $invoice->title = $request->input('title');
            $invoice->reference = $request->input('reference');

            if ($request->input('stateReceipt') == '1') {
                $now = new \DateTime();
                $invoice->receipt_date = $now->format('Y-m-d H:i:s');
            } else {
                $invoice->receipt_date = null;
            }

            $invoice->update();
            return redirect()->route('home');
        }
        event(new LogInvoiceEvent(
            'Tried to update an invoice with a pending or already paid process',
            $invoice->id,
            $request->ip(),
            $request->header('User-Agent'),
            'info'
        ));
        return redirect()->route('home')->withErrors('La factura no se puede editar');
    }

    /**
     * View for annulate an invoice
     * @param Invoice $invoice
     */
    public function annulateView(Invoice $invoice)
    {
        return view('invoices.annulate', compact('invoice'));
    }

    /**
     * Cancels an invoice
     *
     * @param Request $request
     * @param Invoice $invoice
     */
    public function annulate(InvoiceAnnulateRequest $request, Invoice $invoice)
    {
        try {
            $invoice->annulate = $request->input('reason');
            $invoice->update();
            event(new LogInvoiceEvent(
                'An invoice was annulated',
                $invoice->id,
                $request->ip(),
                $request->header('User-Agent'),
                'info'
            ));
            return redirect()->route('home')->with('success', 'La factura fue anulada');
        } catch (Exception $e) {
            event(new LogInvoiceEvent(
                $e,
                $invoice->id,
                $request->ip(),
                $request->header('User-Agent'),
                'error'
            ));
            return redirect()->route('home')->withErrors($e);
        }
    }

    /**
     * Reverse annulate
     * @param Invoice $invoice
     * @param Request $request
     */
    public function annulateCancel(Request $request, Invoice $invoice)
    {
        $invoice->annulate = null;
        $invoice->update();
        event(new LogInvoiceEvent(
            'The Annulate of an invoice was removed',
            $invoice->id,
            $request->ip(),
            $request->header('User-Agent'),
            'info'
        ));
        return redirect()->route('home')->with('success', 'La factura ya no está anulada');
    }
}
