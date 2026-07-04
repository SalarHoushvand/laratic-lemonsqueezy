# Contributing

Thank you for your interest in contributing to Laratic!

## Reporting bugs

Open a [GitHub issue](https://github.com/SalarHoushvand/laratic-lemonsqueezy/issues) with:

- A clear description of the problem
- Steps to reproduce
- Expected vs actual behavior
- Your environment (PHP version, database, OS)

For security vulnerabilities, see [SECURITY.md](SECURITY.md).

## Pull requests

1. Fork the repository and create a branch from `main`
2. Make your changes with clear, focused commits
3. Run the test suite: `./vendor/bin/pest`
4. Format code with Pint: `./vendor/bin/pint`
5. Open a pull request describing what changed and why

## Code style

This project follows [Laravel Pint](https://laravel.com/docs/pint) with the `laravel` preset. Run `./vendor/bin/pint` before submitting.

## Development setup

```bash
git clone https://github.com/SalarHoushvand/laratic-lemonsqueezy.git
cd laratic-lemonsqueezy
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate
composer run dev
```

See the [documentation](https://www.laratickit.com) for full setup and configuration details.

## Questions

For usage questions, check the [docs](https://www.laratickit.com) or open a GitHub issue.
