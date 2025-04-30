<?php declare(strict_types=1);

const UZ_CALCULATION_PRECISION = 8; // For calculating at longer precision for better reliability.
const UZ_ROUNDING_PRECISION = 2; // For USD

if (!function_exists('uz_add')) {
    function uz_add(string $a, string $b): string {
        $result = bcadd($a, $b, UZ_CALCULATION_PRECISION);
        return uz_round($result);
    }
}

if (!function_exists('uz_sub')) {
    function uz_sub(string $a, string $b): string {
        $result = bcsub($a, $b, UZ_CALCULATION_PRECISION);
        return uz_round($result, UZ_ROUNDING_PRECISION);
    }
}

if (!function_exists('uz_mul')) {
    function uz_mul(string $a, string $b): string {
        $result = bcmul($a, $b, UZ_CALCULATION_PRECISION);
        return uz_round($result);
    }
}

if (!function_exists('uz_div')) {
    function uz_div(string $a, string $b): string {
        if (bccomp($b, '0', UZ_CALCULATION_PRECISION) === 0) {
            throw new \InvalidArgumentException('Division by zero.');
        }
        $result = bcdiv($a, $b, UZ_CALCULATION_PRECISION);
        return uz_round($result);
    }
}

if (!function_exists('uz_round')) {
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
