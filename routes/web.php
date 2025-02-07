<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Web\AlbumController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('home');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])
    ->prefix('album')
    ->name('album.')
    ->group(function () {

        Route::get('/', [AlbumController::class, 'index'])->name('index');
        Route::get('/show/{album:uuid}', [AlbumController::class, 'show'])->name('show');

    });

require __DIR__ . '/auth.php';
require __DIR__ . '/admin.php';
