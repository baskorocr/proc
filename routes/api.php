<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

//Route::group(['middleware' => ['auth:api']], function () {

    Route::get('/role', 'RoleController@index');
    Route::post('/role', 'RoleController@store');
    Route::get('/role/list', 'RoleController@list');
    Route::get('/role/{id}', 'RoleController@show');
    Route::post('/role/{id}', 'RoleController@update');
    Route::delete('/role/{id}', 'RoleController@destroy');

    Route::get('/permission', 'PermissionController@index');
    Route::post('/permission', 'PermissionController@store');
    Route::get('/permission/list-permission', 'PermissionController@get');
    Route::get('/permission/list', 'PermissionController@list');
    Route::get('/permission/list-parent', 'PermissionController@listParentId');
    Route::get('/permission/{id}', 'PermissionController@show');
    Route::post('/permission/{id}', 'PermissionController@update');
    Route::delete('/permission/{id}', 'PermissionController@destroy');
    
    Route::get('/settings', 'SettingsController@index');
    Route::post('/settings', 'SettingsController@store');
    Route::get('/settings/find', 'SettingsController@find');
    Route::get('/settings/{id}', 'SettingsController@show');
    Route::post('/settings/{id}', 'SettingsController@update');
    Route::delete('/settings/{id}', 'SettingsController@destroy');

    Route::get('/user', 'UserController@index');
    Route::post('/user', 'UserController@store');
    Route::get('/user/list', 'UserController@list');
    Route::get('/user/{id}', 'UserController@show');
    Route::post('/user/{id}', 'UserController@update');
    Route::delete('/user/{id}', 'UserController@destroy');

    Route::get('/vendor', 'VendorController@index');
    Route::post('/vendor', 'VendorController@store');
    Route::get('/vendor/list', 'VendorController@list');
    Route::get('/vendor/{id}', 'VendorController@show');
    Route::post('/vendor/{id}', 'VendorController@update');
    Route::delete('/vendor/{id}', 'VendorController@destroy');

    Route::get('/master-notify', 'MasterNotifyController@index');
    Route::post('/master-notify', 'MasterNotifyController@store');
    Route::get('/master-notify/list', 'MasterNotifyController@list');
    Route::get('/master-notify/{id}', 'MasterNotifyController@show');
    Route::post('/master-notify/{id}', 'MasterNotifyController@update');
    Route::delete('/master-notify/{id}', 'MasterNotifyController@destroy');

    Route::get('/regis-iso-doc', 'RegisIsoDocController@index');
    Route::post('/regis-iso-doc', 'RegisIsoDocController@store');
    Route::get('/regis-iso-doc/list', 'RegisIsoDocController@list');
    Route::get('/regis-iso-doc/{id}', 'RegisIsoDocController@show');
    Route::post('/regis-iso-doc/{id}', 'RegisIsoDocController@update');
    Route::delete('/regis-iso-doc/{id}', 'RegisIsoDocController@destroy');

    Route::get('/report-iso-doc', 'ReportIsoDocController@index');

    Route::get('/dashboard-iso-doc', 'DashboardIsoDocController@index');

    Route::get('/menu-list', 'MenuListController@index');
    Route::post('/menu-list', 'MenuListController@store');
    Route::get('/menu-list/list', 'MenuListController@list');
    Route::get('/menu-list/{id}', 'MenuListController@show');
    Route::post('/menu-list/{id}', 'MenuListController@update');
    Route::delete('/menu-list/{id}', 'MenuListController@destroy');

    Route::get('/menu-group', 'MenuGroupController@index');
    Route::post('/menu-group', 'MenuGroupController@store');
    Route::get('/menu-group/list', 'MenuGroupController@list');
    Route::get('/menu-group/{id}', 'MenuGroupController@show');
    Route::post('/menu-group/{id}', 'MenuGroupController@update');
    Route::delete('/menu-group/{id}', 'MenuGroupController@destroy');

    Route::get('/user-log', 'UserLogController@index');
    Route::post('/user-log', 'UserLogController@store');
    Route::get('/user-log/list', 'UserLogController@list');
    Route::get('/user-log/{id}', 'UserLogController@show');
    Route::post('/user-log/{id}', 'UserLogController@update');
    Route::delete('/user-log/{id}', 'UserLogController@destroy');

    Route::get('/user-pda-access', 'UserPdaAccessController@index');
    Route::post('/user-pda-access', 'UserPdaAccessController@store');
    Route::get('/user-pda-access/list', 'UserPdaAccessController@list');
    Route::get('/user-pda-access/{id}', 'UserPdaAccessController@show');
    Route::post('/user-pda-access/{id}', 'UserPdaAccessController@update');
    Route::delete('/user-pda-access/{id}', 'UserPdaAccessController@destroy');

    Route::get('/number-range', 'NumberRangeController@index');
    Route::post('/number-range', 'NumberRangeController@store');
    Route::get('/number-range/list', 'NumberRangeController@list');
    Route::get('/number-range/{id}', 'NumberRangeController@show');
    Route::post('/number-range/{id}', 'NumberRangeController@update');
    Route::delete('/number-range/{id}', 'NumberRangeController@destroy');

//});

Route::post('/login', 'AuthController@login');
