# Architecture & Construction — Laravel 13 + Tailwind + Alpine + Nova

Production-oriented starter source for a high-end architecture/construction corporate website.

## Stack
- Laravel 13.x
- Blade + Tailwind CSS v4 via Vite
- Alpine.js
- Laravel Nova 5.x (optional but recommended for CMS)
- MySQL

## Bootstrap
```bash
laravel new architecture-construction
cd architecture-construction
# copy this package's app/, database/, resources/, routes/ and config/ into the Laravel app
composer require laravel/nova:"^5.9"
npm install
npm install tailwindcss @tailwindcss/vite alpinejs
cp .env.example .env
php artisan key:generate
php artisan storage:link
php artisan migrate --seed
npm run dev
php artisan serve
```

Nova requires an active license/account and its official Composer repository access. After installing Nova:
```bash
php artisan nova:install
php artisan migrate
```

## Required .env values
```env
APP_NAME="Architecture & Construction"
APP_URL=http://127.0.0.1:8000
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=architecture
DB_USERNAME=root
DB_PASSWORD=
MAIL_MAILER=log
CONTACT_EMAIL=hello@example.com
```

## Included
- Homepage, About, Projects, Project detail, Careers, News, Article detail, Contact
- Dynamic projects/posts/jobs/leads
- Project gallery + media model
- Lead/inquiry storage with CV/drawing uploads
- Responsive Tailwind UI
- Alpine mobile menu, filters, lightbox, reading progress
- JSON-LD for LocalBusiness, Project and Article
- Pagination and basic SEO metadata
- Seed data with demo content
- Nova resources scaffold

## Production checklist
1. Configure SMTP / queue / cache / file storage.
2. Replace demo images and company information in `config/site.php` and seeders.
3. Add authorization for Nova resources.
4. Use object storage/CDN for production media.
5. Build with `npm run build` and cache Laravel config/routes/views.
6. Add image transformations / WebP or AVIF pipeline.
7. Configure real Google Maps embed URL and analytics/Search Console.
