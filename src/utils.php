<?php declare(strict_types=1);

use Usmanzahid\MoneyUtils\Enums\DiscountAmountType;
use Usmanzahid\MoneyUtils\Enums\TaxAmountType;

// Default Precision Variables (these can be changed dynamically)
$UZ_CALCULATION_PRECISION = 14; // For calculating at longer precision for better reliability
$UZ_ROUNDING_PRECISION = 2; // Default rounding precision

if (!function_exists('uz_set_precision')) {
    /**
     * Set the precision for the final results.
     *
     * @param int $precision The precision to use for final results.
     * @return void
     */
    function uz_set_precision(int $precision): void {
        global $UZ_ROUNDING_PRECISION;
        $UZ_ROUNDING_PRECISION = $precision;
    }
}

if (!function_exists('uz_add')) {
    /**
     * Adds two numbers with high precision and rounding.
     *
     * @param string $amountA The first number to add.
     * @param string $amountB The second number to add.
     * @return string The result of adding $amountA and $amountB, rounded to the precision defined by UZ_ROUNDING_PRECISION.
     */
    function uz_add(string $amountA, string $amountB): string {
        global $UZ_CALCULATION_PRECISION, $UZ_ROUNDING_PRECISION;

        $result = bcadd($amountA, $amountB, $UZ_CALCULATION_PRECISION);
        return uz_round($result);
    }
}

if (!function_exists('uz_sub')) {
    /**
     * Subtracts one number from another with high precision and rounding.
     *
     * @param string $amountA The number to subtract from.
     * @param string $amountB The number to subtract.
     * @return string The result of subtracting $amountB from $amountA, rounded to the precision defined by UZ_ROUNDING_PRECISION.
     */
    function uz_sub(string $amountA, string $amountB): string {
        global $UZ_CALCULATION_PRECISION, $UZ_ROUNDING_PRECISION;

        $result = bcsub($amountA, $amountB, $UZ_CALCULATION_PRECISION);
        return uz_round($result);
    }
}

if (!function_exists('uz_mul')) {
    /**
     * Multiplies two numbers with high precision and rounding.
     *
     * @param string $amountA The first number to multiply.
     * @param string $amountB The second number to multiply.
     * @return string The result of multiplying $amountA and $amountB, rounded to the precision defined by UZ_ROUNDING_PRECISION.
     */
    function uz_mul(string $amountA, string $amountB): string {
        global $UZ_CALCULATION_PRECISION, $UZ_ROUNDING_PRECISION;

        $result = bcmul($amountA, $amountB, $UZ_CALCULATION_PRECISION);
        return uz_round($result);
    }
}

if (!function_exists('uz_div')) {
    /**
     * Divides one number by another with high precision and rounding.
     *
     * @param string $amountA The numerator.
     * @param string $amountB The denominator.
     * @return string The result of dividing $amountA by $amountB, rounded to the precision defined by UZ_ROUNDING_PRECISION.
     * @throws InvalidArgumentException if $amountB is zero.
     */
    function uz_div(string $amountA, string $amountB): string {
        global $UZ_CALCULATION_PRECISION, $UZ_ROUNDING_PRECISION;

        if (bccomp($amountB, '0', $UZ_CALCULATION_PRECISION)===0) {
            throw new \InvalidArgumentException('Division by zero.');
        }

        $result = bcdiv($amountA, $amountB, $UZ_CALCULATION_PRECISION);
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
        global $UZ_CALCULATION_PRECISION, $UZ_ROUNDING_PRECISION;

        // Resolve the adjustment amount to handle rounding.
        $adjustment = bcpow('10', (string) -$UZ_ROUNDING_PRECISION, $UZ_ROUNDING_PRECISION + 2);
        $adjustment = bcdiv($adjustment, '2', $UZ_ROUNDING_PRECISION + 2);

        // Adjust the amount based on the rounding logic.
        if (bccomp($amount, '0', $UZ_CALCULATION_PRECISION) >= 0) {
            $rounded = bcadd($amount, $adjustment, $UZ_CALCULATION_PRECISION);
        } else {
            $rounded = bcsub($amount, $adjustment, $UZ_CALCULATION_PRECISION);
        }

        return bcadd($rounded, '0', $UZ_ROUNDING_PRECISION);
    }
}

