# Financial Calculations Utilities for USD

This package provides a set of utility functions to handle basic financial calculations in USD, ensuring high precision and safe handling of rounding errors.

If you're building a financial module—like a subscription system—on top of an existing application, this utility is the simplest and most effective way to
handle USD calculations. It avoids the bloat of full-scale money libraries and keeps your code clean, precise, and easy to maintain.

Larger libraries often over-engineer solutions for basic needs, introducing unnecessary complexity for handling simple dollar amounts. This utility focuses on
high-precision arithmetic, rounding safety, and common use cases like tax or discount calculations.

If you eventually need advanced features or multi-currency support, libraries like Brick\Money might be worth exploring. But for most USD-only scenarios, this
is all you need.

## Purpose

Perform essential arithmetic operations (addition, subtraction, multiplication, division) and common financial calculations (tax, discount) without worrying
about rounding errors or floating-point inaccuracies. Ideal for simple USD-based operations.

## Features

- **High Precision Calculations**: Avoid floating-point inaccuracies by using high precision arithmetic.
- **Rounding**: Results are rounded to 2 decimal places (standard for USD).
- **Basic Financial Calculations**: Includes functions for tax and discount calculations.

## Use Cases

This library is ideal for situations where you need basic calculations like:

- E-commerce price calculations with tax and discount.
- Simple financial calculations involving USD currency.
- The only thing you must stay away from in financial calculations: Rounding at wrong step.

## Limitations

This is not a full-featured money management system. If you need multi-currency support or advanced financial features, consider using a more comprehensive
library like `Brick\Money`

## Conclusion

For simple USD calculations without the headache of rounding or floating point errors, this library is a lightweight, reliable solution.
