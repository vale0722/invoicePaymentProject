<?php

namespace App;

use App\Constans\InvoicesStatuses;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'invoice_id',
        'status_id',
        'reason',
        'request_id',
        'processUrl'
    ];
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function isApproved()
    {
        return ($this->state == InvoicesStatuses::APPROVED());
    }

    public function isPending()
    {
        return ($this->reason == InvoicesStatuses::PENDING() ||
        $this->reason == InvoicesStatuses::PENDING_VALIDATION ||
        $this->reason == InvoicesStatuses::PARTIAL_EXPIRED) || 
        $this->reason == InvoicesStatuses::OK;
    }

    public function setReason(string $status): void
    {
        if ($status == 'FAILED') {
            $this->reason = InvoicesStatuses::FAILED();
        } elseif ($status == 'OK') {
            $this->reason = InvoicesStatuses::OK();
        } elseif ($status == 'APPROVED') {
            $this->reason = InvoicesStatuses::APPROVED();
        } elseif ($status == 'APPROVED_PARTIAL') {
            $this->reason = InvoicesStatuses::APPROVED_PARTIAL();
        } elseif ($status == 'PARTIAL_EXPIRED') {
            $this->reason = InvoicesStatuses::PARTIAL_EXPIRED();
        } elseif ($status == 'REJECTED') {
            $this->reason = InvoicesStatuses::REJECTED();
        } elseif ($status == 'PENDING') {
            $this->reason = InvoicesStatuses::PENDING();
        } elseif ($status == 'PENDING_VALIDATION') {
            $this->reason = InvoicesStatuses::PENDING_VALIDATION();
        } else {
            $this->reason = InvoicesStatuses::BDEFAULT();
        }
    }
}