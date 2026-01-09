# Environment & Security Recommendations

## Environment variables
- Store configuration in `.env` file (already standard for Laravel).
- Important variables:
  - `DB_CONNECTION=mysql`
  - `DB_HOST=127.0.0.1`
  - `DB_PORT=3306`
  - `DB_DATABASE=tilrimal`
  - `DB_USERNAME=root`
  - `DB_PASSWORD=`
  - `APP_URL=http://localhost:8000`
  - `FRONTEND_URL=http://localhost:3000`

- For CI or production, set environment variables in your host provider (do not commit `.env`).

## CORS
- Allow the frontend origin in CORS config (e.g., `FRONTEND_URL`).
- If using `fruitcake/laravel-cors` or Laravel's built-in CORS middleware, add your frontend URL to the allowed origins.

Example (config/cors.php):
```php
'paths' => ['api/*'],
'allowed_methods' => ['*'],
'allowed_origins' => [env('FRONTEND_URL', 'http://localhost:3000')],
'allowed_headers' => ['*'],
'exposed_headers' => [],
'max_age' => 0,
'supports_credentials' => false,
```

## API Security
- Add authentication (JWT, Laravel Sanctum, or Passport) for user-specific bookings or admin endpoints.
- Validate and sanitize all input on the backend (we included basic validation).
- Use HTTPS in production and enforce secure cookies if using session authentication.
- Log payment attempts and do not store sensitive payment credentials locally.
- Prepare webhook endpoints for production payment gateways; validate requests using signatures.

## Database backups & migrations
- Keep migration files under version control (done).
- For production, test migrations on a staging DB first, and have regular backups of MySQL.
