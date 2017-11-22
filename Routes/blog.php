<?php

use Illuminate\Support\Facades\Route;

Route::pattern('id', '[0-9]+');

Route::group([
    'namespace' => 'Blog\\Http\\Controllers',
    'middleware' => ['auth:api']
], function(){

    Route::group([
        'prefix' => 'categories',
        'as' => 'categories::',
    ], function(){

        Route::get('/', 'CategoryController@listAll')->name('listAll');
        Route::get('/{id}', 'CategoryController@get')->name('get');
        Route::get('/{id}/posts', 'CategoryController@listAllPosts')->name('listAllPosts');
        Route::post('/', 'CategoryController@create')->name('create');
        Route::put('/{id}', 'CategoryController@update')->name('update');
        Route::delete('/{id}', 'CategoryController@delete')->name('delete');

    });

    Route::group([
        'prefix' => 'posts',
        'as' => 'posts::',
    ], function(){

        Route::get('/', 'PostController@listAll')->name('listAll');
        Route::get('/{id}', 'PostController@get')->name('get');
        Route::post('/', 'PostController@create')->name('create');
        Route::put('/{id}', 'PostController@update')->name('update');
        Route::delete('/{id}', 'PostController@delete')->name('delete');

    });

});