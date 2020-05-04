<?php

namespace App;

use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    public function invoices(): BelongsToMany
    {
        return $this->belongsToMany(Invoice::class);
    }

    public static function getCachedProductsList(): Collection
    {
        return Cache::remember('products', 600, function () {
            return Product::all();
        });
    }
}
