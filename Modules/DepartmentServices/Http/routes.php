<?php

Route::group(['middleware' => 'web', 'prefix' => 'department-services', 'namespace' => 'Modules\DepartmentServices\Http\Controllers'], function()
{
    // Attendance routes
    Route::group(['middleware' => 'web', 'prefix' => 'attendance', 'namespace' => 'Attendance'], function()
    {
        Route::post('salary-discount-requests/{id}/approve', 'SalaryDiscountRequestsController@approve')->name('salary-discount-requests.approve');
        Route::post('salary-discount-requests/{id}/close', 'SalaryDiscountRequestsController@close')->name('salary-discount-requests.close');
        Route::resource('salary-discount-requests', 'SalaryDiscountRequestsController');
        Route::any('/depts', 'SalaryDiscountRequestsController@depts');

        Route::post('vacations/{id}/confirm', 'VacationsController@confirm')->name('confirm-vacation');
        Route::post('vacations/faculty-members/{id}/confirm', 'VacationsController@facultyMembersConfirm')->name('confirm-faculty-members-vacation');
        Route::post('vacations/hr/{id}/confirm', 'VacationsController@hrConfirm')->name('confirm-hr-vacation');
        Route::post('vacations/relations-employees/{id}/confirm', 'VacationsController@relationsEmployeesConfirm')->name('confirm-relations-employees-vacation');
        Route::post('vacations/{id}/check', 'VacationsController@check')->name('check-vacation');


        Route::name('department-services.')->group(function () {
            Route::get('vacations/faculty-members', 'VacationsController@facultyMembers')->name('vacations-faculty-members');
            Route::get('vacations/hr', 'VacationsController@hr')->name('vacations-hr');
            Route::get('vacations/relations-employees', 'VacationsController@relationsEmployees')->name('vacations-relations-employees');
            Route::resource('vacations', 'VacationsController', ['only' => ['index', 'show']]);

            Route::get('/tasks', 'TasksController@index')->name('department-services.attendance.tasks.index');
            Route::put('/tasks/{task_id}/update', 'TasksController@updateTask')->name('department-services.attendance.tasks.update-task');
        });

        Route::name('department-services.')->group(function () {
            Route::resource('request-absence-from-vacations', 'RequestAbsenceFromVacationsController', ['only' => ['index', 'update']]);
        });

        // Permissions routes
        Route::group(['middleware' => 'web', 'as' => 'permissions.', 'prefix' => 'permissions'], function()
        {
            Route::get('/', 'PermissionsRequestsController@index')->name('index');
            Route::post('/approve/{permission_id}', 'PermissionsRequestsController@approve')->where('permission_id', '[0-9]+')->name('approve');
            Route::post('/reject', 'PermissionsRequestsController@reject')->name('reject');

            // المتابعة routes
            Route::group(['middleware' => 'web', 'as' => 'administrator.', 'prefix' => 'administrator'], function()
            {
                Route::get('/all-permissions', 'PermissionsRequestsController@administratorDisplayAllPermissions')->name('display-all-permissions');
                Route::post('/delete', 'PermissionsRequestsController@administratorDeletePermission')->name('delete');
                Route::get('/edit/{id}', 'PermissionsRequestsController@administratorEditPermission')->name('edit');
                Route::put('/update/{id}', 'PermissionsRequestsController@administratorUpdatePermission')->name('update');
                Route::get('/add', 'PermissionsRequestsController@administratorAddPermission')->name('add');
                Route::post('/store', 'PermissionsRequestsController@administratorStorePermission')->name('store');
                Route::post('/employee-info', 'PermissionsRequestsController@administratorEmployeeInfo')->name('employee-info');
                Route::post('/validate-prmission-date', 'PermissionsRequestsController@administratorValidatePrmissionDate')->name('validate-prmission-date');
            });
        });

        Route::name('department-services.')->group(function () {
            Route::resource('employees', 'EmployeesAttendanceController', ['only' => ['index']]);
        });

    });

    Route::name('department-services.')->group(function () {
        Route::get('housing-allowance-requests/all', 'HousingAllowanceRequestsController@all')->name('housing-allowance-all-requests');
        Route::get('housing-allowance-requests/all-show', 'HousingAllowanceRequestsController@allShow')->name('housing-allowance-all-show-requests');
        Route::post('housing-allowance-requests/{id}/confirm', 'HousingAllowanceRequestsController@confirm')->name('confirm-housing-allowance-request');
        Route::post('housing-allowance-requests/{id}/check', 'HousingAllowanceRequestsController@check')->name('check-housing-allowance-request');
        Route::post('housing-allowance-requests/{id}/step4', 'HousingAllowanceRequestsController@step4')->name('step4-housing-allowance-request');
        Route::post('housing-allowance-requests/{id}/step5', 'HousingAllowanceRequestsController@step5')->name('step5-housing-allowance-request');
        Route::post('housing-allowance-requests/{id}/step6', 'HousingAllowanceRequestsController@step6')->name('step6-housing-allowance-request');
        Route::post('housing-allowance-requests/{id}/step7', 'HousingAllowanceRequestsController@step7')->name('step7-housing-allowance-request');
        Route::post('housing-allowance-requests/{id}/archive', 'HousingAllowanceRequestsController@archive')->name('archive-housing-allowance-request');
        Route::resource('housing-allowance-requests', 'HousingAllowanceRequestsController');
        Route::post('housing-allowance-requests/{id}/step-back', 'HousingAllowanceRequestsController@stepBack')->name('step-housing-allowance-request-back');

        // hr start work 
        Route::post('hr-start-work-requests-requests/{id}/check', 'HrStartWorkRequestsController@check')->name('check-hr-start-work-requests');

        Route::resource('hr-start-work-requests', 'HrStartWorkRequestsController');
        
    });


    // // Travel Allowance
    Route::get('/travelAllowance/approval/{id}', 'TravelAllowanceController@approval')->name('department-services.travelAllowance.approval');
    Route::get('/travelAllowance/not-approval/{id}', 'TravelAllowanceController@notApproval')->name('department-services.travelAllowance.notApproval');
    Route::get('/travelAllowance/show/{id}', 'TravelAllowanceController@show')->name('myservices.travelAllowance.show');
    Route::get('/travelAllowance', 'TravelAllowanceController@index')->name('department-services.travelAllowance');

    // prmuevents
    Route::get('/prmuevents/cancellation/{id}', 'PrmuEventsController@cancellation')->name('PrmuEvents.cancellation');
    Route::get('/prmuevents/approvalAgent/{id}', 'PrmuEventsController@approvalAgent')->name('PrmuEvents.approvalAgent');
    Route::get('/prmuevents/refusalAgent/{id}', 'PrmuEventsController@refusalAgent')->name('PrmuEvents.refusalAgent');
    Route::get('/prmuevents/approvalRector/{id}', 'PrmuEventsController@approvalRector')->name('PrmuEvents.approvalRector');
    Route::get('/prmuevents/refusalRector/{id}', 'PrmuEventsController@refusalRector')->name('PrmuEvents.refusalRector');
    Route::get('/prmuevents/reCheck/{id}', 'PrmuEventsController@reCheck')->name('PrmuEvents.reCheck');
    Route::get('/prmuevents/gotoRector/{id}', 'PrmuEventsController@gotoRector')->name('PrmuEvents.gotoRector');
    Route::get('/prmuevents/changeTime/{id}', 'PrmuEventsController@changeTime')->name('PrmuEvents.changeTime');
    Route::get('/prmuevents/override/{id}', 'PrmuEventsController@override')->name('PrmuEvents.override');
    Route::get('/prmuevents/re/{id}', 'PrmuEventsController@re')->name('PrmuEvents.re');
    Route::get('/prmuevents/inform/{id}', 'PrmuEventsController@inform')->name('PrmuEvents.inform');
    Route::get('/prmuevents/approvalfrommanagerdept/{id}', 'PrmuEventsController@approvalFromManagerDept')->name('PrmuEvents.approvalfrommanagerdept');
    Route::get('/prmuevents', 'PrmuEventsController@index')->name('department-services.PrmuEvents');

    Route::get('/updateResearch', 'UpdateResearch@index')->name('department-services.updateResearch');
    Route::post('updateResearch/{user_id}/check', 'UpdateResearch@check')->name('check-updateResearch');


    // Authorization Controller
    Route::get('/authorization/search', 'AuthorizationController@employeesSearch')->name('authorization.search');
    Route::get('/authorization/{id}/remove', 'AuthorizationController@removeAuthorization')->name('authorization.remove');
    Route::resource('authorization', 'AuthorizationController', ['only' => ['index', 'create', 'store', 'show']]);

    Route::name('department-services.')->group(function () {
        Route::get('/airport-transfer/uploads/{orderID}/{passportSlug}', 'AirportTransferController@showPassport')->name('airport-transfer.show-passport');
        Route::resource('/airport-transfer', 'AirportTransferController');
    });
});


