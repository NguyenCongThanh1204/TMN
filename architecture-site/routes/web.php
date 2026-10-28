<?php

use App\Http\Controllers\CareerController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LeaderController;
use App\Http\Controllers\MediaBrowseController;
use App\Http\Controllers\MediaRecommendationController;
use App\Http\Controllers\MoonShineMediaLibraryController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TinyEditorUploadController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Trang chủ
|--------------------------------------------------------------------------
*/

Route::get('/', HomeController::class)
    ->name('home');

/*
|--------------------------------------------------------------------------
| Giới thiệu
|--------------------------------------------------------------------------
*/

Route::get('/about', [PageController::class, 'about'])
    ->name('about');

/*
|--------------------------------------------------------------------------
| Dự án
|--------------------------------------------------------------------------
*/

Route::get('/projects', [ProjectController::class, 'index'])
    ->name('projects.index');

Route::get('/projects/{project:slug}', [ProjectController::class, 'show'])
    ->name('projects.show');

/*
|--------------------------------------------------------------------------
| Tuyển dụng
|--------------------------------------------------------------------------
*/

Route::prefix('careers')
    ->name('careers.')
    ->group(function () {

        Route::get('/', [CareerController::class, 'index'])
            ->name('index');

        Route::post('/apply', [CareerController::class, 'apply'])
            ->middleware('throttle:10,1')
            ->name('apply');

        Route::get('/{career}', [CareerController::class, 'show'])
            ->name('show');
    });

/*
|--------------------------------------------------------------------------
| Tin tức
|--------------------------------------------------------------------------
*/

Route::get('/news', [PostController::class, 'index'])
    ->name('news.index');

Route::get('/news/{post:slug}', [PostController::class, 'show'])
    ->name('news.show');

Route::post('/manager/tiny-mce/upload', TinyEditorUploadController::class)
    ->middleware('auth:moonshine')
    ->name('moonshine.tiny-mce.upload');

Route::prefix(config('moonshine.prefix', 'manager'))
    ->middleware('auth:moonshine')
    ->group(function (): void {
        Route::get('/media-library/browse', MediaBrowseController::class)
            ->name('moonshine.media-library.browse');
        Route::post('/media-library/folders', [MoonShineMediaLibraryController::class, 'storeFolder'])
            ->name('moonshine.media-library.folders.store');
        Route::patch('/media-library/folders/{folder}', [MoonShineMediaLibraryController::class, 'updateFolder'])
            ->name('moonshine.media-library.folders.update');
        Route::delete('/media-library/folders/{folder}', [MoonShineMediaLibraryController::class, 'destroyFolder'])
            ->name('moonshine.media-library.folders.destroy');
        Route::post('/media-library/upload', [MoonShineMediaLibraryController::class, 'upload'])
            ->name('moonshine.media-library.upload');
        Route::delete('/media-library/media/{media}', [MoonShineMediaLibraryController::class, 'destroyMedia'])
            ->name('moonshine.media-library.media.destroy');
        Route::post('/media-library/recommendations', MediaRecommendationController::class)
            ->name('moonshine.media-library.recommendations');
    });

/*
|--------------------------------------------------------------------------
| Liên hệ
|--------------------------------------------------------------------------
*/

Route::get('/contact', [ContactController::class, 'index'])
    ->name('contact.index');

Route::post('/contact', [ContactController::class, 'store'])
    ->middleware('throttle:10,1')
    ->name('contact.store');

/*
|--------------------------------------------------------------------------
| Đối tác
|--------------------------------------------------------------------------
*/

Route::get('/partners', [PartnerController::class, 'index'])
    ->name('partners.index');

Route::get('/api/partners', [PartnerController::class, 'apiList'])
    ->name('partners.apiList');

/*
|--------------------------------------------------------------------------
| Lãnh đạo
|--------------------------------------------------------------------------
*/

Route::get('/leaders', [LeaderController::class, 'index'])
    ->name('leaders.index');

Route::get('/{prefix}/{path}', function (
    string $prefix,
    string $path
) {

    $path = ltrim($path, '/');

    if (Storage::disk('public')->exists($path)) {

        return response()->file(
            Storage::disk('public')->path($path)
        );
    }

    if (Storage::disk('local')->exists($path)) {

        return response()->file(
            Storage::disk('local')->path($path)
        );
    }

    abort(
        404,
        'Không tìm thấy file hình ảnh.'
    );

})
    ->whereIn('prefix', [
        'storage',
        'media',
    ])
    ->where('path', '.*')
    ->name('media.stream');

Route::get('/download-database-backup', function () {
    $path = database_path('database.sqlite');

    abort_unless(
        file_exists($path),
        404,
        'Database SQLite không tồn tại.'
    );

    return response()->download(
        $path,
        'render-production-backup.sqlite'
    );
});
