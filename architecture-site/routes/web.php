<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{HomeController,PageController,ProjectController,PostController,CareerController,ContactController};
Route::get('/',HomeController::class)->name('home');
Route::get('/about',[PageController::class,'about'])->name('about');
Route::get('/projects',[ProjectController::class,'index'])->name('projects.index');
Route::get('/projects/{project}',[ProjectController::class,'show'])->name('projects.show');
Route::get('/careers',[CareerController::class,'index'])->name('careers.index');
Route::post('/careers/apply',[CareerController::class,'apply'])->middleware('throttle:10,1')->name('careers.apply');
Route::get('/news',[PostController::class,'index'])->name('news.index');
Route::get('/news/{post}',[PostController::class,'show'])->name('news.show');
Route::get('/contact',[ContactController::class,'index'])->name('contact.index');
Route::post('/contact',[ContactController::class,'store'])->middleware('throttle:10,1')->name('contact.store');

