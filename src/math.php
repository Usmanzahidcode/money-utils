<?php declare(strict_types=1);

if (!function_exists('uz_add')) {
    /**
     * Adds two numbers with high precision and rounding.
     *
     * @param string $amountA The first number to add.
     * @param string $amountB The second number to add.
     * @return string The result of adding $amountA and $amountB, rounded to the precision defined by UZ_ROUNDING_PRECISION.
     */
    function uz_add(string $amountA, string $amountB): string {
        global $UZ_CALCULATION_PRECISION;

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
        global $UZ_CALCULATION_PRECISION;

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
        global $UZ_CALCULATION_PRECISION;

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
        global $UZ_CALCULATION_PRECISION;

        if (bccomp($amountB, '0', $UZ_CALCULATION_PRECISION) === 0) {
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
        $adjustment = bcpow('10', (string)-$UZ_ROUNDING_PRECISION, $UZ_ROUNDING_PRECISION + 2);
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

if (!function_exists('uz_max')) {
    /**
     * Find the maximum amount out of many monetary values.
     *
     * @param string ...$amounts
     * @return string
     */
    function uz_max(string ...$amounts): string {
        global $UZ_CALCULATION_PRECISION;

        $max = $amounts[0];
        foreach ($amounts as $amount) {
            if (bccomp($amount, $max, $UZ_CALCULATION_PRECISION) > 0) {
                $max = $amount;
            }
        }
        return uz_round($max);
    }
}


if (!function_exists('uz_min')) {
    /**
     * Find the minimum out of many monetary values.
     *
     * @param string ...$amounts
     * @return string
     */
    function uz_min(string ...$amounts): string {
        global $UZ_CALCULATION_PRECISION;

        $min = $amounts[0];
        foreach ($amounts as $amount) {
            if (bccomp($amount, $min, $UZ_CALCULATION_PRECISION) < 0) {
                $min = $amount;
            }
        }
        return uz_round($min);
    }
}

if (!function_exists('uz_average')) {
    /**
     * Calculate the average of the given values.
     *
     * @param string ...$amounts
     * @return string
     */
    function uz_average(string ...$amounts): string {
        global $UZ_CALCULATION_PRECISION;

        if (count($amounts) === 0) {
            throw new \InvalidArgumentException('At least one amount is required to calculate average.');
        }

        $sum = '0.00';
        foreach ($amounts as $amount) {
            $sum = bcadd($sum, $amount, $UZ_CALCULATION_PRECISION);
        }

        $average = bcdiv($sum, (string)count($amounts), $UZ_CALCULATION_PRECISION);

        return uz_round($average);
    }
}

if (!function_exists('uz_sum')) {
    /**
     * Sum all the given monetary values.
     *
     * @param string ...$amounts
     * @return string
     */
    function uz_sum(string ...$amounts): string {
        global $UZ_CALCULATION_PRECISION;

        $sum = '0.00';
        foreach ($amounts as $amount) {
            $sum = bcadd($sum, $amount, $UZ_CALCULATION_PRECISION);
        }

        return uz_round($sum);
    }
}

if (!function_exists('uz_absolute')) {
    /**
     * Get the absolute value of a monetary value. Useful for negative values.
     *
     * @param string $amount
     * @return string
     */
    function uz_absolute(string $amount): string {
        return ltrim($amount, '-');
    }

}
if (!function_exists('uz_negate')) {
    /**
     * Negate a value. 5.00 becomes -5.00 and -5.00 becomes 5.00
     *
     * @param string $amount
     * @return string
     */
    function uz_negate(string $amount): string {
        global $UZ_CALCULATION_PRECISION;

        if (bccomp($amount, '0', $UZ_CALCULATION_PRECISION) === 0) {
            return '0.00';
        }

        return (str_starts_with($amount, '-')) ? ltrim($amount, '-') : '-' . $amount;
    }

    if (!function_exists('uz_compare')) {
        /**
         * Compares two numbers with the precision provided.
         *
         * @param string $amount1
         * @param string $amount2
         * @return int -1 if amount1 < amount2, 0 if equal, 1 if amount1 > amount2
         */
        function uz_compare(string $amount1, string $amount2): int {
            global $UZ_ROUNDING_PRECISION;
            return bccomp($amount1, $amount2, $UZ_ROUNDING_PRECISION);
        }
    }

    if (!function_exists('uz_is_valid_amount')) {
        /**
         * Validates if a string is a valid numeric value.
         *
         * @param mixed $value
         * @return bool
         */
        function uz_is_valid_amount(string $value): bool {
            return is_numeric($value) && preg_match('/^-?\d+(\.\d+)?$/', (string)$value);
        }
    }

}