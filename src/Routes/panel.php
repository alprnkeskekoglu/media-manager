<?php

Route::middleware(['dawnstar.auth'])->group(function () {
    Route::get('/', 'FileManagerController@index')->name('index');
});
