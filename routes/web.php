<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InteractionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ThreadController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified', 'prevent-back-history'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Threads / Utas
    Route::post('/threads', [ThreadController::class, 'store'])
        ->name('threads.store');

    Route::get('/threads/{thread}', [ThreadController::class, 'show'])
        ->name('threads.show');

    Route::post('/threads/{thread}/like', [ThreadController::class, 'like'])
        ->name('threads.like');

    Route::post('/threads/{thread}/bookmark', [ThreadController::class, 'bookmark'])
        ->name('threads.bookmark');

    Route::post('/threads/{thread}/replies', [ThreadController::class, 'reply'])
        ->name('threads.replies.store');

    Route::post('/threads/{thread}/polls/{poll}/vote', [ThreadController::class, 'vote'])
        ->name('threads.poll.vote');

    Route::delete('/threads/{thread}', [ThreadController::class, 'destroy'])
        ->name('threads.destroy');

    // Explore
    Route::get('/explore', [ArticleController::class, 'explore'])
        ->name('explore');

    // Articles
    Route::get('/my-articles', [ArticleController::class, 'manage'])
        ->name('articles.manage');

    Route::get('/saved-articles', [ArticleController::class, 'saved'])
        ->name('articles.saved');

    Route::get('/articles/create', [ArticleController::class, 'create'])
        ->name('articles.create');

    Route::post('/articles', [ArticleController::class, 'store'])
        ->name('articles.store');

    Route::get('/articles/{article}/download', [ArticleController::class, 'download'])
        ->name('articles.download');

    Route::get('/articles/{slug}', [ArticleController::class, 'show'])
        ->name('articles.show');

    Route::get('/articles/{article}/edit', [ArticleController::class, 'edit'])
        ->name('articles.edit');

    Route::put('/articles/{article}', [ArticleController::class, 'update'])
        ->name('articles.update');

    Route::delete('/articles/{article}', [ArticleController::class, 'destroy'])
        ->name('articles.destroy');

    Route::post('/articles/{article}/like', [InteractionController::class, 'like'])
        ->name('articles.like');

    Route::post('/articles/{article}/bookmark', [InteractionController::class, 'bookmark'])
        ->name('articles.bookmark');

    Route::post('/articles/{article}/comments', [InteractionController::class, 'comment'])
        ->name('articles.comments.store');

    Route::post('/users/{user}/follow', [InteractionController::class, 'follow'])
        ->name('users.follow');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

// Admin routes (guard admin, terpisah dari guard web)
Route::middleware(['auth:admin', 'prevent-back-history'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard_admin');
    Route::get('/reports', [AdminController::class, 'reports'])->name('reports');
    Route::post('/reports/{report}/resolve', [AdminController::class, 'resolveReport'])->name('reports.resolve');
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::post('/logout', [AdminController::class, 'logout'])->name('logout');
});

require __DIR__.'/auth.php';