if (!function_exists('uz_tax')) {
    /**
     * Calculates the tax for a given amount based on the specified tax rate.
     *
     * @param string $amount The amount to calculate tax on.
     * @param string|TaxAmountType $taxAmountType The tax amount type (percentage: e.g., "10%", fixed: e.g., "3.02", rate: e.g., "0.10" for 10% rate).
     * @param string $taxAmount The tax amount (could be a percentage, fixed amount, or rate).
     * @return string The calculated tax amount, rounded to the precision defined by UZ_ROUNDING_PRECISION.
     */
    function uz_tax(string $amount, string|TaxAmountType $taxAmountType, string $taxAmount): array {
        global $UZ_CALCULATION_PRECISION, $UZ_ROUNDING_PRECISION;

        if (is_string($taxAmountType)) {
            $taxAmountType = TaxAmountType::tryFrom($taxAmountType);
            if (!$taxAmountType) {
                throw new \InvalidArgumentException("A valid TaxAmount Type must be provided: $taxAmount");
            }
        }

        switch ($taxAmountType) {
            case TaxAmountType::PERCENTAGE:
                $rate = bcdiv(rtrim($taxAmount, '%'), '100', $UZ_CALCULATION_PRECISION);
                $tax = bcmul($amount, $rate, $UZ_CALCULATION_PRECISION);
                break;
            case TaxAmountType::RATE:
                $tax = bcmul($amount, $taxAmount, $UZ_CALCULATION_PRECISION);
                break;
            case TaxAmountType::FIXED:
                $tax = $taxAmount;
                break;
            default:
                throw new \InvalidArgumentException("Invalid tax type: {$taxAmountType->value}");
        }

        $amountAfterTax = uz_add($amount, $tax);

        return [
            'amount' => uz_round($amount),
            'tax' => uz_round($tax),
            'after_tax' => uz_round($amountAfterTax)
        ];
    }
}

if (!function_exists('uz_discount')) {
    /**
     * Calculates the amount after applying a discount based on the specified rate.
     *
     * @param string $amount The amount to calculate the discount on.
     * @param string|DiscountAmountType $discountAmountType The discount amount type (percentage: e.g., "10%", fixed: e.g., "7.00", rate: e.g., "0.10" for 10% discount).
     * @param string $discountAmount The discount amount (could be a percentage, fixed amount, or rate).
     * @return string The amount after applying the discount, rounded to the precision defined by UZ_ROUNDING_PRECISION.
     */
    function uz_discount(string $amount, string|DiscountAmountType $discountAmountType, string $discountAmount): array {
        global $UZ_CALCULATION_PRECISION, $UZ_ROUNDING_PRECISION;

        if (is_string($discountAmountType)) {
            $discountAmountType = DiscountAmountType::tryFrom($discountAmountType);
            if (!$discountAmountType) {
                throw new \InvalidArgumentException('Discount Amount is not a valid discount amount type.');
            }
        }

        switch ($discountAmountType) {
            case DiscountAmountType::PERCENTAGE:
                $rate = bcdiv(rtrim($discountAmount, '%'), '100', $UZ_CALCULATION_PRECISION);
                $discount = bcmul($amount, $rate, $UZ_CALCULATION_PRECISION);
                break;
            case DiscountAmountType::RATE:
                $discount = bcmul($amount, $discountAmount, $UZ_CALCULATION_PRECISION);
                break;
            case DiscountAmountType::FIXED:
                $discount = $discountAmount;
                break;
            default:
                throw new \InvalidArgumentException("Invalid discount type: {$discountAmountType->value}");
        }

        $amountAfterDiscount = bcsub($amount, $discount);

        return [
            'amount' => uz_round($amount),
            'discount' => uz_round($discount),
            'after_discount' => uz_round($amountAfterDiscount)
        ];
    }
}
