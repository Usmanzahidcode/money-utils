# Financial Calculations Utilities

Minimalist utilities for precise financial calculations with adjustable rounding precision.

### Why Use This?

If you're building a system with USD calculations (e.g., subscriptions, checkout systems, invoicing), this package:

- Prevents rounding errors.
- Stays lightweight.
- Keeps calculations predictable and clean.
- You don’t need a full-blown money library for simple use cases — just reliable math.

### Features

- High-precision arithmetic using bcmath
- Safe, configurable rounding (uz_set_precision())
- Helpers for tax and discount calculations
- Currency-agnostic: works with any decimal-based currency

### Installation

```bash
composer require usmanzahid/money-utils
```

### Usage

```php
uz_set_precision(3); // Rounds to 3 decimal places

uz_add('10.257', '5.124'); 
// "15.381"

uz_tax('100.00', 'percentage', '10%'); 
// ['amount' => "100.000", 'tax' => "10.000", 'after_tax' => "110.000"]

uz_discount('200.00', 'rate', '0.255'); 
// ['amount' => "200.000", 'discount' => "51.000", 'after_discount' => "149.000"]

```

### Note

This library is not a full-featured money solution. Its primary goal is to abstract and safely handle rounding logic in financial calculations.

Ensure consistency in the precision your system operates with. For example, if you're working with USD, enforce a precision of 2 decimal places. Introducing
values with mismatched precision (e.g., 3 decimal places for USD) is a design flaw—not something any library can correct. Your system should enforce and
validate precision strictly.

For advanced setup requiring features like multi-currency support, formatting, or immutability, consider using the excellent `brick/money`.