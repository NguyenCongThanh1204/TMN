# Architecture & Construction — Laravel 13 + Tailwind + Alpine + MoonShine

Laravel website for an architecture and construction company, with MoonShine CMS, Turso/libSQL and Cloudinary.

## Stack
- Laravel 13.x
- Blade + Tailwind CSS v4 via Vite
- Alpine.js
- MoonShine 4.x admin
- Turso/libSQL database
- Cloudinary media storage

## Bootstrap
```bash
composer install
cp .env.example .env
php artisan key:generate
npm ci
npm run build
php artisan migrate --force
```

## Required .env values
```env
DB_CONNECTION=turso
DB_URL=https://<database-host>
DB_ACCESS_TOKEN=<turso-auth-token>
FILESYSTEM_DISK=cloudinary
CLOUDINARY_CLOUD_NAME=<cloud-name>
CLOUDINARY_API_KEY=<api-key>
CLOUDINARY_API_SECRET=<api-secret>
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
- MoonShine resources and Cloudinary Media Library

## Production checklist
1. Configure SMTP / queue / cache / file storage.
2. Supply Turso and Cloudinary credentials through the deployment platform's secret store.
3. Replace demo images and company information in `config/site.php` and seeders.
4. Build with `npm run build` and cache Laravel config/routes/views.
5. If running multiple application instances, use shared storage for sessions and full-page cache.
6. Configure real Google Maps embed URL and analytics/Search Console.
