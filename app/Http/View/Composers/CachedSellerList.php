<?php

namespace App\Http\View\Composers;

use App\Seller;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class CachedSellerList
{
    private $seller;
    
    public function __construct(Seller $seller)
    {
        $this->seller = $seller;
    }

    public function compose(View $view)
    {
        $view->with('sellers', Cache::remember('sellers.enabled', 600, function () {
            return $this->seller->all();
        }));
    }
}