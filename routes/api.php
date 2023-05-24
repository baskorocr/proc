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

Route::get('check', 'UserController@check');
Route::get('check-pin', 'UserController@checkPin');
Route::get('/outstanding', 'ManifestController@outstanding');
Route::get('manifest', 'ManifestController@manifestHeader');
Route::get('manifest/{manifest}', 'ManifestController@manifestDetail');
Route::get('check-kanban', 'ManifestController@checkKanban');
Route::post('/send-manifest', 'ManifestController@sendManifest');
Route::post('/manifest/close', 'ManifestController@closeManifest');
Route::post('/vendor', 'VendorController@store');
Route::post('/vendor/{id_vendor}', 'VendorController@update');
Route::post('/send-po', 'PoController@sendPo');
Route::post('/resend-email-po', 'PoController@resendEmailPo');

Route::group(['middleware' => ['auth:api']], function () {

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
    //Route::post('/vendor', 'VendorController@store');
    Route::get('/vendor/list', 'VendorController@list');
    Route::get('/vendor/{id}', 'VendorController@show');
    //Route::post('/vendor/{id}', 'VendorController@update');
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

});

Route::post('/login', 'AuthController@login');
