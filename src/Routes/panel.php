<?php

Route::middleware(['dawnstar.auth'])->group(function () {
    Route::get('/', 'FileManagerController@index')->name('index');
    Route::get('/upload', 'FileManagerController@upload')->name('upload');
});
