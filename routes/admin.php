<?php

use App\Http\Controllers\Web\Admin\AdminAlbumController;
use App\Http\Controllers\Web\Admin\AdminController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', AdminMiddleware::class])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

        Route::prefix('album')->name('album.')->group(function () {
            Route::get('/', [AdminAlbumController::class, 'index'])->name('index');
            Route::get('/show/{album}', [AdminAlbumController::class, 'show'])->name('show');
            Route::get('/edit/{album}', [AdminAlbumController::class, 'edit'])->name('edit');
            Route::get('/create', [AdminAlbumController::class, 'create'])->name('create');
        });

    });
