<?php declare(strict_types=1);

if (!function_exists('uz_add')) {
    function uz_add(string $a, string $b, int $scale = 8): string {
        return bcadd($a, $b, $scale);
    }
}

if (!function_exists('uz_sub')) {
    function uz_sub(string $a, string $b, int $scale = 8): string {
        return bcsub($a, $b, $scale);
    }
}

if (!function_exists('uz_mul')) {
    function uz_mul(string $a, string $b, int $scale = 8): string {
        return bcmul($a, $b, $scale);
    }
}

if (!function_exists('uz_div')) {
    function uz_div(string $a, string $b, int $scale = 8): string {
        return bcdiv($a, $b, $scale);
    }
}

if (!function_exists('uz_round')) {
    function uz_round(string $value, int $precision = 2): string {
        $scale = $precision + 1;
        $factor = bcpow('10', (string)$precision, $scale);
        $scaled = bcmul($value, $factor, $scale);

        $integerPart = bcdiv($scaled, '1', 0);
        $decimalPart = bcsub($scaled, $integerPart, $scale);

        $shouldRoundUp = bccomp($decimalPart, '0.5', $scale) >= 0;
        if ($shouldRoundUp) {
            $integerPart = bcadd($integerPart, '1');
        }

        return bcdiv($integerPart, $factor, $precision);
    }

}

