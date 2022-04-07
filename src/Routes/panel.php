<?php

use Dawnstar\MediaManager\Http\Controllers\MainController;
use Dawnstar\MediaManager\Http\Controllers\FolderController;
use Dawnstar\MediaManager\Http\Controllers\MediaController;

Route::controller(MainController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('translations', 'translations');
    Route::get('getStorageStatus', 'getStorageStatus');
});

Route::apiResource('folders', FolderController::class);
Route::controller(FolderController::class)->group(function () {
    Route::post('folders/recover', 'recover');
    Route::post('folders/force-delete', 'forceDelete');
});

Route::apiResource('medias', MediaController::class);
Route::controller(MediaController::class)->group(function () {
    Route::get('medias/getSelected', 'getSelected');
    Route::post('medias/recover', 'recover');
    Route::post('medias/force-delete', 'forceDelete');
});
