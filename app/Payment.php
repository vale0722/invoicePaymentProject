<?php

namespace App;

use App\Constans\PaymentsStatuses;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $fillable = [
        'invoice_id',
        'status_id',
        'reason',
        'request_id',
        'processUrl'
    ];

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

    public function isApproved(): bool
    {
        return (PaymentsStatuses::APPROVED === $this->state);
    }

    public function isPending(): bool
    {
        return (PaymentsStatuses::PENDING === $this->reason ||
        PaymentsStatuses::PENDING_VALIDATION === $this->reason ||
        PaymentsStatuses::PARTIAL_EXPIRED === $this->reason ||
        PaymentsStatuses::OK === $this->reason);
    }

    public function setReason(string $status): void
    {
        if ($status == 'FAILED') {
            $this->reason = PaymentsStatuses::FAILED;
        } elseif ($status == 'OK') {
            $this->reason = PaymentsStatuses::OK;
        } elseif ($status == 'APPROVED') {
            $this->reason = PaymentsStatuses::APPROVED;
        } elseif ($status == 'APPROVED_PARTIAL') {
            $this->reason = PaymentsStatuses::APPROVED_PARTIAL;
        } elseif ($status == 'PARTIAL_EXPIRED') {
            $this->reason = PaymentsStatuses::PARTIAL_EXPIRED;
        } elseif ($status == 'REJECTED') {
            $this->reason = PaymentsStatuses::REJECTED;
        } elseif ($status == 'PENDING') {
            $this->reason = PaymentsStatuses::PENDING;
        } elseif ($status == 'PENDING_VALIDATION') {
            $this->reason = PaymentsStatuses::PENDING_VALIDATION;
        }
    }
}
