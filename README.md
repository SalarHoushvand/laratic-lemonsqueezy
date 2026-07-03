# Laratic (Lemon Squeezy)

Laratic is a Laravel 12 + Livewire SaaS starter kit with **Lemon Squeezy** billing, authentication, admin dashboard, AI features, blog, and more.

Licensed under the [MIT License](LICENSE).

## Documentation

Full documentation: [https://laratic.com/docs/installation](https://laratic.com/docs/installation)

Other variants:

- [Laratic Paddle](https://github.com/SalarHoushvand/laratic-paddle)
- [Laratic Stripe](https://github.com/SalarHoushvand/laratic-stripe)

## Requirements

- PHP 8.2+
- Composer
- Node.js 18+
- A database (SQLite, MySQL, or PostgreSQL)

## Installation

```bash
git clone https://github.com/SalarHoushvand/laratic-lemonsqueezy.git
cd laratic-lemonsqueezy
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan storage:link
composer run dev
```

Then configure your `.env` file for mail, Lemon Squeezy, OpenAI, and other services. See the [documentation](https://laratic.com/docs/installation) for details.

## License

MIT — see [LICENSE](LICENSE).
