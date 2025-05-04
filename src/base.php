<?php declare(strict_types=1);

// TODO: isnpired by the recent encryption lib mention that fact that staying away form the roundign is not magic...

// TODO: Finalize the documentation with the final touch, personal tone and proper brick/money reference.

// TODO: in the money utils make sure the tax and discount method round properly and not prematurely.


if (!function_exists('uz_set_precision_auto')) {
    /**
     * Set the precision for the final results. This depends on what are you working with?
     *
     * @param string $amount
     * @param string ...$amounts
     * @return void
     */
    function uz_set_precision_auto(string $amount, string ...$amounts): void {
        $noOfDecimals = strlen(explode('.', $amount)[1] ?? '0.00');

        foreach ($amounts as $amount) {
            $noOfDecimals_ = strlen(explode('.', $amount)[1] ?? '0.00');

            if ($noOfDecimals_ > $noOfDecimals) {
                $noOfDecimals = $noOfDecimals_;
            }
        }

        uz_set_precision($noOfDecimals);
    }
}

if (!function_exists('uz_set_precision')) {
    /**
     * Set the precision for the final results. This depends on what are you working with?
     *
     * @param int $precision The precision to use for final results.
     * @return void
     */
    function uz_set_precision(int $precision): void {
        global $UZ_CALCULATION_PRECISION, $UZ_ROUNDING_PRECISION;

        // Set the rounding precision
        $UZ_ROUNDING_PRECISION = $precision;

        // Set the calculation precision based on the rounding precision
        $guardDigits = max(4, (int) ceil($UZ_ROUNDING_PRECISION * 0.3));
        $UZ_CALCULATION_PRECISION = $UZ_ROUNDING_PRECISION + $guardDigits;
    }
}

