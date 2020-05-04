<?php

namespace App\Http\Controllers;

use App\Invoice;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Requests\Invoice\Product\StoreRequest;

/**
 * Class InvoiceProductController
 * @package App\Http\Controllers
 */
class InvoiceProductController extends Controller
{

    /**
    * Create view of an invoice product
     *
     * @param Invoice $invoice
     * @return View
    */
    public function create(Invoice $invoice)
    {
        $products = Product::getCachedProductsList();
        return view('invoices.products.create', compact('invoice', 'products'));
    }

    /**
     * Store an invoice product
     *
     * @param StoreRequest $request
     * @param Invoice $invoice
     * @return RedirectResponse
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
