# Contribution Guide

Thank you for your interest in contributing to this project!

## Getting Started

1. **Fork the repository**
2. **Clone your fork locally**:
   ```bash
   git clone https://github.com/your-username/money-utils.git
   cd money-utils
   ```
3. Install dependencies:
   ```bash
   composer install
   ```

## Code Standards
- Follow PSR-12 coding style.
- Use type hints, strict types, and consistent docblocks.
- Validate and sanitize all input before processing.

## Testing
All new features must include test coverage.

Run tests with:
```bash
./vendor/bin/phpunit tests/ --testdox
```

## Pull Request Guidelines

- Keep PRs focused (one fix/feature per PR).
- Write clear commit messages.
- Reference related issues when applicable.
- Ensure your branch is up to date with the main branch.

## Communication

- Open an issue before starting large work.
- Propose ideas or improvements via issues or discussions.
- All kinds of ideas are welcome.
