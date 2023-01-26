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
        Route::get('/project-master/project-assigment', [App\Http\Controllers\ProjectManagementController::class, 'projectAssignMaster'])->name('project.management.assign.master');
        Route::get('/project-master/edit/{id}', [App\Http\Controllers\ProjectManagementController::class, 'editProject'])->name('project.management.master.edit.project');
        Route::post('/project-master/update', [App\Http\Controllers\ProjectManagementController::class, 'updateProject'])->name('project.management.master.update.project');
        Route::get('/project-master/delete/{id}', [App\Http\Controllers\ProjectManagementController::class, 'deleteProject'])->name('project.management.master.delete.project');
        
        //Product Master
        Route::post('/product-master/update', [App\Http\Controllers\ProjectManagementController::class, 'updateProduct'])->name('project.management.master.update.product');
        Route::get('/product-master', [App\Http\Controllers\ProjectManagementController::class, 'productMaster'])->name('project.management.master.product');
        Route::get('/product-master/edit/{id}', [App\Http\Controllers\ProjectManagementController::class, 'editProduct'])->name('project.management.master.edit.product');
        Route::get('/product-master/delete/{id}', [App\Http\Controllers\ProjectManagementController::class, 'deleteProduct'])->name('project.management.master.delete.product');
         Route::get('/project-master/product-assigment', [App\Http\Controllers\ProjectManagementController::class, 'productAssignMaster'])->name('project.management.assign.master.product');
        //Part Master
        Route::get('/part-master', [App\Http\Controllers\ProjectManagementController::class, 'partMaster'])->name('project.management.master.part');
        Route::get('/part-master/edit/{id}', [App\Http\Controllers\ProjectManagementController::class, 'editPart'])->name('project.management.master.edit.part');
        Route::post('/part-master/update', [App\Http\Controllers\ProjectManagementController::class, 'updatePart'])->name('project.management.master.update.part');
        Route::get('/part-master/delete/{id}', [App\Http\Controllers\ProjectManagementController::class, 'deletePart'])->name('project.management.master.delete.part');
        Route::get('/part-master/part-assigment', [App\Http\Controllers\ProjectManagementController::class, 'partAssignMaster'])->name('project.management.assign.master.part');
        //
        // List Check Master
        Route::get('/list-check-master', [App\Http\Controllers\ProjectManagementController::class, 'DocCheckListMaster'])->name('project.management.master.listcheck');
        Route::get('/modify-document-check-list', [App\Http\Controllers\ProjectManagementController::class, 'DocCheckListModify'])->name('project.management.master.listcheck.modify.doc');

        //Datatables
        Route::get('/datatables/get-project-master', [App\Http\Controllers\ProjectManagementController::class, 'getProjectMaster'])->name('datatables.project.management.master');
        Route::get('/datatables/get-checklist-master', [App\Http\Controllers\ProjectManagementController::class, 'getMasterCheckList'])->name('datatables.project.management.checklist.master');
        Route::get('/datatables/get-project-assign', [App\Http\Controllers\ProjectManagementController::class, 'getProjectAssignMaster'])->name('datatables.project.management.assign.master');
        Route::get('/datatables/get-product-assign', [App\Http\Controllers\ProjectManagementController::class, 'getProductAssignMaster'])->name('datatables.project.management.assign.product.master');
        Route::get('/datatables/get-product-master', [App\Http\Controllers\ProjectManagementController::class, 'getProductMaster'])->name('datatables.project.management.product.master');
        Route::get('/datatables/get-part-master', [App\Http\Controllers\ProjectManagementController::class, 'getPartMaster'])->name('datatables.project.management.part.master');
        Route::get('/datatables/get-part-assign', [App\Http\Controllers\ProjectManagementController::class, 'getPartAssign'])->name('datatables.project.management.assign.part.master');
        // CRUD
       
         Route::post('/add-project', [App\Http\Controllers\ProjectManagementController::class, 'projectAdd'])->name('api.project.management.create.project');
         Route::post('/add-part', [App\Http\Controllers\ProjectManagementController::class, 'partAdd'])->name('api.project.management.create.part');
         Route::post('/add-product', [App\Http\Controllers\ProjectManagementController::class, 'productAdd'])->name('api.project.management.create.product');
         Route::post('/assign-project', [App\Http\Controllers\ProjectManagementController::class, 'projectAssign'])->name('api.project.management.assign.project');
         Route::post('/assign-part', [App\Http\Controllers\ProjectManagementController::class, 'partAssign'])->name('api.project.management.assign.part');
         Route::post('/assign-product', [App\Http\Controllers\ProjectManagementController::class, 'productAssign'])->name('api.project.management.assign.product');
      
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