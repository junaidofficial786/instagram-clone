<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('home');

Route::get('/feed', [\App\Http\Controllers\FeedController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('feed');

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'index'])->name('profile');
    Route::get('/profile/{username}', [App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/avatar', [App\Http\Controllers\ProfileController::class, 'deleteAvatar'])->name('profile.avatar.delete');
    // Posts
    Route::resource('posts', \App\Http\Controllers\PostController::class)->only(['create', 'store', 'destroy']);
    
    // Likes
    Route::post('/posts/{post}/like', [\App\Http\Controllers\LikeController::class, 'store'])->name('posts.like');
    Route::delete('/posts/{post}/like', [\App\Http\Controllers\LikeController::class, 'destroy'])->name('posts.unlike');
    Route::get('/posts/{post}/likes', [\App\Http\Controllers\PostLikesController::class, 'index'])->name('posts.likes');
});

Route::redirect('/dashboard', '/feed');

require __DIR__.'/settings.php';
