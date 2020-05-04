<?php

namespace App;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Seller extends Model
{
    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    public function getFullNameAttribute(): string
    {
        return $this->name . ' ' . $this->surname;
    }

    public function getFullDocumentAttribute(): string
    {
        return $this->document_type . '. ' . $this->document;
    }

    public static function getCachedSellerList(): Collection
    {
        return Cache::remember('sellers', 600, function () {
            return Seller::all();
        });
    }
}
