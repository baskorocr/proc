<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;


Route::get('/', function () {
    if(Auth::check())
    {
        return redirect('blank');
    }
    return view('eproc.login');
})->name('login');

Route::get('/logout',[AuthController::class,'logout'])->name('logout');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('doc-iso')->group(function(){

    //Master Notify
    Route::get('/master-notify', [App\Http\Controllers\MasterNotifyController::class, 'getMasterNotify'])->name('doc-iso.master-notify');
    Route::post('/add-notify', [App\Http\Controllers\MasterNotifyController::class, 'notifyAdd'])->name('api.doc-iso.create.notify');
   
    Route::post('/master-notify/update', [App\Http\Controllers\MasterNotifyController::class, 'updateNotify'])->name('doc-iso.master-notify.update.notify');
    Route::get('/master-notify/edit/{id}', [App\Http\Controllers\MasterNotifyController::class, 'editNotify'])->name('doc-iso.master-notify.edit.notify');
    Route::get('/master-notify/delete/{id}', [App\Http\Controllers\MasterNotifyController::class, 'deleteNotify'])->name('doc-iso.master-notify.delete.notify');
    //Datatables
    Route::get('/datatables/get-master-notify', [App\Http\Controllers\MasterNotifyController::class, 'getDataMasterNotify'])->name('datatables.doc-iso.master.notify');

    //ISO DOC Register
    Route::get('/register-iso', [App\Http\Controllers\RegisIsoDocController::class, 'index'])->name('doc-iso.register-iso');
    Route::post('/register-iso', [App\Http\Controllers\RegisIsoDocController::class, 'store'])->name('doc-iso.register-iso.store');
   
    Route::get('/master-notify/report-iso', function () {
        return view('doc_iso.master-notify.report-iso');
     });
  
     Route::get('/dashboard-iso', [App\Http\Controllers\DashboardIsoDocController::class, 'index'])->name('doc-iso.dashboard-iso');
     Route::get('/report-iso', [App\Http\Controllers\ReportIsoDocController::class, 'index'])->name('doc-iso.report-iso');
     
});

