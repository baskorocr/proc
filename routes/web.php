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
    if(Auth::check())
    {
        return redirect('home');
    }
    return view('login_eproc.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth']], function () {

    // DELIVERY SCHEDULE ROUTES
    Route::prefix('delivery-schedule')->group(function(){
        Route::get('/mf', [App\Http\Controllers\DeliveryScheduleController::class, 'index'])->name('delivery.schedule.mf');
        Route::get('/spc', [App\Http\Controllers\DeliveryScheduleController::class, 'index_spo'])->name('delivery.schedule.spc');
        //Datatables
        Route::get('/mf/get-data',[App\Http\Controllers\DeliveryScheduleController::class, 'getDeliveryMf'])->name('api.schedule.delivery.datatables');
        Route::get('/spc/get-data',[App\Http\Controllers\DeliveryScheduleController::class, 'getDeliverySPC'])->name('api.schedule.delivery.spc.datatables');
    });

    // Monitoring Delivery Routes
    Route::prefix('monitoring-delivery')->group(function(){
        Route::get('/', [App\Http\Controllers\MonitoringDeliveryController::class, 'index'])->name('monitoring.delivery');
        Route::get('/detail/materials/{manifest}',[App\Http\Controllers\MonitoringDeliveryController::class, 'detail_material'])->name('monitoring.delivery.detail.material');
        Route::get('/detail/kanbans/{manifest}',[App\Http\Controllers\MonitoringDeliveryController::class, 'detail_kanban'])->name('monitoring.delivery.detail.kanban');
        //Datatables
        Route::get('/get-data',[App\Http\Controllers\MonitoringDeliveryController::class, 'getDelivery'])->name('api.monitoring.delivery.datatables');
        Route::get('/detail/material',[App\Http\Controllers\MonitoringDeliveryController::class, 'getMaterialDetail'])->name('api.monitoring.delivery.detail.datatables');
        Route::get('/detail/kanban',[App\Http\Controllers\MonitoringDeliveryController::class, 'getKanbanDetail'])->name('api.monitoring.delivery.detail.kanban.datatables');
    });

    // PROJECT MANAGEMENT Routes
    Route::prefix('project-management')->group(function(){
        Route::get('/project-master', [App\Http\Controllers\ProjectManagementController::class, 'projectMaster'])->name('project.management.master');
        Route::get('/product-master', [App\Http\Controllers\ProjectManagementController::class, 'index'])->name('project.management.master.product');
        Route::get('/part-master', [App\Http\Controllers\ProjectManagementController::class, 'index'])->name('project.management.master.part');

        Route::get('/project-master/edit/{id}', [App\Http\Controllers\ProjectManagementController::class, 'editProject'])->name('project.management.master.edit.project');
        Route::post('/project-master/update', [App\Http\Controllers\ProjectManagementController::class, 'updateProject'])->name('project.management.master.update.project');
        Route::get('/project-master/delete/{id}', [App\Http\Controllers\ProjectManagementController::class, 'deleteProject'])->name('project.management.master.delete.project');
        //Datatables
        Route::get('/datatables/get-project-master', [App\Http\Controllers\ProjectManagementController::class, 'getProjectMaster'])->name('datatables.project.management.master');
        // CRUD
       
         Route::post('/add-project', [App\Http\Controllers\ProjectManagementController::class, 'projectAdd'])->name('api.project.management.create.project');
      
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