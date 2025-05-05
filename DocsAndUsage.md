# Documentation & Usage

This guide shows how to use the utility functions provided by the package, including formatting, currency conversion,
tax, and discount calculations. Each example is concise and practical, making integration straightforward for real-world
applications.

```php
require_once 'vendor/autoload.php';

// Set up the precision at the entry point or start of your application for consistency.
uz_set_precision(2);

// If you have a calculation place where you don't know the precision, then you can pass in all the number that will
// be used in the calculations and the library will set up the precision automatically to the highest. Useful where
// precision is not defined.
uz_set_precision_auto('10.120', '20.1234', '5.1');

```

## Percentage methods

```php
uz_percent_of('200', '10');           // "20.00"
uz_percent_ratio('20', '200');        // "10.00"
uz_percent_increase('200', '10');     // "220.00"
uz_percent_decrease('200', '10');     // "180.00"

```

## Arithmetic methods

```php
uz_add('10.12', '2.34');              // "12.46"
uz_sub('10.12', '2.34');              // "7.78"
uz_mul('10.00', '3.25');              // "32.50"
uz_div('10.00', '2.00');              // "5.00"

uz_max('1.01', '5.99', '3.14');       // "5.99"
uz_min('1.01', '5.99', '3.14');       // "1.01"
uz_average('2.00', '4.00', '6.00');   // "4.00"
uz_sum('1.10', '2.20', '3.30');       // "6.60"

uz_absolute('-45.67');               // "45.67"
uz_negate('45.67');                  // "-45.67"
uz_negate('-45.67');                 // "45.67"

```

## Rounding method

Used mostly internally by the library, but you may use it if needed rather than manually rounding.

```php
uz_round('12.3456');                  // "12.35" (assuming 2 precision)
```

## Tax, Discount & discount

```php

// Split money in parts
uz_split('10.00', 3); // ["3.34", "3.33", "3.33"]


// You can either pass the tax type as string or enum "Usmanzahid\MoneyUtils\Enums\TaxAmountType"

uz_tax('100.00', TaxAmountType::PERCENTAGE, '10%');
// returns ['amount' => '100.00', 'tax' => '10.00', 'after_tax' => '110.00']

uz_tax('100.00', TaxAmountType::FIXED, '5.00');
// returns ['amount' => '100.00', 'tax' => '5.00', 'after_tax' => '105.00']

uz_tax('100.00', TaxAmountType::RATE, '0.15');
// returns ['amount' => '100.00', 'tax' => '15.00', 'after_tax' => '115.00']


// You can also pass the discount type as string or enum "Usmanzahid\MoneyUtils\Enums\DiscountAmountType"

uz_discount('100.00', DiscountAmountType::PERCENTAGE, '10%');
// returns ['amount' => '100.00', 'discount' => '10.00', 'after_discount' => '90.00']

uz_discount('100.00', DiscountAmountType::FIXED, '7.00');
// returns ['amount' => '100.00', 'discount' => '7.00', 'after_discount' => '93.00']

uz_discount('100.00', DiscountAmountType::RATE, '0.25');
// returns ['amount' => '100.00', 'discount' => '25.00', 'after_discount' => '75.00']

```
