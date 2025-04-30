<?php

require_once 'vendor/autoload.php';

$amount = '0.015';
$taxType = 'fixed';
$taxValue = '0.015';

$result = uz_tax($amount, $taxType, $taxValue);

print_r($result);
