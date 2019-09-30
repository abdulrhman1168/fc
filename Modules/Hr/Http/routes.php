<?php

Route::group(['middleware' => 'web', 'prefix' => 'hr', 'namespace' => 'Modules\Hr\Http\Controllers'], function()
{
    Route::get('/', 'HrController@index')->name('hr.index');
    Route::get('/employees', 'ِEmployeesController@index')->name('employees');
    Route::get('/employees/create', 'ِEmployeesController@create')->name('employees/create');
    Route::post('/employees/store', 'ِEmployeesController@store')->name('employees/store');
});
