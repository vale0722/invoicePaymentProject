<?php

namespace App\Constans;

use MyCLabs\Enum\Enum;

class InvoicesStatuses extends Enum
{
    const PAID = '111';
    const PARTIALLY_PAID = '110';
    const UNPAID = '000';
    const EXPIRED = '010';
    const PENDING = '101';
}
