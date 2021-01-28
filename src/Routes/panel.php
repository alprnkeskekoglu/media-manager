<?php

Route::middleware(['dawnstar.auth'])->group(function () {

    Route::get('/upload', 'FileManagerController@upload')->name('upload');
    Route::get('/{type?}', 'FileManagerController@index')->name('index');


    Route::post('/recover', 'FileManagerController@recover')->name('recover');


    Route::post('/uploadFromComputer', 'FileManagerController@uploadFromComputer')->name('uploadFromComputer');
    Route::post('/uploadFromUrl', 'FileManagerController@uploadFromUrl')->name('uploadFromUrl');


    Route::as('api.')->prefix('api')->group(function (){
         Route::get('/getMedias', 'ApiFileManagerController@getMedias')->name('getMedias');
         Route::get('/getSelectedMedias', 'ApiFileManagerController@getSelectedMedias')->name('getSelectedMedias');
         Route::get('/getMediaFolders', 'ApiFileManagerController@getMediaFolders')->name('getMediaFolders');
         Route::post('/deleteMedia', 'ApiFileManagerController@deleteMedia')->name('deleteMedia');
         Route::post('/recoverMedia', 'ApiFileManagerController@recoverMedia')->name('recoverMedia');
    });
});
