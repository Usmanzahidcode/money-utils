<?php

namespace Usmanzahid\MoneyUtils\Enums;

enum DiscountAmountType: string
{
    case PERCENTAGE = 'percentage';
    case RATE = 'rate';
    case FIXED = 'fixed';
}
