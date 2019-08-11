<?php

Route::group(['middleware' => 'web', 'prefix' => 'transport', 'namespace' => 'Modules\Transport\Http\Controllers'], function()
{
    Route::get('/control', 'ControlController@index')->name('trans');
    Route::any('/control/store', 'ControlController@store')->name('trans.store');
    Route::get('/control/city', 'ControlController@CityIndex')->name('trans.city');
    Route::any('/control/create-city', 'ControlController@createCity')->name('trans.createCity');
    Route::any('/control/create-district', 'ControlController@createDistrict')->name('trans.createDistrict');
    Route::any('/control/create-track', 'ControlController@createTrack')->name('trans.createTrack');
    Route::any('/control/create-driver', 'ControlController@createDriver')->name('trans.createDriver');
    Route::get('control/get_districts','ControlController@getDistrictsOfCity')->name('trans.getDistrictsOfCity');
    Route::get('control/get_colleges','ControlController@getColleges')->name('trans.getColleges');
    Route::get('control/get_cities','ControlController@getCities')->name('trans.getCities');
    Route::get('control/get_tracks','ControlController@getTracks')->name('trans.getTracks');
    Route::get('control/get_vehicles','ControlController@getVehicles')->name('trans.getVehicles');

    Route::any('/control/edit', 'ControlController@edit')->name('trans.edit');

    Route::get('/phenomens', 'PhenomenonsController@index');



    Route::any('/phenomenons/create', 'PhenomenonsController@create')->name('phenomenons_create');
    Route::any('/phenomenons/store', 'PhenomenonsController@store')->name('phenomenons_store');


    Route::get('/home', 'HomeController@index');



    Route::resource('daily-reports', 'DailyReportsController');
    Route::get('/daily-reports', 'DailyReportsController@index')->name('trans.daily-reports.index');
    Route::get('/daily-reports/create', 'DailyReportsController@create')->name('trans.daily-reports.create');
    Route::post('/daily-reports', 'DailyReportsController@store')->name('trans.daily-reports.store');
    Route::get('/daily-reports/{id}', 'DailyReportsController@show')->name('trans.daily-reports.show');
    Route::get('/daily-reports/{id}/edit', 'DailyReportsController@edit')->name('trans.daily-reports.edit');
    Route::put('/daily-reports/{id}', 'DailyReportsController@update')->name('trans.daily-reports.update');

    Route::get('/follow-daily-reports', 'DailyReportsController@follow')->name('trans.daily-reports.follow');
    Route::get('/daily-reports/{id}/guide', 'DailyReportsController@guide')->name('trans.daily-reports.guide');
    Route::put('/daily-reports/{id}/guidance', 'DailyReportsController@guidance')->name('trans.daily-reports.guidance');



    // ahmed edit

    Route::resource('control/city', 'CityController');
    Route::resource('control/district', 'DistrictController');
    Route::resource('control/track', 'TrackController');
    Route::resource('control/vehicle', 'VehicleController');
    Route::resource('control/driver', 'DriverController');
    Route::resource('excuess', 'ExcuessController');
    Route::resource('dailymovement', 'DailyMovementController');
    Route::resource('activities', 'ActivityController');
    Route::resource('notes', 'StudentNotesController');



    Route::get('control/get_cities','CityController@getCities')->name('trans.getCities');
    Route::get('control/get_districts','DistrictController@getDistricts')->name('trans.getDistricts');
    Route::get('control/get_tracks','TrackController@getTracks')->name('trans.getTracks');
    Route::get('control/get_colleges','TrackController@getColleges')->name('trans.getColleges');
    Route::get('control/get_districts_of_city/{id}','TrackController@getDistrictsOfCity')->name('trans.getDistrictsOfCity');
    Route::get('control/get_vehicles','VehicleController@getVehicles')->name('trans.getVehicles');
    Route::get('control/get_drivers','DriverController@getDrivers')->name('trans.getDrivers');
    Route::get('get_activties/','ActivityController@getActivties')->name('trans.getActivties');
    Route::get('activities/get_activity_students/{id}','ActivityController@getActivityStudents')->name('trans.getActivityStudents');
    Route::post('activities/{id}/approvement','ActivityController@aproveActivity')->name('trans.aproveActivity');
    Route::get('get_notes/','StudentNotesController@getNotes')->name('trans.getNotes');
    Route::post('control/driver/upload_driver_files/{driver_id}','DriverController@uploadDriverFiles')->name('trans.uploadDriverFiles');
    Route::get('control/control-gate','ControlController@controlGate')->name('trans.controlGate');
    Route::get('control/add-registration-period','ControlController@addRegistrationPeriod')->name('trans.add-registration-period');
    Route::post('control/save-registration-period','ControlController@saveRegistrationPeriod')->name('trans.save-registration-period');
    
    
    Route::get('/reports/supervision/create','DailyReportsController@supervision')->name('trans.supervision');

    Route::post('/reports/supervision/store','DailyReportsController@storeSupervisionReport')->name('trans.storeSupervisionReport');
    Route::get('/reports/supervision','DailyReportsController@supervisionIndex')->name('trans.supervisionIndex');
    Route::get('/reports/supervision/evaluate/{id}','DailyReportsController@supervisionEvaluateShow')->name('trans.supervision-reports.evaluate');
    Route::post('/reports/supervision/evaluate/{id}/store','DailyReportsController@supervisionEvaluateStore')->name('trans.supervisionEvaluateStore');

    Route::get('/home/students/filters','HomeController@studentFilters')->name('trans.studentFilters');
    Route::get('/home/get_driver_report/{track}/{date}/{id}','HomeController@getDriverReport')->name('trans.getDriverReport');
    Route::post('/home/filters','HomeController@homeFilters')->name('trans.homeFilters');
    Route::get('/home/get_students_driver/{track}/{id}','HomeController@getStudentsDriver')->name('trans.getStudentsDriver');
    Route::post('/home/students_attendace/store','HomeController@studentAttendaceStore')->name('trans.studentAttendaceStore');
    Route::get('/home/get_attendace_students_report/{track}/{date}/{id}','HomeController@getAttendaceStudentsReport')->name('trans.getAttendaceStudentsReport');
    Route::post('/home/daily_movement/store','HomeController@dailyMovementStore')->name('trans.dailyMovementStore');
    Route::get('/home/get_daily_movement_report/{type}/{date}/{id}','HomeController@getDailyMovementReport')->name('trans.getDailyMovementReport');
    Route::get('/home/get_excueses/{track}/{date}/{id}','HomeController@getExcuess')->name('trans.getExcuess');
    Route::post('/home/message/send','HomeController@sendMessage')->name('trans.sendMessage');
    Route::get('/home/get_messages/{track}/{date}/{id}','HomeController@getMessages')->name('trans.getMessages');
    Route::get('/get_excueses','ExcuessController@getAllExcuess')->name('trans.getAllExcuess');
    Route::get('/get_allDailyMovment','DailyMovementController@getAllDailyMovment')->name('trans.getAllDailyMovment');
    Route::get('/get_daily_movment_college/{id}/{date}/{type}','DailyMovementController@getAllDailyMovmentCollegeReport')->name('trans.getAllDailyMovmentCollegeReport');
    Route::post('daily_movment/guidence/store','DailyMovementController@storeGuidence')->name('trans.storeGuidence');
    Route::post('notes/{id}/reply/store','StudentNotesController@storeNoteReply')->name('trans.storeNoteReply');

});
if ( \Request::is('vue/*') )
{
    Route::group(['middleware' => 'web', 'prefix' => 'vue', 'namespace' => 'Modules\Transport\Http\Controllers'], function()
    {
        Route::get('{vue?}', 'HomeController@index')->where('vue', '[\/\w\.-]*');
    });
}

