# phlg

Phlg is an API logging application built with [Laravel](https://laravel.com). It provides a web dashboard for managing applications and viewing messages, plus an authenticated API endpoint for storing log messages.

## Requirements

- PHP 8.0.2 or newer
- [Composer](https://getcomposer.org/)
- Node.js and npm
- MySQL or another Laravel-supported relational database

## Clone the repository

```bash
git clone https://github.com/joefearnley/phlg.git
cd phlg
```

## Installation

Install PHP and JavaScript dependencies:

```bash
composer install
npm install
```

Create your local environment file and application key:

```bash
cp .env.example .env
php artisan key:generate
```

Create a database, then update the database settings in `.env`:

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=phlg
DB_USERNAME=root
DB_PASSWORD=
```

Run the database migrations:

```bash
php artisan migrate
```

Optionally seed local development data:

```bash
php artisan db:seed
```

Build frontend assets:

```bash
npm run build
```

For local development, run the Laravel server and Vite dev server in separate terminals:

```bash
php artisan serve
npm run dev
```

The app will be available at `http://127.0.0.1:8000` by default.

## Testing

Run the full test suite with:

```bash
php artisan test
```

## API

API routes are prefixed with `/api`. The current API version is `v1`.

All API endpoints require Laravel Sanctum authentication. Send a bearer token with each request:

```http
Authorization: Bearer <token>
Accept: application/json
Content-Type: application/json
```

### Create a message

Stores a log message for an active application.

```http
POST /api/v1/messages
```

Request body:

```json
{
  "application_id": 1,
  "level_id": 1,
  "body": "This is a message."
}
```

Fields:

| Field | Type | Required | Description |
| --- | --- | --- | --- |
| `application_id` | integer | Yes | ID of an existing active application. |
| `level_id` | integer | Yes | ID of an existing message level. Seeded levels include `INFO`, `ERROR`, and `DEBUG`. |
| `body` | string | Yes | Message text to store. |

Successful response:

```http
200 OK
```

```json
{
  "success": true,
  "message": {
    "application_id": 1,
    "level_id": 1,
    "body": "This is a message.",
    "updated_at": "2026-05-09T12:00:00.000000Z",
    "created_at": "2026-05-09T12:00:00.000000Z",
    "id": 1
  }
}
```

Error responses:

| Status | Cause |
| --- | --- |
| `401 Unauthorized` | Missing or invalid Sanctum token, or the application is inactive. |
| `422 Unprocessable Entity` | Missing or invalid `application_id`, `level_id`, or `body`. |

Example `curl` request:

```bash
curl -X POST http://127.0.0.1:8000/api/v1/messages \
  -H "Authorization: Bearer <token>" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -d '{"application_id":1,"level_id":1,"body":"This is a message."}'
```

## Contributing

1. Fork the repository or create a branch from `main`.
2. Install dependencies and configure the app using the installation steps above.
3. Make your changes in a focused branch.
4. Add or update tests for behavior changes.
5. Run `php artisan test` before opening a pull request.
6. Open a pull request with a clear summary of the change and any testing notes.

Keep changes focused and avoid mixing unrelated refactors with feature work or bug fixes.
