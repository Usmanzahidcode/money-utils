<?php

namespace Usmanzahid\MoneyUtils\Enums;

enum DiscountAmountType: string
{
    case PERCENT = 'percent';
    case RATE = 'rate';
    case FIXED = 'fixed';
}
