<?php

require_once 'vendor/autoload.php';

$amount = '8.08';
$taxType = 'percentage';
$taxValue = '0.015';

uz_set_precision(2);
$result = uz_tax($amount, $taxType, $taxValue);

print_r($result);

uz_set_precision(3);
$result = uz_tax($amount, $taxType, $taxValue);

print_r($result);

uz_set_precision(5);
$result = uz_tax($amount, $taxType, $taxValue);

print_r($result);
