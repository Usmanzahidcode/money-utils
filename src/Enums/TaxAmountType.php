<?php

namespace Usmanzahid\MoneyUtils\Enums;

enum TaxAmountType: string {
    case PERCENT = 'percent'; // e.g. '10%'
    case RATE = 'rate'; // e.g. '0.10'
    case FIXED = 'fixed'; // e.g. '5.00'
}

