<?php

Route::group(['middleware' => 'web', 'prefix' => 'auth', 'namespace' => 'Modules\Auth\Http\Controllers'], function()
{
  // Authentication routes
  Route::get('login', 'AuthController@showLoginForm')->name('login');
  Route::post('auth', 'AuthController@login')->name('auth');
  Route::post('sso-authorize', 'AuthController@ssoAuthorize')->name('sso-auth');
  Route::get('logout', 'AuthController@logout')->name('logout');
  
  Route::post('api-login', 'AuthController@apiLogin')->name('api-login');
});

Route::group(['middleware' => 'api', 'prefix' => 'auth', 'namespace' => 'Modules\Auth\Http\Controllers'], function()
{
  Route::post('api-login', 'AuthController@apiLogin')->name('api-login');
  Route::post('api-logout', 'AuthController@apiLogout')->name('api-logout');
});