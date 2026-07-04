# Laratic (Lemon Squeezy)

Laratic is a Laravel + Livewire SaaS starter kit with **Lemon Squeezy** billing, authentication, admin dashboard, AI features, blog, and more.

Licensed under the [MIT License](LICENSE).

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

Configure your `.env` file for mail, Lemon Squeezy, OpenAI, and other services.

Default seeded admin (local dev only): `admin@email.com` / `password`

## Documentation

Full documentation: [https://www.laratickit.com](https://www.laratickit.com)

Other variants:

- [Laratic Paddle](https://github.com/SalarHoushvand/laratic-paddle)
- [Laratic Stripe](https://github.com/SalarHoushvand/laratic-stripe)

## Contributing

See [CONTRIBUTING.md](CONTRIBUTING.md).

## License

MIT — see [LICENSE](LICENSE).
