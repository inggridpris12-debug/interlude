<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InteractionController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Landing page
Route::get('/', function () {
    return view('welcome');
});

// Authenticated routes
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

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

    // Download harus didefinisikan sebelum route show generic.
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

    // Interactions
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

require __DIR__.'/auth.php';
