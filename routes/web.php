<?php

use App\Http\Controllers\Web\Customer\AlbumAccessCodeController;
use App\Http\Controllers\Web\Customer\AlbumController;
use App\Http\Controllers\Web\Customer\ProfileController;
use App\Http\Middleware\EnsureEmailIsVerifiedIfAuthenticated;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware([EnsureEmailIsVerifiedIfAuthenticated::class])->group(function () {
    Route::get('/', fn () => Inertia::render('Customer/Home/Index'))->name('home');
    Route::get('/alben', [AlbumController::class, 'index'])->name('album.index');
    Route::post('/accessCode', [AlbumAccessCodeController::class, 'use'])->name('accessCode.use');
    Route::get('album-view/{album:uuid}', [AlbumController::class, 'show'])->name('album.show');
    Route::get('album-view/{album:uuid}/{imageNumber}', [AlbumController::class, 'showImage'])->name('album.image.show');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware([EnsureEmailIsVerifiedIfAuthenticated::class])->post('album-view/{album:uuid}/save', [AlbumController::class, 'save'])->name('album.save');
});

require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
