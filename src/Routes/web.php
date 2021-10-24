<?php

use Dawnstar\MediaManager\Http\Controllers\MediaController;

Route::get('/media/{uid}', [MediaController::class, 'media'])->name('media');