Route::prefix('regis-user')->group(function(){

    //Menu List
    Route::get('/menu-list', [App\Http\Controllers\MenuListController::class, 'getMenuList'])->name('regis-user.menu-list');
    Route::post('/add-list', [App\Http\Controllers\MenuListController::class, 'listAdd'])->name('api.regis-user.create.list');
   
    Route::post('/menu-list/update', [App\Http\Controllers\MenuListController::class, 'updateList'])->name('regis-user.menu-list.update.list');
    Route::get('/menu-list/edit/{id}', [App\Http\Controllers\MenuListController::class, 'editList'])->name('regis-user.menu-list.edit.list');
    Route::get('/menu-list/delete/{id}', [App\Http\Controllers\MenuListController::class, 'deleteList'])->name('regis-user.menu-list.delete.list');
    //Datatables
    Route::get('/datatables/get-menu-list', [App\Http\Controllers\MenuListController::class, 'getDataMenuList'])->name('datatables.regis-user.menu.list');
     
    //Menu Group
    Route::get('/menu-group', [App\Http\Controllers\MenuGroupController::class, 'getMenuGroup'])->name('regis-user.menu-group');
    Route::post('/add-group', [App\Http\Controllers\MenuGroupController::class, 'groupAdd'])->name('api.regis-user.create.group');
   
    Route::post('/menu-group/update', [App\Http\Controllers\MenuGroupController::class, 'updateGroup'])->name('regis-user.menu-group.update.group');
    Route::get('/menu-group/edit/{id}', [App\Http\Controllers\MenuGroupController::class, 'editGroup'])->name('regis-user.menu-group.edit.group');
    Route::get('/menu-group/delete/{id}', [App\Http\Controllers\MenuGroupController::class, 'deleteGroup'])->name('regis-user.menu-group.delete.group');
    //Datatables
    Route::get('/datatables/get-menu-group', [App\Http\Controllers\MenuGroupController::class, 'getDataMenuGroup'])->name('datatables.regis-user.menu.group');
      
    //Access Group
    Route::get('/access-group', [App\Http\Controllers\AccessGroupController::class, 'getAccessGroup'])->name('regis-user.access-group');
    Route::post('/add-group', [App\Http\Controllers\AccessGroupController::class, 'accessAdd'])->name('api.regis-user.create.group');
   
    Route::post('/access-group/update', [App\Http\Controllers\AccessGroupController::class, 'updateAccess'])->name('regis-user.access-group.update.access');
    Route::get('/access-group/edit/{id}', [App\Http\Controllers\AccessGroupController::class, 'editAccess'])->name('regis-user.access-group.edit.access');
    Route::get('/access-group/delete/{id}', [App\Http\Controllers\AccessGroupController::class, 'deleteAccess'])->name('regis-user.access-group.delete.access');
    //Datatables
    Route::get('/datatables/get-access-group', [App\Http\Controllers\AccessGroupController::class, 'getDataAccessGroup'])->name('datatables.regis-user.access.group');

    //Email Group
    Route::get('/email-group', [App\Http\Controllers\EmailGroupController::class, 'getEmailGroup'])->name('regis-user.email-group');
    Route::post('/add-group', [App\Http\Controllers\EmailGroupController::class, 'emailAdd'])->name('api.regis-user.create.email');
   
    Route::post('/email-group/update', [App\Http\Controllers\EmailGroupController::class, 'updateEmail'])->name('regis-user.email-group.update.email');
    Route::get('/email-group/edit/{id}', [App\Http\Controllers\EmailGroupController::class, 'editEmail'])->name('regis-user.email-group.edit.email');
    Route::get('/email-group/delete/{id}', [App\Http\Controllers\EmailGroupController::class, 'deleteEmail'])->name('regis-user.email-group.delete.email');
    //Datatables
    Route::get('/datatables/get-email-group', [App\Http\Controllers\EmailGroupController::class, 'getDataEmailGroup'])->name('datatables.regis-user.email.group');


    //Email List Group
    Route::get('/email-list-group', [App\Http\Controllers\EmailListGroupController::class, 'getEmailListGroup'])->name('regis-user.email-listemail');
    Route::post('/add-list-group', [App\Http\Controllers\EmailListGroupController::class, 'listemailAdd'])->name('api.regis-user.create.listemail');
   
    Route::post('/email-list-group/update', [App\Http\Controllers\EmailListGroupController::class, 'updateListEmail'])->name('regis-user.email-list-group.update.listemail');
    Route::get('/email-list-group/edit/{id}', [App\Http\Controllers\EmailListGroupController::class, 'editListEmail'])->name('regis-user.email-list-group.edit.listemail');
    Route::get('/email-list-group/delete/{id}', [App\Http\Controllers\EmailListGroupController::class, 'deleteListEmail'])->name('regis-user.email-list-group.delete.listemail');
    //Datatables
    Route::get('/datatables/get-email-list-group', [App\Http\Controllers\EmailListGroupController::class, 'getDataEmailListGroup'])->name('datatables.regis-user.email.list-group');

     //Master User
    Route::get('/master-user', [App\Http\Controllers\MasterUserController::class, 'getMasterUser'])->name('regis-user.master-user');
    Route::post('/add-user', [App\Http\Controllers\MasterUserController::class, 'userAdd'])->name('api.regis-user.create.user');
   
    Route::post('/master-user/update', [App\Http\Controllers\MasterUserController::class, 'updateUser'])->name('regis-user.master-user.update.user');
    Route::get('/master-user/edit/{id}', [App\Http\Controllers\MasterUserController::class, 'editUser'])->name('regis-user.master-user.edit.user');
    Route::get('/master-user/delete/{id}', [App\Http\Controllers\MasterUserController::class, 'deleteUser'])->name('regis-user.master-user.delete.user');
    //Datatables
    Route::get('/datatables/get-master-user', [App\Http\Controllers\MasterUserController::class, 'getDataMasterUser'])->name('datatables.regis-user.master.user');

    //Master Vendor
    Route::get('/master-vendor', [App\Http\Controllers\MasterVendorController::class, 'getMasterVendor'])->name('regis-user.master-vendor');
    Route::post('/add-vendor', [App\Http\Controllers\MasterVendorController::class, 'vendorAdd'])->name('api.regis-user.create.vendor');
   
    Route::post('/master-vendor/update', [App\Http\Controllers\MasterVendorController::class, 'updateVendor'])->name('regis-user.master-vendor.update.vendor');
    Route::get('/master-vendor/edit/{id}', [App\Http\Controllers\MasterVendorController::class, 'editVendor'])->name('regis-user.master-vendor.edit.vendor');
    Route::get('/master-vendor/delete/{id}', [App\Http\Controllers\MasterVendorController::class, 'deleteVendor'])->name('regis-user.master-vendor.delete.vendor');
    //Datatables
    Route::get('/datatables/get-master-vendor', [App\Http\Controllers\MasterVendorController::class, 'getDataMasterVendor'])->name('datatables.regis-user.master.vendor');

   //Number Range
   Route::get('/number-range', [App\Http\Controllers\NumberRangeController::class, 'getNumberRange'])->name('regis-user.number-range');
   Route::post('/add-number', [App\Http\Controllers\NumberRangeController::class, 'numberAdd'])->name('api.regis-user.create.number');
  
   Route::post('/number-range/update', [App\Http\Controllers\NumberRangeController::class, 'updateNumber'])->name('regis-user.number-range.update.number');
   Route::get('/number-range/edit/{id}', [App\Http\Controllers\NumberRangeController::class, 'editNumber'])->name('regis-user.number-range.edit.number');
   Route::get('/number-range/delete/{id}', [App\Http\Controllers\NumberRangeController::class, 'deleteNumber'])->name('regis-user.number-range.delete.number');
   //Datatables
   Route::get('/datatables/get-number-range', [App\Http\Controllers\NumberRangeController::class, 'getDataNumberRange'])->name('datatables.regis-user.number.range');

   
  //Master PDA User
  Route::get('/master-pdauser', [App\Http\Controllers\MasterPDAUserController::class, 'getMasterPDAUser'])->name('regis-user.master-pdauser');
  Route::post('/add-pdauser', [App\Http\Controllers\MasterPDAUserController::class, 'pdauserAdd'])->name('api.regis-user.create.pdauser');
 
  Route::post('/master-pdauser/update', [App\Http\Controllers\MasterPDAUserController::class, 'updatePdauser'])->name('regis-user.master-pdauser.update.pdauser');
  Route::get('/master-pdauser/edit/{id}', [App\Http\Controllers\MasterPDAUserController::class, 'editPdauser'])->name('regis-user.master-pdauser.edit.pdauser');
  Route::get('/master-pdauser/delete/{id}', [App\Http\Controllers\MasterPDAUserController::class, 'deletePdauser'])->name('regis-user.master-pdauser.delete.pdauser');
  //Datatables
  Route::get('/datatables/get-master-pdauser', [App\Http\Controllers\MasterPDAUserController::class, 'getDataMasterPDAUser'])->name('datatables.regis-user.master.pdauser');


   //User Log Record
   Route::get('/user-logrecord', [App\Http\Controllers\UserLogRecordController::class, 'getUserLogRecord'])->name('regis-user.user-logrecord');
   Route::post('/add-logrecord', [App\Http\Controllers\UserLogRecordController::class, 'logrecordAdd'])->name('api.regis-user.create.logrecord');
  
   Route::post('/user-logrecord/update', [App\Http\Controllers\UserLogRecordController::class, 'updateLogRecord'])->name('regis-user.user-logrecord.update.logrecord');
   Route::get('/user-logrecord/edit/{id}', [App\Http\Controllers\UserLogRecordController::class, 'editLogRecord'])->name('regis-user.user-logrecord.edit.logrecord');
   Route::get('/user-logrecord/delete/{id}', [App\Http\Controllers\UserLogRecordController::class, 'deleteLogRecord'])->name('regis-user.user-logrecord.delete.logrecord');
   //Datatables
   Route::get('/datatables/get-user-logrecord', [App\Http\Controllers\UserLogRecordController::class, 'getDataUserLogRecord'])->name('datatables.regis-user.user.logrecord');

});


