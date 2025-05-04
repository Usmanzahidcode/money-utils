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

_**Note:** This package only supports decimal amounts (e.g., 10.00) and does not handle cent-based implementations. This design choice was intentional, as cent-based
support was not within the original scope of development._

### Installation

```bash
composer require usmanzahid/money-utils
```

### Methods

`uz_set_precision(int $precision): void`

Sets the precision for the final results. This function is essential for ensuring that your calculations are consistent and follow the appropriate precision.

**Usage:**

```php
uz_set_precision(3); // Rounds to 3 decimal places
```

- Default Precision: By default, the package uses a precision of 2 decimal places (standard for USD).
- Best Practice: Set the precision at the entry point of your application (e.g., in your configuration files) to enforce consistent rounding logic across your
  entire system.
- Example for USD: If you are working with USD or any currency that uses two decimal places, that is the default.

Ensure that your system always works with a consistent precision to avoid design flaws caused by mismatched values (e.g., trying to use 3 decimal places for
USD).

`uz_add(string $amountA, string $amountB): string`

Adds two numbers with high precision and rounding.

**Usage:**

```php
uz_add('10.257', '5.124'); 
// Returns: "15.381"
```

`uz_sub(string $amountA, string $amountB): string`

Subtracts one number from another with high precision and rounding.
**Usage:**

```php
uz_sub('10.257', '5.124'); 
// Returns: "5.133"
```

`uz_mul(string $amountA, string $amountB): string`

Multiplies two numbers with high precision and rounding.

**Usage:**

```php
uz_mul('10.257', '5.124'); 
// Returns: "52.475"
```

`uz_div(string $amountA, string $amountB): string`

Divides one number by another with high precision and rounding. Throws an exception if dividing by zero.

**Usage:**

```php
uz_div('10.257', '5.124');
// Returns: "2.000"
```

`uz_round(string $amount): string`

Rounds a number with high precision for calculations, then rounds to the standard format defined by the set precision.

This method is primarily used internally within the package to handle rounding after arithmetic operations. However, in certain cases, you may want to
explicitly round a value to the precision you have set.

**Usage:**

```php
$roundedAmount = uz_round(10.25789);
// Returns "10.26"
```

- **Note:** The uz_round function will always round the number according to the precision defined by you.

`uz_tax(string $amount, string|TaxAmountType $taxAmountType, string $taxAmount): array`

Calculates the tax for a given amount based on the specified tax rate.

**Parameters:**

- $amount: The amount to calculate tax on.
- $taxAmountType: The type of tax amount (TaxAmountType::PERCENTAGE, TaxAmountType::RATE, or TaxAmountType::FIXED) or lowercase equivalent string.
- $taxAmount: The tax amount (could be a percentage, fixed amount, or rate).

**Usage:**

```php
uz_tax('100.00', 'percentage', '10%');
// Returns: ['amount' => "100.000", 'tax' => "10.000", 'after_tax' => "110.000"]
```

`uz_discount(string $amount, string|DiscountAmountType $discountAmountType, string $discountAmount): array`

Calculates the amount after applying a discount based on the specified rate.

**Parameters:**

- $amount: The amount to calculate the discount on.
- $discountAmountType: The type of discount amount (DiscountAmountType::PERCENTAGE, DiscountAmountType::RATE, or DiscountAmountType::FIXED) or lowercase
  equivalent string.
- $discountAmount: The discount amount (could be a percentage, fixed amount, or rate).

**Usage:**

```php
uz_discount('200.00', 'rate', '0.255');
// Returns: ['amount' => "200.000", 'discount' => "51.000", 'after_discount' => "149.000"]

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