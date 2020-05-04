<?php

namespace App;

use Carbon\Carbon;
use App\Constans\PaymentsStatuses;
use App\Constans\InvoicesStatuses;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class Invoice
 * @package App
 */
class Invoice extends Model
{
    /**
     * @return BelongsTo
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * @return BelongsTo
     */
    public function seller(): BelongsTo
    {
        return $this->belongsTo(Seller::class);
    }

    /**
     * @return BelongsToMany
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class)->withPivot(['quantity', 'unit_value', 'total_value']);
    }

    /**
     * @return HasMany
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * @return int
     */
    public function getSubtotalAttribute()
    {
        if (isset($this->products[0])) {
            return $this->products[0]->pivot->where('invoice_id', $this->id)->sum('total_value');
        }
        return 0;
    }

    /**
     * @return float|int
     */
    public function getVatAttribute()
    {
        return $this->subtotal * (.16);
    }

    /**
     * @return mixed
     */
    public function getTotalAttribute()
    {
        return $this->subtotal +  $this->vat;
    }

    /**
     * Determine if the invoice is paid
     * @return bool
     */
    public function isPaid(): bool
    {
        return (InvoicesStatuses::PAID === $this->status);
    }


    /**
     * Determine if the invoice is in a payment process
     * @return bool
     */
    public function isPending(): bool
    {
        return (InvoicesStatuses::PENDING === $this->status ||
        InvoicesStatuses::PARTIALLY_PAID === $this->status);
    }

    /**
     * Determine if the invoice is overdue
     * @return bool
     */
    public function isExpired(): bool
    {
        return(Carbon::now()->format('Y-m-d H:i:s') >= $this->duedate);
    }

    /**
     * Determine if the invoice is annulated
     * @return bool
     */
    public function isAnnulated(): bool
    {
        return (null != $this->annulate);
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status): void
    {
        if ('UNPAID' === $status) {
            $this->status = InvoicesStatuses::UNPAID;
        } elseif (PaymentsStatuses::FAILED === $status) {
            $this->status = InvoicesStatuses::UNPAID;
        } elseif (PaymentsStatuses::OK === $status) {
            $this->status = InvoicesStatuses::PENDING;
        } elseif (PaymentsStatuses::APPROVED === $status) {
            $this->status = InvoicesStatuses::PAID;
        } elseif (PaymentsStatuses::APPROVED_PARTIAL === $status
                || PaymentsStatuses::PARTIAL_EXPIRED === $status) {
            $this->status = InvoicesStatuses::PARTIALLY_PAID;
        } elseif (PaymentsStatuses::REJECTED === $status) {
            $this->status = InvoicesStatuses::UNPAID;
        } elseif (PaymentsStatuses::PENDING === $status
        || PaymentsStatuses::PENDING_VALIDATION === $status) {
            $this->status = InvoicesStatuses::PENDING;
        }
    }
}
