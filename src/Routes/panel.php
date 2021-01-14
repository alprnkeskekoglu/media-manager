<?php

Route::middleware(['dawnstar.auth'])->group(function () {
    Route::get('/', 'FileManagerController@index')->name('index');
    Route::get('/upload', 'FileManagerController@upload')->name('upload');
    Route::get('/trash', 'FileManagerController@trash')->name('trash');


    Route::post('/delete', 'FileManagerController@delete')->name('delete');
    Route::post('/recover', 'FileManagerController@recover')->name('recover');


    Route::post('/uploadFromComputer', 'FileManagerController@uploadFromComputer')->name('uploadFromComputer');
    Route::post('/uploadFromUrl', 'FileManagerController@uploadFromUrl')->name('uploadFromUrl');
});
