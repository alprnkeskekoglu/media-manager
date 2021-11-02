<?php

use Dawnstar\MediaManager\Http\Controllers\MainController;
use Dawnstar\MediaManager\Http\Controllers\FolderController;
use Dawnstar\MediaManager\Http\Controllers\MediaController;

Route::get('/',  [MainController::class, 'index']);
Route::get('translations',  [MainController::class, 'translations']);
Route::get('getStorageStatus', [MainController::class, 'getStorageStatus']);

Route::apiResource('folders', FolderController::class);
Route::post('folders/recover', [FolderController::class, 'recover']);
Route::post('folders/force-delete', [FolderController::class, 'forceDelete']);

Route::get('medias/getSelected', [MediaController::class, 'getSelected']);
Route::apiResource('medias', MediaController::class);
Route::post('medias/recover', [MediaController::class, 'recover']);
Route::post('medias/force-delete', [MediaController::class, 'forceDelete']);

