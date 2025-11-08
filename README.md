# Vue's minimalist blog

### Description: 

A minimalist blog built with Laravel 9 and the Inertia + Vue 3 stack. It provides a simple, elegant admin UI, a custom CKEditor-based rich text editor, image handling, optional S3 storage, dark mode and more — perfect for personal blogs, tutorials and simple publications.

## Minimum requirements
These are the minimum requirements to run the application locally (non-Docker):

- PHP 8.0+ (8.1 recommended)
- BCMath, Ctype, Fileinfo, JSON, Mbstring, OpenSSL, PDO, Tokenizer, XML extensions enabled
- Composer 2.x
- Node.js 16+ and npm or pnpm
- MySQL 5.7+/MariaDB or PostgreSQL
- Redis (optional, for cache/queues)
- Git

If you use Docker / Laravel Sail, you only need Docker Desktop / Docker Engine and Git on your machine.

## Features

- Laravel 9 + Vue 3 + Inertia.js
- Jetstream scaffolding (Inertia stack)
- Custom CKEditor for rich post editing
- Minimalist admin panel with dark mode
- Infinite scroll for posts
- Private posts support
- Image upload and storage (local & S3)
- S3-compatible storage support (AWS, DigitalOcean Spaces, MinIO, etc.)
 - Public REST API (v1) — blog listing endpoint with filtering/pagination and a Sanctum-protected user endpoint

## Preview

<p> <img src="https://kuronneko.github.io/assets/img/portfolioblog.png" width="450"> </p>

## Installation (normal / local)
Follow these steps when installing locally without Docker.

1. Clone the repo and enter folder

```bash
git clone <repo-url> solidblack
cd solidblack
```

2. Copy the example env and install PHP dependencies

```bash
cp .env.example .env
composer install --no-interaction --prefer-dist
```

3. Configure environment

Edit `.env` and set database credentials and other settings (APP_URL, DB_*, MAIL_*, etc.). If you plan to use S3, set `FILESYSTEM_DISK=s3` and configure the AWS_* variables.

4. Generate app key and run database migrations

```bash
php artisan key:generate
php artisan migrate
php artisan storage:link
```

## Create a dev user (artisan tinker)

You can create a development user quickly using `artisan tinker`. The examples below create a user with email `dev@example.com` and password `password`. Change the values before running in any non-development environment.

Interactive (recommended):

```bash
php artisan tinker
```

Then in the tinker REPL run:

```php
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Setting;

// create a simple setting record
Setting::create(['status' => 'Hola mundo']);

User::create([
	'name' => 'Dev',
	'email' => 'dev@example.com',
	'password' => Hash::make('password'),
	'email_verified_at' => now(),
]);
```

One-line (non-Docker):

```bash
php artisan tinker --execute "use App\\Models\\Setting; use App\\Models\\User; use Illuminate\\Support\\Facades\\Hash; Setting::create(['status'=>'Hola mundo']); User::create(['name'=>'Dev User','email'=>'dev@example.com','password'=>Hash::make('password'),'email_verified_at'=>now()]);"
```

One-line (Sail / Docker):

```bash
./vendor/bin/sail php artisan tinker --execute "use App\\Models\\Setting; use App\\Models\\User; use Illuminate\\Support\\Facades\\Hash; Setting::create(['status'=>'Hola mundo']); User::create(['name'=>'Dev User','email'=>'dev@example.com','password'=>Hash::make('password'),'email_verified_at'=>now()]);"
```

Verify the user (example):

```bash
php artisan tinker --execute "App\\Models\\User::where('email','dev@example.com')->first()->toArray();"

Verify the setting (example):

```bash
php artisan tinker --execute "App\\Models\\Setting::first()->toArray();"
```
```

Notes:

- Don’t use these example credentials in production.
- Ensure database migrations were run and DB settings in `.env` are correct before creating users.
- If you use Sail, run the Sail variants so commands execute inside the containers.

5. Install frontend dependencies and build

```bash
npm install
npm run dev
```

6. Serve the application

```bash
php artisan serve
# then open http://127.0.0.1:8000
```

## Installation (Docker - Laravel Sail)
These steps use Laravel Sail (recommended for reproducible development environments).

1. Clone the repo and enter folder

```bash
git clone <repo-url> solidblack
cd solidblack
```

2. Copy env and install PHP dependencies locally (or inside container)

```bash
cp .env.example .env
composer install --no-interaction --prefer-dist
```

3. Install Sail (if not present) and bring up containers

```bash
php artisan sail:install --with=mysql,redis # optional: choose services you want
./vendor/bin/sail up -d
```

4. Run artisan commands inside Sail

```bash
./vendor/bin/sail php artisan key:generate
./vendor/bin/sail php artisan storage:link
./vendor/bin/sail php artisan migrate --seed
```

5. Install frontend dependencies and run dev server inside Sail

```bash
./vendor/bin/sail npm install
./vendor/bin/sail npm run dev
```

6. Optional: rebuild images (if you changed Dockerfile or dependencies)

```bash
./vendor/bin/sail build --no-cache
```

Open the app in your browser at the address provided by Sail (usually http://localhost).

## S3 / Remote storage
To enable S3-compatible storage, set the following variables in your `.env` and set `FILESYSTEM_DISK=s3`:

```
AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=
AWS_ENDPOINT=          # optional (for non-AWS S3 compatible providers)
AWS_BUCKET=
AWS_UPLOAD_FOLDER=     # optional prefix inside the bucket
```

Ensure `config/filesystems.php` is configured for S3 (this repo already includes S3 support) and that you have correct IAM policies/permissions for the bucket.

## Useful commands

- Run migrations: `php artisan migrate`
- Run seeders: `php artisan db:seed`
- Run tests: `./vendor/bin/phpunit`
- Sail artisan: `./vendor/bin/sail php artisan <command>`

## API Endpoints (v1)

Below are the public API endpoints currently available in this project. Paths are relative to your app base URL (for example: `https://example.test/api/v1/...`).

- GET `/api/user`
	- Auth: `auth:sanctum` (requires authenticated session or API token)
	- Description: Returns the authenticated user's information.
	- Success: 200 JSON user object.

- GET `/api/v1/blogs`
	- Auth: public (no auth required)
	- Description: Retrieve blog posts filtered by category and paginated using `skip`/`take`.
	- Query parameters:
		- `categories` (required) — comma-separated list of category names (alphanumeric and commas only). Example: `categories=laravel,php`
		- `skip` (optional, integer >= 0) — number of records to skip (offset).
		- `take` (optional, integer 1-999) — number of records to return.
		- `order` (optional) — ordering: `asc`, `desc` (default `desc`) or `random`.
	- Response: success wrapper with `data` containing a collection of `BlogResource` objects (posts). On errors returns structured error/fail responses.
	- Example request:

```bash
curl "http://localhost/api/v1/blogs?categories=tech,laravel&skip=0&take=10&order=desc"
```

Notes:

- The `GetBlogRequest` request validation requires `categories` and validates `skip`/`take` numeric limits. `order` is handled in the controller (supports `random`).
- The API controllers return a structured response using the project's response helpers (`response()->success`, `response()->fail`, `response()->error`). Check the controllers or `app/Http/Resources` for response shapes if you need exact field names.

## Notes

- If you hit permission issues with `storage` or `bootstrap/cache`, ensure the web server user (or container user) can write to those directories.
- The included seeders provide a default development user; change credentials in production.
