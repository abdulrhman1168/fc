<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// language route
Route::get('/locale/{locale}', 'LocaleController@change')->name('locale');

// Index Routes
Route::get('/', 'Index\HomeController@index')->name('home');
Route::post('/update-menu-status', 'Index\HomeController@updateMenuStatus')->name('update-menu-status');

Route::view('/unauthorized', 'un-authorized')->name('un_authorized_user');

// Localization
Route::get('/js/lang.js', function () {
    $lang = config('app.locale');

    $files   = glob(resource_path('lang/' . $lang . '/*.php'));
    $strings = [];

    foreach ($files as $file) {
        $name           = basename($file, '.php');
        $strings[$name] = require $file;
    }

    header('Content-Type: text/javascript');
    echo('window.i18n = ' . json_encode($strings) . ';');
    exit();
})->name('assets.lang');


Route::get('/logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index')->middleware('auth-user', 'validate-user-is-super-admin');
