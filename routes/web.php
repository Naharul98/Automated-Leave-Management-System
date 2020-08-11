<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group.
|
*/
//home area routes
Route::get('/', 'Home_Area\HomePageController@index');
Route::get('/home', 'Home_Area\HomePageController@index');


//authentication routes
Auth::routes();
//edit employee routes
Route::get('/staff_area/admin', 'Staff_Area\ChangeAdminController@adminBrowse');
Route::post('/staff_area/admin', 'Staff_Area\ChangeAdminController@adminBrowse');

Route::get('/staff_area/admin/update/{admin_id}', 'Staff_Area\ChangeAdminController@update');
Route::post('/staff_area/admin/update/{admin_id}', 'Staff_Area\ChangeAdminController@update');

Route::get('/staff_area/admin/delete/{admin_id}', 'Staff_Area\ChangeAdminController@delete');
Route::post('/staff_area/admin/delete/{admin_id}', 'Staff_Area\ChangeAdminController@delete');

//manager area holiday request route
Route::get('/staff_area/admin/approved_requests', 'Staff_Area\HolidayRequestController@showApprovedRequests');
Route::get('/staff_area/admin/rejected_requests', 'Staff_Area\HolidayRequestController@showRejectedRequests');

Route::get('/staff_area/admin/filter_by_month', 'Staff_Area\HolidayRequestController@filterByMonth');
Route::post('/staff_area/admin/filter_by_month', 'Staff_Area\HolidayRequestController@filterByMonth');


//user area routes
Route::get('/user_area/index', 'User_Area\DashboardController@index');
Route::get('/user_area/view_request/{request_id}', 'User_Area\DashboardController@showRequest');
Route::get('/user_area/remmove_rejected_request/{request_id}', 'User_Area\DashboardController@removeRejectedRequest');

Route::get('/user_area/request_new_holiday/', 'User_Area\RequestHolidayController@index');
Route::post('/user_area/request_new_holiday/', 'User_Area\RequestHolidayController@makeRequest');


Route::post('/user_area/request_holiday_from_alternative/', 'User_Area\RequestHolidayController@requestHolidayFromAlternative');


Route::get('/user_area/change_password/', 'User_Area\DashboardController@changePassword');
Route::post('/user_area/change_password/', 'User_Area\DashboardController@changePassword');





