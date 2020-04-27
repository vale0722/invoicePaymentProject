<?php

namespace App;

use App\Actions\StatusAction;
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
        return ($this->state == StatusAction::APPROVED());
    }

    public function isPending()
    {
        return ($this->reason == StatusAction::PENDING() ||
        $this->reason == StatusAction::PENDING_VALIDATION ||
        $this->reason == StatusAction::PARTIAL_EXPIRED) || 
        $this->reason == StatusAction::OK;
    }

    public function setReason(string $status): void
    {
        if ($status == 'FAILED') {
            $this->reason = StatusAction::FAILED();
        } elseif ($status == 'OK') {
            $this->reason = StatusAction::OK();
        } elseif ($status == 'APPROVED') {
            $this->reason = StatusAction::APPROVED();
        } elseif ($status == 'APPROVED_PARTIAL') {
            $this->reason = StatusAction::APPROVED_PARTIAL();
        } elseif ($status == 'PARTIAL_EXPIRED') {
            $this->reason = StatusAction::PARTIAL_EXPIRED();
        } elseif ($status == 'REJECTED') {
            $this->reason = StatusAction::REJECTED();
        } elseif ($status == 'PENDING') {
            $this->reason = StatusAction::PENDING();
        } elseif ($status == 'PENDING_VALIDATION') {
            $this->reason = StatusAction::PENDING_VALIDATION();
        } else {
            $this->reason = StatusAction::BDEFAULT();
        }
    }
}