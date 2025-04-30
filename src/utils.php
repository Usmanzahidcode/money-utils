<?php declare(strict_types=1);

const UZ_CALCULATION_PRECISION = 8; // For calculating at longer precision for better reliability.
const UZ_ROUNDING_PRECISION = 2; // For USD

if (!function_exists('uz_add')) {
    /**
     * Adds two numbers with high precision and rounding.
     *
     * @param string $a The first number to add.
     * @param string $b The second number to add.
     * @return string The result of adding $a and $b, rounded to the precision defined by UZ_ROUNDING_PRECISION.
     */
    function uz_add(string $a, string $b): string {
        $result = bcadd($a, $b, UZ_CALCULATION_PRECISION);
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
    function uz_sub(string $a, string $b): string {
        $result = bcsub($a, $b, UZ_CALCULATION_PRECISION);
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
    function uz_mul(string $a, string $b): string {
        $result = bcmul($a, $b, UZ_CALCULATION_PRECISION);
        return uz_round($result);
    }
}

if (!function_exists('uz_div')) {
    /**
     * Divides one number by another with high precision and rounding.
     *
     * @param string $a The numerator.
     * @param string $b The denominator.
     * @return string The result of dividing $a by $b, rounded to the precision defined by UZ_ROUNDING_PRECISION.
     * @throws InvalidArgumentException if $b is zero.
     */
    function uz_div(string $a, string $b): string {
        if (bccomp($b, '0', UZ_CALCULATION_PRECISION) === 0) {
            throw new \InvalidArgumentException('Division by zero.');
        }
        $result = bcdiv($a, $b, UZ_CALCULATION_PRECISION);
        return uz_round($result);
    }
}

if (!function_exists('uz_round')) {
    /**
     * Rounds a number with high precision for calculations, then rounds to the standard format.
     *
     * @param string $number The number to round.
     * @return string The rounded number, with precision defined by UZ_ROUNDING_PRECISION.
     */
    function uz_round(string $number): string {
        $calculationPrecision = UZ_CALCULATION_PRECISION;
        $roundingPrecision = UZ_ROUNDING_PRECISION;

        // Resolve the adjustment amount.
        $adjustment = bcpow('10', (string)-$roundingPrecision, $roundingPrecision + 2);
        $adjustment = bcdiv($adjustment, '2', $roundingPrecision + 2);

        if (bccomp($number, '0', $calculationPrecision) >= 0) {
            $rounded = bcadd($number, $adjustment, $calculationPrecision);
        } else {
            $rounded = bcsub($number, $adjustment, $calculationPrecision);
        }

        return bcadd($rounded, '0', $roundingPrecision);
    }
}

if (!function_exists('uz_tax')) {
    /**
     * Calculates the tax for a given amount based on the specified tax rate.
     *
     * @param string $amount The amount to calculate tax on.
     * @param string $rate The tax rate (e.g., 0.2 for 20%).
     * @return string The calculated tax amount, rounded to the precision defined by UZ_ROUNDING_PRECISION.
     */
    function uz_tax(string $amount, string $rate): string {
        $tax = uz_mul($amount, $rate);
        return uz_round($tax);
    }
}

if (!function_exists('uz_discount')) {
    /**
     * Calculates the amount after applying a discount based on the specified rate.
     *
     * @param string $amount The amount to calculate the discount on.
     * @param string $rate The discount rate (e.g., 0.1 for 10%).
     * @return string The amount after applying the discount, rounded to the precision defined by UZ_ROUNDING_PRECISION.
     */
    function uz_discount(string $amount, string $rate): string {
        $discount = uz_mul($amount, $rate);
        $amountAfterDiscount = uz_sub($amount, $discount);
        return uz_round($amountAfterDiscount);
    }
}
