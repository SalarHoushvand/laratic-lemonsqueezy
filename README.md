# Laratic Lemon Squeezy

A Laravel + Livewire SaaS starter kit with **Lemon Squeezy** billing built in. Ship subscriptions, one-time products, and a full customer-facing app without wiring payments from scratch.

**Documentation:** [laratickit.com](https://www.laratickit.com)

## Features

- Lemon Squeezy subscriptions, checkouts, and webhooks
- Authentication with email verification and two-factor auth
- Admin dashboard for users, orders, posts, and billing
- AI chat, content generation, and usage tracking
- Blog with tags, translations, and SEO-friendly pages
- File uploads to S3, newsletter integration, and more

## Tech stack

- Laravel
- Livewire
- Tailwind CSS
- Alpine JS

## Getting started

### 1. Clone and install

```bash
git clone https://github.com/SalarHoushvand/laratic-lemonsqueezy.git
cd laratic-lemonsqueezy
composer install
npm install
```

### 2. Environment

```bash
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan storage:link
```

Update `.env` with your credentials for the services you plan to use:

| Service | Key variables |
| --- | --- |
| Lemon Squeezy | `LEMON_SQUEEZY_API_KEY`, `LEMON_SQUEEZY_STORE`, `LEMON_SQUEEZY_SIGNING_SECRET` |
| OpenAI | `OPENAI_API_KEY` |
| Mail | `MAIL_*` or Mailgun settings |
| AWS S3 | `AWS_*` |
| Mailchimp | `NEWSLETTER_API_KEY`, `NEWSLETTER_LIST_ID` |

### 3. Run locally

```bash
composer run dev
```

This starts the app server, queue worker, log tail, and Vite dev server together.

