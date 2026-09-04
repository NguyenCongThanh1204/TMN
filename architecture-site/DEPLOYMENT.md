# Deployment notes

## 1. Create the Laravel app
Use Laravel 13.x. The current Laravel documentation identifies 13.x as the current framework line in 2026.

```bash
laravel new architecture-construction
cd architecture-construction
```

Copy this package over the generated application, preserving `artisan`, `bootstrap/`, `public/index.php`, framework config and the normal Laravel skeleton.

## 2. Install dependencies
```bash
composer install
composer require laravel/nova:"^5.9"
npm install
```

Nova is a commercial Laravel administration package and requires an eligible Nova account/license and Composer repository authentication.

## 3. Database + storage
```bash
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
```

## 4. Local development
```bash
npm run dev
php artisan serve
```

## 5. Production
```bash
npm run build
php artisan optimize
php artisan storage:link
```

Configure a real SMTP provider, queue worker, cache, HTTPS and an object-storage/CDN disk for images/uploads.

## 6. Replace demo data
Update:
- `config/site.php`
- `database/seeders/DatabaseSeeder.php`
- the Google Maps iframe in `resources/views/contact/index.blade.php`
- demo Unsplash images with company-owned optimized WebP/AVIF assets

## 7. Nova
After Nova is installed, expose the resources under `/nova` and create/authorize your Nova users. Resources are located in `app/Nova`.
