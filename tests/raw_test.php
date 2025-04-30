<?php

require_once 'vendor/autoload.php';

$amount = '0.015';
$taxType = 'fixed';
$taxValue = '0.015';

uz_set_precision(3);
$result = uz_tax($amount, $taxType, $taxValue);

print_r($result);
