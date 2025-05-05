# Financial Calculations Utilities

A minimalist utility library for **precise**, **reliable**, and **configurable** financial computations.  
Built specifically for financial workflows where **rounding accuracy** and **consistency** matter most.

This library is designed to eliminate the common pitfalls in financial calculations—like **precision errors**,
**rounding discrepancies**, and **accumulation anomalies**—by handling all of it **automatically** for you.

## Key Features

- Define your **desired rounding precision** once.
- Perform all calculations with confidence—the library handles **intermediate precision** and rounds only when
  appropriate.
- Say goodbye to manually rounding every step or remembering when to round—**just pass your values in**, and the library
  takes care of the rest.
- Powered by **BCMath** under the hood to ensure **high-precision** arithmetic.

Ideal for developers who want to **avoid hidden rounding bugs** and ensure consistent output across their entire
financial system.

## Important Disclaimer

This library is not a magical fix for flawed system design. It will handle **rounding** and **precision** reliably, but
it won’t compensate for **structural inconsistencies** or ambiguous business logic.

**For Example:**  
If your system operates in USD but you're working with values like `"0.015" + "0.015" = "0.030"`, you’ll run into issues
when rounding for display (`0.02 + 0.02 ≠ 0.03`).  
This isn’t a bug in calculation—it’s a mismatch in your rounding strategy or design assumptions.

## Best Practices

To get the most from this library and avoid common pitfalls:

- Clearly define the **monetary units** and rules your system follows.
- Set and enforce **precision levels** based on the currency in use.
- Never use **floats**—always use **strings** for financial values.

[Docs & Usage](./DocsAndUsage.md)  
[Contribution Guide](./Contribution.md)

## Note

If you need structured monetary representation with `Money` and `Currency` classes, following Martin Fowler's Money
pattern, or native multi-currency support, consider using `Brick\Money`.  
However, be aware that even with advanced libraries, flawed system design will still lead to issues that no tool can
fix.
