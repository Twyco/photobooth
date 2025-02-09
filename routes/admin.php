<?php

use App\Http\Controllers\Web\Admin\AdminController;
use App\Http\Controllers\Web\AlbumController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', AdminMiddleware::class])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

        Route::prefix('album')->name('album.')->group(function () {
            Route::get('/edit/{album}', [AlbumController::class, 'edit'])->name('edit');
            Route::get('/create', [AlbumController::class, 'create'])->name('create');
            Route::post('/store', [AlbumController::class, 'store'])->name('store');
            Route::patch('/update/{album}', [AlbumController::class, 'update'])->name('update');
            Route::delete('/destroy/{album}', [AlbumController::class, 'destroy'])->name('destroy');
        });

    });
