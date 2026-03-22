# PADEL ACE

A Laravel-based padel tournament management and rankings platform for the Düsseldorf padel community.

## Features

- **Tournament management** — Monthly (DPT) and Weekly tournament series with division-based categories
- **Player rankings** — Point-based ranking system with automatic division promotion (Beginner → Intermediate → Advanced → Professional)
- **Player accounts** — Registration, login, profile management, and booking history
- **Admin panel** — Create/update/delete tournaments, manage player rankings, paginated player list
- **Password reset** — Email-based password reset flow
- **Security** — CSRF protection, rate limiting on auth endpoints, session-based authentication

## Tech Stack

- **Backend:** PHP 8.2, Laravel 12, Eloquent ORM
- **Frontend:** Vanilla JS, Blade templates, custom CSS
- **Database:** MySQL (production) / SQLite (testing)
- **Admin UI:** Filament 3 (available at `/filament`)

## Requirements

- PHP >= 8.2 with PDO, mbstring, openssl extensions
- Composer
- Node.js & npm
- MySQL database

## Setup

```bash
# 1. Install PHP dependencies
composer install

# 2. Copy and configure environment
cp .env.example .env
# Edit .env — set APP_URL, DB_*, MAIL_* values

# 3. Generate application key
php artisan key:generate

# 4. Run database migrations
php artisan migrate

# 5. Install and build frontend assets
npm install && npm run build

# 6. Start the development server
php artisan serve
```

> **Production checklist** — before going live:
> - Set `APP_ENV=production` and `APP_DEBUG=false` in `.env`
> - Set `APP_URL` to your real `https://` domain
> - Set `SESSION_SECURE_COOKIE=true`
> - Configure a real mail provider (`MAIL_MAILER`, `MAIL_HOST`, etc.)
> - Run `php artisan config:cache && php artisan route:cache`

## Running Tests

```bash
composer test
```

## Project Structure

```
app/
  Http/Controllers/   — AuthController, TournamentController, ProfileController, AdminController, RankingController
  Models/             — User, Tournament, TournamentRegistration, RankingAdjustment
  Http/Middleware/    — EnsureAdmin
resources/views/      — Blade templates (layouts, auth, tournaments, rankings, profile, admin, legal)
routes/
  web.php             — Browser routes
  api.php             — JSON API routes (session-authenticated)
database/migrations/  — All schema migrations
```

## License

MIT
