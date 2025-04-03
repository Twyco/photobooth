<?php

use App\Http\Controllers\Api\AlbumController;
use Illuminate\Support\Facades\Route;

Route::post('/upload-image', [AlbumController::class , 'storeImage']);