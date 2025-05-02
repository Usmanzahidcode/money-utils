<?php

/// Using this file to run the library code and check things out quickly.

require_once 'vendor/autoload.php';

// Initial values
$amount = '8.08';
$taxType = 'percentage';
$taxValue = '0.015';


uz_set_precision(2);
echo "Precision Set: 2\n";
print_r(uz_tax($amount, $taxType, $taxValue));