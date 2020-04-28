<?php

namespace App\Constans;

use MyCLabs\Enum\Enum;

class InvoicesStatuses extends Enum
{
    const OK = '111';
    const FAILED = '001';
    const APPROVED = '000';
    const APPROVED_PARTIAL = '100';
    const PARTIAL_EXPIRED = '002';
    const REJECTED = '004';
    const PENDING = '003';
    const PENDING_VALIDATION = '005';
    const BDEFAULT = '---';
}
