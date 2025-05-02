<?php declare(strict_types=1);

use Usmanzahid\MoneyUtils\Enums\DiscountAmountType;
use Usmanzahid\MoneyUtils\Enums\TaxAmountType;


if (!function_exists('uz_tax')) {
    /**
     * Calculates the tax for a given amount based on the specified tax rate.
     *
     * @param string $amount The amount to calculate tax on.
     * @param string|TaxAmountType $taxAmountType The tax amount type (percentage: e.g., "10%", fixed: e.g., "3.02", rate: e.g., "0.10" for 10% rate).
     * @param string $taxAmount The tax amount (could be a percentage, fixed amount, or rate).
     * @return array The calculated tax breakdown array with "amount", "tax" and "after_tax".
     */
    function uz_tax(string $amount, string|TaxAmountType $taxAmountType, string $taxAmount): array {
        global $UZ_CALCULATION_PRECISION;

        if (is_string($taxAmountType)) {
            $taxAmountType = TaxAmountType::tryFrom($taxAmountType);
            if (!$taxAmountType) {
                throw new \InvalidArgumentException("Invalid tax type: $taxAmount");
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

        $amountAfterTax = bcadd($amount, $tax, $UZ_CALCULATION_PRECISION);

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
     * @return array The amount breakdown array with the "amount", "tax" and "after_tax".
     */
    function uz_discount(string $amount, string|DiscountAmountType $discountAmountType, string $discountAmount): array {
        global $UZ_CALCULATION_PRECISION;

        if (is_string($discountAmountType)) {
            $discountAmountType = DiscountAmountType::tryFrom($discountAmountType);
            if (!$discountAmountType) {
                throw new \InvalidArgumentException("Invalid discount type: $discountAmount");
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

        $amountAfterDiscount = bcsub($amount, $discount, $UZ_CALCULATION_PRECISION);

        return [
            'amount' => uz_round($amount),
            'discount' => uz_round($discount),
            'after_discount' => uz_round($amountAfterDiscount)
        ];
    }

}

if (!function_exists('uz_split')) {
    /**
     * Splits a monetary amount into equal parts with rounding compensation.
     *
     * Ensures the total of all parts equal the original amount by distributing
     * the smallest possible unit of the remainder across the first few parts.
     *
     * @param string $amount The total amount to split (e.g., '10.00').
     * @param int $parts The number of parts to split the amount into.
     *
     * @return string[]       Array of string values representing the split parts.
     */

    function uz_split(string $amount, int $parts): array {
        global $UZ_ROUNDING_PRECISION;

        $floorPart = bcdiv($amount, (string) $parts, $UZ_ROUNDING_PRECISION);
        $floorTotal = bcmul($floorPart, (string) $parts, $UZ_ROUNDING_PRECISION);
        $remainder = bcsub($amount, $floorTotal, $UZ_ROUNDING_PRECISION);

        // Make the base array
        $result = array_fill(0, $parts, $floorPart);

        // Distribute remainder
        $unit = bcpow('10', (string) -$UZ_ROUNDING_PRECISION, $UZ_ROUNDING_PRECISION);
        $remaindersToAdd = bcdiv($remainder, $unit);

        // Add the remainders to parts
        for ($i = 0; $i < $remaindersToAdd; $i++) {
            $result[$i] = bcadd($result[$i], $unit, $UZ_ROUNDING_PRECISION);
        }

        return $result;
    }
}

