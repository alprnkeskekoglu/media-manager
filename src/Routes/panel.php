<?php

Route::middleware(['dawnstar.auth'])->group(function () {
    Route::get('/', 'FileManagerController@index')->name('index');
    Route::get('/create', 'FileManagerController@create')->name('create');

    Route::post('/uploadFromComputer', 'FileManagerController@uploadFromComputer')->name('uploadFromComputer');
});
