<?php

use App\Http\Controllers\Web\Admin\AdminAlbumController;
use App\Http\Controllers\Web\customer\AlbumAccessCodeController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', AdminMiddleware::class])
  ->prefix('admin')
  ->name('admin.')
  ->group(function () {

    Route::get('/', fn () => to_route('admin.albums.index'))->name('dashboard');

    Route::resource('albums', AdminAlbumController::class);

    Route::prefix('accessCode')->name('accessCode.')->group(function () {
      Route::post('/store', [AlbumAccessCodeController::class, 'store'])->name('store');
      Route::delete('/destroy/{albumAccessCode}', [AlbumAccessCodeController::class, 'destroy'])->name('destroy');
    });

  });
