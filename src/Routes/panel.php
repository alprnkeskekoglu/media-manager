<?php


Route::get('/', function () {
    return view('media-manager');
});

Route::apiResource('folders', \App\Http\Controllers\FolderController::class);
Route::post('folders/recover', [\App\Http\Controllers\FolderController::class, 'recover']);
Route::post('folders/force-delete', [\App\Http\Controllers\FolderController::class, 'forceDelete']);

Route::apiResource('medias', \App\Http\Controllers\MediaController::class);
Route::post('medias/recover', [\App\Http\Controllers\MediaController::class, 'recover']);
Route::post('medias/force-delete', [\App\Http\Controllers\MediaController::class, 'forceDelete']);

Route::get('getStorageStatus', [\App\Http\Controllers\MediaController::class, 'getStorageStatus'])->name('storage');
