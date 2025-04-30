<?php declare(strict_types=1);

use Usmanzahid\MoneyUtils\Enums\DiscountAmountType;
use Usmanzahid\MoneyUtils\Enums\TaxAmountType;

const UZ_CALCULATION_PRECISION = 8; // For calculating at longer precision for better reliability.
const UZ_ROUNDING_PRECISION = 2; // For USD

if (!function_exists('uz_add')) {
    /**
     * Adds two numbers with high precision and rounding.
     *
     * @param string $amountA The first number to add.
     * @param string $b The second number to add.
     * @return string The result of adding $a and $b, rounded to the precision defined by UZ_ROUNDING_PRECISION.
     */
    function uz_add(string $amountA, string $amountB): string {
        $result = bcadd($amountA, $amountB, UZ_CALCULATION_PRECISION);
        return uz_round($result);
    }
}

if (!function_exists('uz_sub')) {
    /**
     * Subtracts one number from another with high precision and rounding.
     *
     * @param string $a The number to subtract from.
     * @param string $b The number to subtract.
     * @return string The result of subtracting $b from $a, rounded to the precision defined by UZ_ROUNDING_PRECISION.
     */
    function uz_sub(string $amountA, string $amountB): string {
        $result = bcsub($amountA, $amountB, UZ_CALCULATION_PRECISION);
        return uz_round($result);
    }
}

if (!function_exists('uz_mul')) {
    /**
     * Multiplies two numbers with high precision and rounding.
     *
     * @param string $a The first number to multiply.
     * @param string $b The second number to multiply.
     * @return string The result of multiplying $a and $b, rounded to the precision defined by UZ_ROUNDING_PRECISION.
     */
    function uz_mul(string $amountA, string $amountB): string {
        $result = bcmul($amountA, $amountB, UZ_CALCULATION_PRECISION);
        return uz_round($result);
    }
}

if (!function_exists('uz_div')) {
    /**
     * Divides one number by another with high precision and rounding.
     *
     * @param string $amountA The numerator.
     * @param string $amountB The denominator.
     * @return string The result of dividing $a by $b, rounded to the precision defined by UZ_ROUNDING_PRECISION.
     * @throws InvalidArgumentException if $b is zero.
     */
    function uz_div(string $amountA, string $amountB): string {
        if (bccomp($amountB, '0', UZ_CALCULATION_PRECISION)===0) {
            throw new \InvalidArgumentException('Division by zero.');
        }
        $result = bcdiv($amountA, $amountB, UZ_CALCULATION_PRECISION);
        return uz_round($result);
    }
}

if (!function_exists('uz_round')) {
    /**
     * Rounds a number with high precision for calculations, then rounds to the standard format.
     *
     * @param string $amount The number to round.
     * @return string The rounded number, with precision defined by UZ_ROUNDING_PRECISION.
     */
    function uz_round(string $amount): string {
        $calculationPrecision = UZ_CALCULATION_PRECISION;
        $roundingPrecision = UZ_ROUNDING_PRECISION;

        // Resolve the adjustment amount.
        $adjustment = bcpow('10', (string) -$roundingPrecision, $roundingPrecision + 2);
        $adjustment = bcdiv($adjustment, '2', $roundingPrecision + 2);

        if (bccomp($amount, '0', $calculationPrecision) >= 0) {
            $rounded = bcadd($amount, $adjustment, $calculationPrecision);
        } else {
            $rounded = bcsub($amount, $adjustment, $calculationPrecision);
        }

        return bcadd($rounded, '0', $roundingPrecision);
    }
}

if (!function_exists('uz_tax')) {
    /**
     * Calculates the tax for a given amount based on the specified tax rate.
     *
     * @param string $amount The amount to calculate tax on.
     * @param string|TaxAmountType $taxAmountType The tax amount type (percentage: 10, flat: 3.02, rate: 0.10 for 10 percent)
     * @param string $taxAmount
     *
     * @return string The calculated tax amount, rounded to the precision defined by UZ_ROUNDING_PRECISION.
     */
    function uz_tax(string $amount, string|TaxAmountType $taxAmountType, string $taxAmount): string {
        if (is_string($taxAmountType)) {
            $taxAmountType = TaxAmountType::tryFrom($taxAmountType);
            if (!$taxAmountType) {
                throw new \InvalidArgumentException("A valid TaxAmount Type is must be provided: $taxAmount");
            }
        }

        switch ($taxAmountType) {
            case TaxAmountType::PERCENTAGE:
                $rate = bcdiv(rtrim($taxAmount, '%'), '100', UZ_CALCULATION_PRECISION);
                $tax = bcmul($amount, $rate, UZ_CALCULATION_PRECISION);
                break;

            case TaxAmountType::RATE:
                $tax = bcmul($amount, $taxAmount, UZ_CALCULATION_PRECISION);
                break;

            case TaxAmountType::FIXED:
                $tax = $taxAmount;
                break;

            default:
                throw new \InvalidArgumentException("Invalid tax type: {$taxAmountType->value}");
        }

        return uz_round($tax);
    }

}

if (!function_exists('uz_discount')) {
    /**
     * Calculates the amount after applying a discount based on the specified rate.
     *
     * @param string $amount The amount to calculate the discount on.
     * @param string|DiscountAmountType $discountAmountType
     * @param string $discountAmount
     * @return string The amount after applying the discount.
     */
    function uz_discount(string $amount, string|DiscountAmountType $discountAmountType, string $discountAmount): string {
        if (is_string($discountAmountType)) {
            $discountAmountType = DiscountAmountType::tryFrom($discountAmountType);
            if (!$discountAmountType) {
                throw new \InvalidArgumentException('Discount Amount is not a valid discount amount type.');
            }
        }

        switch ($discountAmountType) {
            case DiscountAmountType::PERCENTAGE:
                $rate = bcdiv(rtrim($discountAmount, '%'), '100', UZ_CALCULATION_PRECISION);
                $discount = bcmul($amount, $rate, UZ_CALCULATION_PRECISION);
                break;

            case DiscountAmountType::RATE:
                $discount = bcmul($amount, $discountAmount, UZ_CALCULATION_PRECISION);
                break;

            case DiscountAmountType::FIXED:
                $discount = $discountAmount;
                break;

            default:
                throw new \InvalidArgumentException("Invalid discount type: {$discountAmountType->value}");
        }

        $amountAfterDiscount = uz_sub($amount, $discount);

        return uz_round($amountAfterDiscount);
    }

}
