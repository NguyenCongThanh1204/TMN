<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CareerController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\LeaderController;


/*
|--------------------------------------------------------------------------
| Trang chủ
|--------------------------------------------------------------------------
*/

Route::get('/', HomeController::class)
    ->name('home');


/*
|--------------------------------------------------------------------------
| Debug trang chủ - TẠM THỜI
|--------------------------------------------------------------------------
|
| Route này dùng để bắt chính xác exception của HomeController trên Render.
| Sau khi sửa xong lỗi 500 thì XÓA route này.
|
*/

Route::get('/debug-home', function () {

    try {

        return app(HomeController::class)();

    } catch (\Throwable $e) {

        return response()->json([
            'success' => false,

            'message' => $e->getMessage(),

            'exception' => get_class($e),

            'file' => $e->getFile(),

            'line' => $e->getLine(),

            'app_debug' => config('app.debug'),

            'app_env' => app()->environment(),

            'app_url' => config('app.url'),

            'db_connection' => config('database.default'),

            'db_database' => config('database.connections.sqlite.database'),

            'trace' => explode(
                PHP_EOL,
                $e->getTraceAsString()
            ),
        ], 500);
    }

})->name('debug.home');


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


/*
|--------------------------------------------------------------------------
| Storage / Media
|--------------------------------------------------------------------------
|
| Hỗ trợ:
| /storage/...
| /media/...
|
*/

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