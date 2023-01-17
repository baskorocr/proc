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
Route::get('/delivery-schedule/mf', [App\Http\Controllers\DeliveryScheduleController::class, 'index'])->name('delivery.schedule.mf');
Route::get('/delivery-schedule/mf/create', [App\Http\Controllers\DeliveryScheduleController::class, 'create'])->name('delivery.schedule.mf.create');
Route::post('/delivery-schedule/mf/update', [App\Http\Controllers\DeliveryScheduleController::class, 'update'])->name('delivery.schedule.mf.update');
Route::post('/delivery-schedule/mf/delete', [App\Http\Controllers\DeliveryScheduleController::class, 'delete'])->name('delivery.schedule.mf.delete');
Route::post('/delivery-schedule/mf/save', [App\Http\Controllers\DeliveryScheduleController::class, 'save'])->name('delivery.schedule.mf.save');
Route::get('/delivery-schedule/mf/edit/{id}', [App\Http\Controllers\DeliveryScheduleController::class, 'edit'])->name('delivery.schedule.mf.edit');// DELIVERY SCHEDULE SPC
Route::get('/delivery-schedule/spc', [App\Http\Controllers\DeliveryScheduleSPCController::class, 'index'])->name('delivery.schedule.spc');
Route::get('/delivery-schedule/spc/create', [App\Http\Controllers\DeliveryScheduleSPCController::class, 'create'])->name('delivery.schedule.spc.create');
Route::post('/delivery-schedule/spc/update', [App\Http\Controllers\DeliveryScheduleSPCController::class, 'update'])->name('delivery.schedule.spc.update');
Route::post('/delivery-schedule/spc/delete', [App\Http\Controllers\DeliveryScheduleSPCController::class, 'delete'])->name('delivery.schedule.spc.delete');
Route::post('/delivery-schedule/spc/save', [App\Http\Controllers\DeliveryScheduleSPCController::class, 'save'])->name('delivery.schedule.spc.save');
Route::get('/delivery-schedule/spc/edit/{id}', [App\Http\Controllers\DeliveryScheduleSPCController::class, 'edit'])->name('delivery.schedule.spc.edit');

Route::group(['middleware' => ['auth:api']], function () {
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