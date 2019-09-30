<?php

Route::group(['middleware' => 'web', 'prefix' => 'department-services', 'namespace' => 'Modules\DepartmentServices\Http\Controllers'], function()
{
   

   


    // Authorization Controller
    Route::get('/authorization/search', 'AuthorizationController@employeesSearch')->name('authorization.search');
    Route::get('/authorization/{id}/remove', 'AuthorizationController@removeAuthorization')->name('authorization.remove');
    Route::resource('authorization', 'AuthorizationController', ['only' => ['index', 'create', 'store', 'show']]);

  
});
