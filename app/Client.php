<?php

namespace App;

use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    public function getFullNameAttribute(): String
    {
        return $this->name . ' ' . $this->surname;
    }

    public function getFullDocumentAttribute(): String
    {
        return $this->document_type . '. ' . $this->document;
    }

    public static function getCachedClientList(): Collection
    {
        return Cache::remember('clients', 600, function () {
            return Client::all();
        });
    }
}
