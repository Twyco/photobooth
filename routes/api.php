<?php

use App\Http\Controllers\Api\AlbumController;
use App\Http\Middleware\AuthenticatePhotobooth;
use Illuminate\Support\Facades\Route;

Route::middleware([AuthenticatePhotobooth::class])->post('/upload-image', [AlbumController::class, 'storeImage']);
