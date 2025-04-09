<?php

use App\Http\Controllers\Web\Admin\AdminAlbumController;
use App\Http\Controllers\Web\Admin\PhotoboothController;
use App\Http\Controllers\Web\Customer\AlbumAccessCodeController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', AdminMiddleware::class])
  ->prefix('admin')
  ->name('admin.')
  ->group(function () {

    Route::get('/', fn () => to_route('admin.album.index'))->name('dashboard');

    Route::resource('album', AdminAlbumController::class);
    Route::resource('photobooth', PhotoboothController::class);

    Route::prefix('accessCode')->name('accessCode.')->group(function () {
      Route::post('/store', [AlbumAccessCodeController::class, 'store'])->name('store');
      Route::delete('/destroy/{albumAccessCode}', [AlbumAccessCodeController::class, 'destroy'])->name('destroy');
    });

  });
