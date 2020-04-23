<?php

namespace App\Http\Controllers;

use App\Invoice;
use Illuminate\Http\Request;

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
}
