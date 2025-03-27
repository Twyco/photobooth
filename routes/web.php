<?php

use App\Http\Controllers\Web\customer\AlbumAccessCodeController;
use App\Http\Controllers\Web\customer\AlbumController;
use App\Http\Controllers\Web\customer\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', fn () => Inertia::render('Customer/Home/Index'))->name('home');
Route::get('/alben', [AlbumController::class, 'index'])->name('album.index');




Route::get('album/{album:uuid}', [AlbumController::class, 'show'])->name('album.show');

Route::middleware('auth')->group(function () {
  Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
  Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
  Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

  Route::prefix('album')
    ->name('album.')
    ->group(function () {
      Route::get('/', [AlbumController::class, 'index'])->name('index');
      Route::post('/{album:uuid}/save', [AlbumController::class, 'save'])->name('save');
      Route::post('/accessCode', [AlbumAccessCodeController::class, 'use'])->name('accessCode.use');
    });
});


require __DIR__ . '/auth.php';
require __DIR__ . '/admin.php';
