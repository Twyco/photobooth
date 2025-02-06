<?php

use App\Http\Controllers\Web\AdminController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', AdminMiddleware::class])->group(function () {

    Route::get('/admin/', [AdminController::class, 'dashboard'])->name('admin.dashboard');

});
