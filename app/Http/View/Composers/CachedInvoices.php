<?php

namespace App\Http\View\Composers;

use App\Invoice;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class CachedInvoices
{
    private $invoice;
    
    public function __construct(Invoice $invoice)
    {
        $this->invoice = $invoice;
    }

    public function compose(View $view)
    {
        $view->with('invoices', Cache::remember('invoices.enabled', 60, function () {
            return $this->invoice->all();
        }));
    }
}