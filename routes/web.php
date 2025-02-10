<?php

use App\Http\Controllers\Web\AlbumAccessCodeController;
use App\Http\Controllers\Web\AlbumController;
use App\Http\Controllers\Web\PageController;
use App\Http\Controllers\Web\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [PageController::class, 'home'])->name('home');

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
        Route::get('/{album:uuid}', [AlbumController::class, 'show'])->name('show');
        Route::post('/{album:uuid}/save', [AlbumController::class, 'save'])->name('save');

    });

Route::post('/accessCode', [AlbumAccessCodeController::class, 'use'])->name('accessCode.use');

require __DIR__ . '/auth.php';
require __DIR__ . '/admin.php';
