<?php declare(strict_types=1);

if (!function_exists('uz_percent_of')) {
    /**
     * Calculates X% of Y (e.g., 10% of 200 = 20).
     *
     * @param string $amount
     * @param string $percent
     * @return string
     */
    function uz_percent_of(string $amount, string $percent): string {
        global $UZ_CALCULATION_PRECISION;

        $rate = bcdiv($percent, '100', $UZ_CALCULATION_PRECISION);
        $result = bcmul($amount, $rate, $UZ_CALCULATION_PRECISION);

        return uz_round($result);
    }
}

if (!function_exists('uz_percent_ratio')) {
    /**
     * Calculates what percent X is of Y (e.g., 20 is what % of 200? = 10%).
     *
     * @param string $part
     * @param string $total
     * @return string
     */
    function uz_percent_ratio(string $part, string $total): string {
        global $UZ_CALCULATION_PRECISION;

        if ($total==='0') {
            throw new \InvalidArgumentException('Cannot divide by zero in percent ratio.');
        }

        $ratio = bcdiv($part, $total, $UZ_CALCULATION_PRECISION);
        $result = bcmul($ratio, '100', $UZ_CALCULATION_PRECISION);

        return uz_round($result);
    }
}

if (!function_exists('uz_percent_increase')) {
    /**
     * Increases a value by X% (e.g., 200 + 10% = 220).
     *
     * @param string $base
     * @param string $percent
     * @return string
     */
    function uz_percent_increase(string $base, string $percent): string {
        global $UZ_CALCULATION_PRECISION;

        $rate = bcdiv($percent, '100', $UZ_CALCULATION_PRECISION);
        $increment = bcmul($base, $rate, $UZ_CALCULATION_PRECISION);
        $result = bcadd($base, $increment, $UZ_CALCULATION_PRECISION);

        return uz_round($result);
    }
}

if (!function_exists('uz_percent_decrease')) {
    /**
     * Decreases a value by X% (e.g., 200 - 10% = 180).
     *
     * @param string $base
     * @param string $percent
     * @return string
     */
    function uz_percent_decrease(string $base, string $percent): string {
        global $UZ_CALCULATION_PRECISION;

        $rate = bcdiv($percent, '100', $UZ_CALCULATION_PRECISION);
        $decrement = bcmul($base, $rate, $UZ_CALCULATION_PRECISION);
        $result = bcsub($base, $decrement, $UZ_CALCULATION_PRECISION);

        return uz_round($result);
    }
}
