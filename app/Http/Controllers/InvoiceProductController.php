<?php

namespace App\Http\Controllers;

use App\Invoice;
use App\Product;
use Illuminate\Http\Request;
use App\Actions\StatusAction;
use App\Http\Requests\Invoice\Product\StoreRequest;

class InvoiceProductController extends Controller
{

    /**
    * Create view of an invoice product
    */
    public function create(Invoice $invoice)
    {
        return view('invoices.products.create', compact('invoice'));
    }

    /**
     * Store an invoice product
     *
     * @param App\Http\Requests\Invoice\InvoiceStoreRequest $request
     */
    public function store(StoreRequest $request, Invoice $invoice)
    {
        $product = Product::find($request->input('product'));

        $invoice->products()->attach($product->id, [
            'quantity' => $request->input('quantity'),
            'unit_value' => $product->price,
            'total_value' => $request->input('quantity') * $product->price,
         ]);
        $invoice->save();
        return redirect()->route('invoice.edit', $invoice);
    }
}
