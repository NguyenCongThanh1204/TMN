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


Route::get('/', HomeController::class)
    ->name('home');


Route::get('/about', [PageController::class, 'about'])
    ->name('about');


Route::get('/projects', [ProjectController::class, 'index'])
    ->name('projects.index');

Route::get('/projects/{project:slug}', [ProjectController::class, 'show'])
    ->name('projects.show');



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



Route::get('/news', [PostController::class, 'index'])
    ->name('news.index');

Route::get('/news/{post:slug}', [PostController::class, 'show'])
    ->name('news.show');




Route::get('/contact', [ContactController::class, 'index'])
    ->name('contact.index');

Route::post('/contact', [ContactController::class, 'store'])
    ->middleware('throttle:10,1')
    ->name('contact.store');



Route::get('/partners', [PartnerController::class, 'index'])
    ->name('partners.index');

Route::get('/api/partners', [PartnerController::class, 'apiList'])
    ->name('partners.apiList');




Route::get('/leaders', [LeaderController::class, 'index'])
    ->name('leaders.index');



Route::get('/debug-home', function () {

    if (!config('app.debug')) {
        abort(404);
    }

    try {

        return app(HomeController::class)();

    } catch (\Throwable $e) {

        return response()->json([
            'success' => false,

            'message' => $e->getMessage(),

            'exception' => get_class($e),

            'file' => $e->getFile(),

            'line' => $e->getLine(),

            'trace' => explode(
                PHP_EOL,
                $e->getTraceAsString()
            ),
        ], 500);
    }

})->name('debug.home');


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

})->whereIn('prefix', [
    'storage',
    'media',
])->where(
    'path',
    '.*'
)->name('media.stream');