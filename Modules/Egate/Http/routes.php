<?php

Route::group(['middleware' => 'web', 'prefix' => 'egate', 'namespace' => 'Modules\Egate\Http\Controllers'], function()
{
    Route::get('/players', 'PlayersController@index');
    Route::get('/players/add', 'PlayersController@create')->name('players/create');
    Route::post('/players/store', 'PlayersController@store')->name('players/store');
});