Route::group(['middleware' => 'api', 'prefix' => 'api/department-services', 'namespace' => 'Modules\DepartmentServices\Http\Controllers'], function()
{
    Route::name('api.')->group(function () {


        // Attendance routes
        Route::group(['middleware' => 'api', 'prefix' => 'attendance', 'namespace' => 'Attendance'], function()
        {

            Route::post('salary-discount-requests/{id}/approve', 'SalaryDiscountRequestsController@approve')->name('salary-discount-requests.approve');
            Route::post('salary-discount-requests/{id}/close', 'SalaryDiscountRequestsController@close')->name('salary-discount-requests.close');
            Route::resource('salary-discount-requests', 'SalaryDiscountRequestsController');

            // Permissions routes
            Route::group(['as' => 'permissions.', 'prefix' => 'permissions'], function()
            {
                Route::get('/', 'PermissionsRequestsController@index')->name('index');
                Route::get('/approve/{permission_id}', 'PermissionsRequestsController@approve')->where('permission_id', '[0-9]+')->name('approve');
                Route::get('/reject', 'PermissionsRequestsController@reject')->name('reject');
                Route::get('/total', 'PermissionsRequestsController@total')->name('total');
                Route::post('/check', 'PermissionsRequestsController@check')->name('check');
            });

            Route::name('api-department-services.')->group(function () {
                Route::resource('vacations', 'VacationsController', ['only' => ['index', 'show']]);

                Route::get('/tasks', 'TasksController@index')->name('department-services.attendance.tasks.index');
                Route::put('/tasks/{task_id}/update', 'TasksController@updateTask')->name('department-services.attendance.tasks.update-task');
                
                Route::resource('request-absence-from-vacations', 'RequestAbsenceFromVacationsController', ['only' => ['index', 'update']]);
            });

            Route::post('vacations/{id}/confirm', 'VacationsController@confirm')->name('api-confirm-vacation');
            Route::post('vacations/{id}/check', 'VacationsController@check')->name('api-check-vacation');

        });


    });
});
