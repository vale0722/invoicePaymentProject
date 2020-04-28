<?php

namespace App;

use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function getFullNameAttribute()
    {
        return $this->name . ' ' . $this->surname;
    }

    public function getFullDocumentAttribute()
    {
        return $this->documentType . '. ' . $this->document;
    }

    public static function getCachedSellerList()
    {
        return Cache::remember('sellers.enabled', 600, function () {
            return Seller::get();
        });
    }
}
