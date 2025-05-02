<?php

require_once 'vendor/autoload.php';

// Initial values
$amount = '8.08';
$taxType = 'percentage';
$taxValue = '0.015';

echo "=== Manual Precision Tests ===\n";
echo "Amount: $amount | Tax Type: $taxType | Tax Value: $taxValue\n\n";

// Precision: 2
uz_set_precision(2);
echo "Precision Set: 2\n";
print_r(uz_tax($amount, $taxType, $taxValue));

// Precision: 3
uz_set_precision(3);
echo "Precision Set: 3\n";
print_r(uz_tax($amount, $taxType, $taxValue));

// Precision: 5
uz_set_precision(5);
echo "Precision Set: 5\n";
print_r(uz_tax($amount, $taxType, $taxValue));


/// ----------------------------------------------------------------------


// Auto Precision Test
echo "\n=== Auto Precision Test ===\n";

$amount = '8.08';
$taxType = 'percentage';
$taxValue = '0.015';

echo "Amount: $amount | Tax Type: $taxType | Tax Value: $taxValue\n\n";

$testAmountsForPrecision = ['0.123', '0.12345', '1.2', '10.999999', '0.00001', '954.98273646286378264'];
uz_set_precision_auto($testAmountsForPrecision[0], ...$testAmountsForPrecision);

print_r(uz_tax($amount, $taxType, $taxValue));


/// -------------------------------------------------------------------------

echo "\n=== Split test ===\n";

uz_set_precision(2);
print_r(uz_split("100.00", 3));