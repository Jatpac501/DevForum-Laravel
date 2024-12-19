<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ThreadController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\UserMiddleware;

Route::get('/', [CategoryController::class, 'index'])->name('homepage');

//Треды
Route::get('/{category}/threads', [ThreadController::class, 'index'])->name('threads.index');
Route::get('/threads/{thread}', [ThreadController::class, 'show'])->name('threads.show');

Route::middleware('auth', UserMiddleware::class)->group(function () {
    Route::get('{category}/threads/create', [ThreadController::class, 'create'])->name('threads.create');
    Route::post('{category}/threads/create', [ThreadController::class, 'store'])->name('threads.store');
    Route::get('/threads/{thread}/edit', [ThreadController::class, 'edit'])->name('threads.edit');
    Route::put('/threads/{thread}/update', [ThreadController::class, 'update'])->name('threads.update');
    // Route::patch('/threads/{thread}/update', [ThreadController::class, 'update'])->name('threads.update');
    Route::post('/threads/{thread}/remove', [ThreadController::class, 'remove'])->name('threads.remove');
    Route::post('/threads/{thread}/restore', [ThreadController::class, 'restore'])->name('threads.restore');
    Route::post('/threads/{thread}/pin', [ThreadController::class, 'pin'])->name('threads.pin');
});

//Комментарии
Route::prefix('comments')->middleware('auth', UserMiddleware::class)->group(function () {
    Route::post('/{thread}', [CommentController::class, 'store'])->name('comments.store');
    Route::put('/{comment}', [CommentController::class, 'update'])->name('comments.update');
    // Route::patch('/{comment}', [CommentController::class, 'update'])->name('comments.update');
    Route::delete('/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
    Route::post('{comment}/remove', [CommentController::class, 'remove'])->name('comments.remove');
    Route::post('{comment}/pin', [CommentController::class, 'pin'])->name('comments.pin');
});

//Профиль
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::middleware('auth', AdminMiddleware::class)->group(function () {
    Route::post('/profile/{user}/ban', [ProfileController::class, 'ban'])->name('profile.ban');
});

require __DIR__.'/auth.php';
