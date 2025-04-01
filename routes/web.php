<?php

use App\Http\Controllers\Web\customer\AlbumAccessCodeController;
use App\Http\Controllers\Web\customer\AlbumController;
use App\Http\Controllers\Web\customer\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', fn () => Inertia::render('Customer/Home/Index'))->name('home');
Route::get('/alben', [AlbumController::class, 'index'])->name('album.index');
Route::post('/accessCode', [AlbumAccessCodeController::class, 'use'])->name('accessCode.use');
Route::get('album/{album:uuid}', [AlbumController::class, 'show'])->name('album.show');

Route::middleware('auth')->group(function () {
  Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
  Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
  Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

  Route::post('album/{album:uuid}/save', [AlbumController::class, 'save'])->name('album.save');
});

require __DIR__ . '/auth.php';
require __DIR__ . '/admin.php';
