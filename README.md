# AfriDish

A Laravel 8 marketplace connecting customers with home chefs and restaurants
serving African cuisine. Customers browse and order dishes; chefs/restaurants
manage their own menu and orders; admins manage the platform.

## Local development

Requires PHP 8.1 or 8.2, Composer, and Node/npm.

```bash
composer install
cp .env.example .env
php artisan key:generate
```

Edit `.env` and point `DB_*` at a MySQL database (or set `DB_CONNECTION=sqlite`
and `DB_DATABASE` at a local `.sqlite` file for quick local testing).

```bash
php artisan migrate
php artisan db:seed --class=DemoDataSeeder   # optional: sample chefs, dishes, etc.
php artisan serve
```

## Deploying (Railway)

The repo includes a `Dockerfile` and `railway.json`, so Railway builds and
runs it automatically once connected — no manual server setup.

1. On [railway.app](https://railway.app), create a new project from this
   GitHub repo (`AfriDish-Inc/afridish`).
2. Add a MySQL database to the same project (Railway's "+ New" → Database →
   MySQL). Railway wires its `DB_*` variables into the app automatically
   when the two services are linked.
3. In the app service's Variables tab, set at minimum:
   - `APP_KEY` — generate locally with `php artisan key:generate --show`
     and paste the output (starts with `base64:`)
   - `APP_URL` — the Railway-provided domain (or your custom domain)
   - Anything else from `.env.example` your launch actually needs (Stripe,
     PayPal, social login, FCM push notifications) — everything else has a
     safe default and can be filled in later.
4. Deploy. The container runs migrations automatically on boot
   (`docker-entrypoint.sh`).

**Known limitation:** file uploads (chef/restaurant images, etc.) are
written to local disk (`public/upload`), which is not persistent across
Railway redeploys. Fine for an initial launch; move to S3-compatible
storage before relying on user-uploaded content sticking around.
