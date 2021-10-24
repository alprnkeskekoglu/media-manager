<?php

use Dawnstar\MediaManager\Http\Controllers\FolderController;
use Dawnstar\MediaManager\Http\Controllers\MediaController;

Route::get('/', function () {
    return view('MediaManager::index');
});

Route::apiResource('folders', FolderController::class);
Route::post('folders/recover', [FolderController::class, 'recover']);
Route::post('folders/force-delete', [FolderController::class, 'forceDelete']);

Route::apiResource('medias', MediaController::class);
Route::post('medias/recover', [MediaController::class, 'recover']);
Route::post('medias/force-delete', [MediaController::class, 'forceDelete']);

Route::get('getStorageStatus', [MediaController::class, 'getStorageStatus'])->name('storage');
