# Deployment notes

## 1. Install dependencies and build assets
```bash
composer install
npm ci
npm run build
```

## 2. Database + storage
```bash
php artisan migrate --force
```

Set `DB_CONNECTION=turso`, `DB_URL`, `DB_ACCESS_TOKEN`, and the Cloudinary credentials in the deployment platform's secret store. Do not commit `.env` or production credentials.

## 3. Local development
```bash
npm run dev
php artisan serve
```

## 4. Production
```bash
php artisan optimize
```

Configure SMTP, queue workers, HTTPS and Cloudinary. Full-page cache and file sessions are local to each machine; use a shared store if the app runs on multiple instances.

## 5. Replace demo data
Update:
- `config/site.php`
- `database/seeders/DatabaseSeeder.php`
- the Google Maps iframe in `resources/views/contact/index.blade.php`
- demo Unsplash images with company-owned optimized WebP/AVIF assets
