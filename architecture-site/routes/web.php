<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\{
    HomeController,
    PageController,
    ProjectController,
    PostController,
    CareerController,
    ContactController,
    partnerController,
    LeaderController,
};

// Trang chủ & Giới thiệu
Route::get('/', HomeController::class)->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');

// Dự án
Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
Route::get('/projects/{project:slug}', [ProjectController::class, 'show'])->name('projects.show'); 
// (Nếu ProjectController dùng id thì đổi thành {project})

// Tuyển dụng (Careers)
Route::prefix('careers')->name('careers.')->group(function () {
    Route::get('/', [CareerController::class, 'index'])->name('index');
    Route::post('/apply', [CareerController::class, 'apply'])->middleware('throttle:10,1')->name('apply');
    Route::get('/{career}', [CareerController::class, 'show'])->name('show');
});

// Tin tức (News)
Route::get('/news', [PostController::class, 'index'])->name('news.index');
Route::get('/news/{post:slug}', [PostController::class, 'show'])->name('news.show');

// Liên hệ
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'store'])->middleware('throttle:10,1')->name('contact.store');

// Đối tác
Route::get('/partners', [PartnerController::class, 'index'])->name('partners.index');
Route::get('/api/partners', [PartnerController::class, 'apiList'])->name('partners.apiList');

// Lãnh đạo
Route::get('/leaders', [LeaderController::class, 'index'])->name('leaders.index');



// Stream file ảnh dùng chung cho cả /storage và /media (hỗ trợ cả disk public và private)
Route::get('/{prefix}/{path}', function ($prefix, $path) {
    $path = ltrim($path, '/');

    // 1. Kiểm tra và trả về từ disk public nếu tồn tại
    if (Storage::disk('public')->exists($path)) {
        return response()->file(Storage::disk('public')->path($path));
    }

    // 2. Dự phòng: kiểm tra và trả về từ disk local (private) nếu ảnh cũ lưu nhầm
    if (Storage::disk('local')->exists($path)) {
        return response()->file(Storage::disk('local')->path($path));
    }

    abort(404, 'Không tìm thấy file hình ảnh.');
})->where('prefix', 'storage|media')->where('path', '.*')->name('media.stream');