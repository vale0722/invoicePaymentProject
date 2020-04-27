<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Http\View\Composers\CachedInvoices;
use App\Http\View\Composers\CachedClientList;
use App\Http\View\Composers\CachedSellerList;
use App\Http\View\Composers\CachedProductsList;

class ViewComposerProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer(
            'invoices.index',
            CachedInvoices::class
        );

        View::composer(
            'invoices.create',
            CachedClientList::class
        );
        
        View::composer(
            'invoices.create',
            CachedSellerList::class
        );

        View::composer(
            'invoices.edit',
            CachedClientList::class
        );
        
        View::composer(
            'invoices.edit',
            CachedSellerList::class
        );

        View::composer(
            'invoices.products.create',
            CachedProductsList::class
        );
    }
}
