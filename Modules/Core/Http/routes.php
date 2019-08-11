<?php
//Fix chrome back button as json type

header('Vary:X-Requested-With');

Route::group(['middleware' => 'web', 'prefix' => 'core', 'namespace' => 'Modules\Core\Http\Controllers'], function()
{

    // Apps Routes
    Route::get('/apps', 'AppsController@index');
    Route::post('/apps', 'AppsController@store');
    Route::put('/apps/{id}', 'AppsController@update');
    Route::delete('/apps/{id}', 'AppsController@destroy');
    Route::get('/authorized-apps', 'AuthorizedAppsController@index');
    Route::get('departments/main-types', 'DepartmentsController@mainTypes');

    // User Routes
    Route::get('/users', 'UsersController@index');
    Route::get('/users-search', 'UsersController@search');
    Route::get('/users/{id}/permissions', 'PermissionsController@index')->name('user_permissions');
    Route::match(['get', 'put'], '/users/{id}/superadmin', 'UsersController@makeSuperAdmin')->name('user_superadmin');
    Route::get('/users/{id}/employee_information', 'UsersController@employeeInformation')->name('user_employee_information');
    Route::get('/users/change/{email}', 'UsersController@change')->name('change');

    // Permissions Routes
    Route::post('/{permissionable}/{permissionableId}/permissions', 'PermissionsController@store');
    Route::put('/{permissionable}/{permissionableId}/permissions/{id}', 'PermissionsController@update');
    Route::delete('/permissions/{id}', 'PermissionsController@destroy');
    Route::get('/access-levels', 'AccessLevelsController@index');

    //Groups Routes
    Route::get('/groups/id-{groupId}', 'GroupsController@index');
    Route::resource('/groups', 'GroupsController');
    Route::get('/groups/{id}/permissions', 'PermissionsController@index')->name('group_permissions');
    Route::post('/groups/{id}/attach-user', 'GroupsController@attachUser')->name('attach_user_to_group');
    Route::delete('/groups/{id}/detach-user/{userId}', 'GroupsController@detachUser')->name('detach_user_to_group');
    Route::get('/groups/{id}/users', 'GroupsController@users')->name('group_users');

    //Dept Mapping
    Route::resource('/deptmapping', 'DeptmappingController');


    //Members Routes
    Route::get('/members', 'MembersController@index');
    Route::get('/members-search', 'MembersController@search');
    Route::get('/members/{id}/member_edit', 'MembersController@edit')->name('member_edit');


    //Buildings
    Route::post('/buildings/store', 'BuildingsController@store')->name('core.buildings.store');
    Route::get('/buildings','BuildingsController@index')->name('core.buildings');

    Route::post('/deilyPermission/store', 'DailyMovementPermission@store')->name('core.deilyPermission.store');
    Route::get('/deilyPermission/destroy/{id}', 'DailyMovementPermission@destroy')->name('core.deilyPermission.destroy');
    Route::get('/deilyPermission','DailyMovementPermission@index')->name('core.deilyPermission');
    Route::get('/deilyPermission/getEmployeeData/{user_mail}', 'DailyMovementPermission@getEmployeeData')->name('getEmployeeData');

});
