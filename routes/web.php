<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
   // return view('welcome');
    return view('eproc.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// DELIVERY SCHEDULE MF
Route::group(['middleware' => ['auth']], function () {

    Route::prefix('delivery-schedule')->group(function(){
        Route::get('/mf', [App\Http\Controllers\DeliveryScheduleController::class, 'index'])->name('delivery.schedule.mf');
        Route::get('/spc', [App\Http\Controllers\DeliveryScheduleController::class, 'index_spo'])->name('delivery.schedule.spc');
        Route::get('/mf/get-data',[App\Http\Controllers\DeliveryScheduleController::class, 'getDeliveryMf'])->name('api.schedule.delivery.datatables');
        Route::get('/spc/get-data',[App\Http\Controllers\DeliveryScheduleController::class, 'getDeliverySPC'])->name('api.schedule.delivery.spc.datatables');
    });

    Route::prefix('monitoring-delivery')->group(function(){
        Route::get('/', [App\Http\Controllers\MonitoringDeliveryController::class, 'index'])->name('monitoring.delivery');
        Route::get('/get-data',[App\Http\Controllers\MonitoringDeliveryController::class, 'getDelivery'])->name('api.monitoring.delivery.datatables');
    });


});
Route::get('/blank', function () {
   return view('example/blank');
});


Route::prefix('component')->group(function () {
    Route::get('/forminput', function () {
         return view('example.form');
    });
    Route::get('/datatable', function () {
        return view('example.table');
   });
});