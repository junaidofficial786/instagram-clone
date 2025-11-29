<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('home');

Route::get('/feed', function () {
    return Inertia::render('Feed');
})->middleware(['auth', 'verified'])->name('feed');

Route::redirect('/dashboard', '/feed');

require __DIR__.'/settings.php';