Route::group(['middleware' => ['auth']], function () {
    // DELIVERY SCHEDULE ROUTES
    Route::prefix('delivery-schedule')->group(function(){
        Route::get('/dummy-file-act', [App\Http\Controllers\DeliveryScheduleController::class, 'createDummyFile'])->name('dummy-file');
        Route::get('/mf', [App\Http\Controllers\DeliveryScheduleController::class, 'index'])->name('delivery.schedule.mf');
        Route::post('/mf/download', [App\Http\Controllers\DeliveryScheduleController::class, 'zipMF'])->name('delivery.schedule.mf.download');
        Route::get('/spc', [App\Http\Controllers\DeliveryScheduleController::class, 'index_spo'])->name('delivery.schedule.spc');
        Route::post('/spc/download', [App\Http\Controllers\DeliveryScheduleController::class, 'zipMFSP'])->name('delivery.schedule.spc.download');
        //Datatables
        Route::get('/mf/get-data/{start?}/{end?}',[App\Http\Controllers\DeliveryScheduleController::class, 'getDeliveryMf'])->name('api.schedule.delivery.datatables');
        Route::get('/spc/get-data/{start?}/{end?}',[App\Http\Controllers\DeliveryScheduleController::class, 'getDeliverySPC'])->name('api.schedule.delivery.spc.datatables');
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
        Route::post('/modify-document-check-list/add', [App\Http\Controllers\ProjectManagementController::class, 'DocCheckListModifyAdd'])->name('project.management.master.listcheck.modify.doc.add');
        Route::get('/modify-document-check-list/edit/{id}', [App\Http\Controllers\ProjectManagementController::class, 'DocCheckListModifyEdit'])->name('project.management.master.listcheck.modify.doc.edit');
        Route::post('/modify-document-check-list/update', [App\Http\Controllers\ProjectManagementController::class, 'DocCheckListModifyUpdate'])->name('project.management.master.listcheck.modify.doc.update');
        Route::get('/modify-document-check-list/doc-master', [App\Http\Controllers\ProjectManagementController::class, 'DocMaster'])->name('project.management.master.listcheck.modify.doc.docmaster');
        Route::post('/modify-document-check-list/doc-master/update', [App\Http\Controllers\ProjectManagementController::class, 'updateDocPart'])->name('project.management.master.listcheck.modify.doc.updateDocPart');
        Route::get('/modify-document-check-list/doc-master/edit/{id}', [App\Http\Controllers\ProjectManagementController::class, 'DocMasterEdit'])->name('project.management.master.listcheck.modify.doc.editdocpart');
        Route::get('/modify-document-check-list/doc-assign', [App\Http\Controllers\ProjectManagementController::class, 'DocMasterAssign'])->name('project.management.master.listcheck.modify.doc.assigns');
         //
        // Upload Doc Project
        Route::get('/upload-project-doc', [App\Http\Controllers\ProjectManagementController::class, 'uploadProjectDoc'])->name('project.management.upload.project');
        Route::post('/upload-project-doc/upload', [App\Http\Controllers\ProjectManagementController::class, 'uploadDocAct'])->name('project.management.upload.project.actUpload');
        Route::post('/upload-req-doc/upload', [App\Http\Controllers\ProjectManagementController::class, 'uploadDocReqAct'])->name('project.management.upload.doc.actUpload');
        // Check Doc Eng
        Route::get('/check-doc-eng', [App\Http\Controllers\ProjectManagementController::class, 'checkDocEng'])->name('project.management.check.doc.eng');
        Route::get('/check-doc-vendor', [App\Http\Controllers\ProjectManagementController::class, 'checkDocVendor'])->name('project.management.check.doc.vendor');
        Route::get('/doc-assign-vendor', [App\Http\Controllers\ProjectManagementController::class, 'assignVendor'])->name('project.management.assign.vendor');
        Route::post('/doc-assign-vendor/assign', [App\Http\Controllers\ProjectManagementController::class, 'assignVendorAct'])->name('project.management.assign.vendor.act');
        // Check Doc Eng
         Route::get('/dashboard-monitoring-project', [App\Http\Controllers\ProjectManagementController::class, 'dashboardMonProject'])->name('project.management.project.monitoring');  

         // view Doc 
         Route::get('/view-doc-vendor', [App\Http\Controllers\ProjectManagementController::class, 'viewDocVendor'])->name('project.management.project.view.doc'); 
         Route::get('/upl-req-doc', [App\Http\Controllers\ProjectManagementController::class, 'uplReqDoc'])->name('project.management.project.upl.req.doc'); 
         // Vendor Project
         Route::get('/dashboard-monitoring-vendor', [App\Http\Controllers\ProjectManagementController::class, 'dashboardMonVendor'])->name('project.management.vendor.monitoring'); 
         // File Master
         Route::get('/file-master', [App\Http\Controllers\ProjectManagementController::class, 'file_master'])->name('project.management.file.master');
        //Datatables
        Route::get('/datatables/get-project-master', [App\Http\Controllers\ProjectManagementController::class, 'getProjectMaster'])->name('datatables.project.management.master');
        Route::get('/datatables/get-checklist-master', [App\Http\Controllers\ProjectManagementController::class, 'getMasterCheckList'])->name('datatables.project.management.checklist.master');
        Route::get('/datatables/get-project-assign', [App\Http\Controllers\ProjectManagementController::class, 'getProjectAssignMaster'])->name('datatables.project.management.assign.master');
        Route::get('/datatables/get-product-assign', [App\Http\Controllers\ProjectManagementController::class, 'getProductAssignMaster'])->name('datatables.project.management.assign.product.master');
        Route::get('/datatables/get-product-master', [App\Http\Controllers\ProjectManagementController::class, 'getProductMaster'])->name('datatables.project.management.product.master');
        Route::get('/datatables/get-part-master', [App\Http\Controllers\ProjectManagementController::class, 'getPartMaster'])->name('datatables.project.management.part.master');
        Route::get('/datatables/get-part-assign', [App\Http\Controllers\ProjectManagementController::class, 'getPartAssign'])->name('datatables.project.management.assign.part.master');
        Route::get('/datatables/get-checklist-modify', [App\Http\Controllers\ProjectManagementController::class, 'getCheckListModify'])->name('datatables.project.management.checklist-modify');
        Route::get('/datatables/get-doc-master', [App\Http\Controllers\ProjectManagementController::class, 'getDocMaster'])->name('datatables.project.management.doc-master');
        // CRUD
       
         Route::post('/add-project', [App\Http\Controllers\ProjectManagementController::class, 'projectAdd'])->name('api.project.management.create.project');
         Route::post('/add-document', [App\Http\Controllers\ProjectManagementController::class, 'docAdd'])->name('api.project.management.create.doc');
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


   Route::prefix('purchasing-process')->group(function () {
    Route::get('/list-po', function () {   
        return view('purchasing_process.list-po.index');
   });
 });

});