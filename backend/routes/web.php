<?php

use App\Http\Controllers\PublicMediaController;
use Illuminate\Support\Facades\Route;

Route::get('/media/{path}', [PublicMediaController::class, 'show'])
    ->where('path', '.*')
    ->name('media.show');

Route::redirect('/', '/admin');
