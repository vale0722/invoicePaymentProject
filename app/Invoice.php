<?php

namespace App;

use App\Constans\InvoicesStatuses;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot(['quantity', 'unit_value', 'total_value']);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function getSubtotalAttribute()
    {
        if (isset($this->products[0])) {
            return $this->products[0]->pivot->where('invoice_id', $this->id)->sum('total_value');
        }
        return 0;
    }

    public function getVatAttribute()
    {
        $subtotal = $this->subtotal;
        return $subtotal * (.16);
    }

    public function getTotalAttribute()
    {
        $subtotal = $this->subtotal;
        $vat = $this->vat;
        return $subtotal + $vat;
    }

    /**
     * Determine if the invoice is paid
     */
    public function isPaid()
    {
        return ($this->state == InvoicesStatuses::APPROVED());
    }

    
    /**
     * Determine if the invoice is in a payment process
     */
    public function isPending()
    {
        return ($this->state == InvoicesStatuses::PENDING() ||
        $this->state == InvoicesStatuses::PENDING_VALIDATION ||
        $this->state == InvoicesStatuses::PARTIAL_EXPIRED ||
        $this->state == InvoicesStatuses::OK);
    }   

    /**
     * Determine if the invoice is overdue
     */
    public function isExpired()
    {
        $now = new \DateTime();
        $now = $now->format('Y-m-d H:i:s');
        return($this->duedate <= $now);
    }

    /**
     * Determine if the invoice is annulated
     */
    public function isAnnulated()
    {
        return ($this->annulate != null);
    }
}
