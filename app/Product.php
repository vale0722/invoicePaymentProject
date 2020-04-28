<?php

namespace App;

use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function invoices()
    {
        return $this->belongsToMany(Invoice::class);
    }

    public static function getCachedProductsList()
    {
        return Cache::remember('products.enabled', 600, function () {
            return Product::get();
        });
    }
}
