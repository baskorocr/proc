<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Models\Permission;
use Illuminate\Support\Facades\Cache;
use App\Helpers\IsoHelper;
use App\Helpers\Logger;
use Illuminate\Support\Facades\RateLimiter;
use App\Http\Controllers\MasterData\CustomerController;
use App\Http\Controllers\MasterData\ProjectController;
use App\Http\Controllers\MasterData\VendorController;
use App\Http\Controllers\MasterData\AssetTypeController;
use App\Http\Controllers\MasterData\PartController;
use App\Http\Controllers\MasterData\ProsesController;
use App\Http\Controllers\MasterData\PemilikController;
use App\Http\Controllers\MasterData\AssetsController;
use App\Http\Controllers\MasterData\PhotoController;
use App\Http\Controllers\MasterData\RiwayatController;
use App\Http\Controllers\MasterData\UserManagementController;
use App\Http\Controllers\CronController;

use App\Models\masterData\Riwayat;


Route::get('/test-f', function(){
  $logger = new Logger();
    $logger->menu = "SEND-MANIFEST-TO-SAP";
    $logger->code = "SAP-MF-S-01";
    $logger->step = "01";
    $logger->function = "sendManifestSap";
    $logger->controller = "ManifestController";
    $logger->company_code = auth()->user()->foreign_id;
    $logger->action_by = auth()->user()->nm_user;
    $logger->user_id = auth()->user()->_id;
    $logger->status_code = 200;
    $logger->status = "success";
    $logger->messages = "Start Get Detail Manifest";
    $logger->trace();

    sleep(3);
    $logger = new Logger();
    $logger->menu = "SEND-MANIFEST-TO-SAP";
    $logger->code = "SAP-MF-S-01";
    $logger->step = "01";
    $logger->function = "sendManifestSap";
    $logger->controller = "ManifestController";
    $logger->company_code = auth()->user()->foreign_id;
    $logger->action_by = auth()->user()->nm_user;
    $logger->user_id = auth()->user()->_id;
    $logger->status_code = 200;
    $logger->status = "success";
    $logger->messages = "Start Get Detail Manifest";
    $logger->trace();
})->name('c');
Route::get('/', function () {
    if(Auth::check())
    {
        $r = Permission::where('parent_id',@auth()->user()->roles->permissions[0]['permission_id'])->orderBy('_id','ASC')->get();
          $data = [];
          foreach(@auth()->user()->roles->permissions as $f)
          {
            $data[]=$f['permission_id'];
          }

          foreach ($r as $role) {
            if(in_array($role->_id, $data))
            {
              $redirect = $role->url;
              break;
            }
          }
        return redirect($redirect);
    }
    return view('eproc.login');
})->name('login');

// Cron route for auto update asset status
Route::get('/cron/update-asset-status', [CronController::class, 'updateAssetStatus'])
    ->name('cron.update-asset-status');
Route::get('/auth/callback',[AuthController::class,'handleSSOCallback']);
Route::group(['middleware' => ['auth']], function () {
     
    Route::get('/logout',[AuthController::class,'logout'])->name('logout');
      Route::get('/lockscreen', function(){
            \Cache::forget('active_'.auth()->user()->_id);
            session()->regenerate();  
            // UserLogging::trace(auth()->user()->id_user,\Request::ip(),now(),"F","in","TEST");
            return view('auth/lockscreen');
    })->name('lockscreen');
    Route::post('/unlockScreen',[AuthController::class,'unlockScreen'])->name('unlockScreen');
});
Route::group(['middleware' => ['auth','route_protect','lockscreen']], function () {
 
    Route::get('/manifest_test_mail/{manifestId}', [App\Http\Controllers\ManifestController::class, 'manifest_test_mail'])->name('testMailer');
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/security/changepwd', [App\Http\Controllers\ProfileController::class, 'changePwdLink'])->name('change.pwd.link');
    Route::get('/security/change-password', [App\Http\Controllers\ProfileController::class, 'changePwd'])->name('change.pwd');
    Route::get('/security/chpwd/logout', [App\Http\Controllers\ProfileController::class, 'passwordLogout'])->name('pwd.logout');
    Route::post('/security/do/change-password', [App\Http\Controllers\ProfileController::class, 'changePwdAct'])->name('change.pwd.act');
    Route::get('/test_read', [App\Http\Controllers\PurchasingProcessController::class, 'test_read'])->name('testt');

    Route::prefix('doc-iso')->group(function(){

        //Master Notify
        Route::get('/cronjob/upcoming-iso-expired', [App\Http\Controllers\RegisIsoDocController::class, 'cron_check_iso_upcoming_expired'])->name('doc-iso.cron.iso-expired');
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

        Route::get('/renew-doc-iso/{id}', [App\Http\Controllers\RegisIsoDocController::class, 'renew'])->name('doc-iso.renew');
        Route::get('/change-doc-iso/{id}', [App\Http\Controllers\RegisIsoDocController::class, 'change'])->name('doc-iso.change');
        Route::post('/change-doc-iso/change', [App\Http\Controllers\RegisIsoDocController::class, 'change_act'])->name('doc-iso.change_iso');
        Route::post('/renew-doc-iso/renew', [App\Http\Controllers\RegisIsoDocController::class, 'renewal'])->name('doc-iso.renewal');
        Route::get('/view-doc-iso/{id}', [App\Http\Controllers\RegisIsoDocController::class, 'show'])->name('doc-iso.view');
        Route::get('/appproval-iso/{id}', [App\Http\Controllers\RegisIsoDocController::class, 'approve'])->name('approve-iso');
        Route::get('/delete-iso', [App\Http\Controllers\RegisIsoDocController::class, 'delete_act'])->name('delete-iso');
        Route::get('/detail-iso-report/{stat}', [App\Http\Controllers\ReportIsoDocController::class, 'stat_iso'])->name('detail-iso-report');
        Route::get('/detail-iso-dashboard/{stat}', [App\Http\Controllers\DashboardIsoDocController::class, 'stat_iso'])->name('detail-iso-dashboard');
        Route::post('/appproval-iso/approve', [App\Http\Controllers\RegisIsoDocController::class, 'approval_iso'])->name('doc-iso.approval_iso');
       
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
        Route::post('/add-group', [App\Http\Controllers\EmailGroupController::class, 'store'])->name('api.regis-user.create.email');
       
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

        Route::get('/master-user/export-users', [App\Http\Controllers\MasterUserController::class, 'export'])->name('regis-user.export');
        Route::get('/master-user', [App\Http\Controllers\MasterUserController::class, 'getMasterUser'])->name('regis-user.master-user');
        Route::get('/master-user/add-user', [App\Http\Controllers\MasterUserController::class, 'create'])->name('api.regis-user.create.user');
        Route::get('/master-user/add-user-vendor', [App\Http\Controllers\MasterUserController::class, 'createVendor'])->name('api.regis-user.create.usrvendor');
        Route::post('/master-user/store', [App\Http\Controllers\MasterUserController::class, 'store'])->name('api.regis-user.create.user.act');
        Route::post('/master-user/store-vendor', [App\Http\Controllers\MasterUserController::class, 'storeVendor'])->name('api.regis-user.create.user.vendor.act');
       
        Route::post('/master-user/update-vendor', [App\Http\Controllers\MasterUserController::class, 'updateVendor'])->name('regis-user.master-user.update.uservendor');
        Route::post('/master-user/update', [App\Http\Controllers\MasterUserController::class, 'updateUser'])->name('regis-user.master-user.update.user');
        Route::get('/master-user/edit/{id}', [App\Http\Controllers\MasterUserController::class, 'editUser'])->name('regis-user.master-user.edit.user');
        Route::get('/master-user/upload-email-vendor', [App\Http\Controllers\MasterUserController::class, 'upload'])->name('api.regis-user.upload.user');
        Route::post('/master-user/upload-email-vendor-start', [App\Http\Controllers\MasterUserController::class, 'uploadEmail'])->name('api.regis-user.upload.emailuser');
        Route::get('/master-user/reset/{id}', [App\Http\Controllers\MasterUserController::class, 'reset'])->name('regis-user.master-user.reset');
        Route::get('/master-user/delete/{id}', [App\Http\Controllers\MasterUserController::class, 'deleteUser'])->name('regis-user.master-user.delete.user');
        //Datatables
        Route::get('/datatables/get-master-user', [App\Http\Controllers\MasterUserController::class, 'getDataMasterUser'])->name('datatables.regis-user.master.user');

        //Master Vendor
        Route::get('/master-vendor', [App\Http\Controllers\MasterVendorController::class, 'getMasterVendor'])->name('regis-user.master-vendor');

        Route::get('/master-user/export-vendors', [App\Http\Controllers\MasterVendorController::class, 'export'])->name('regis-user.vendor.export');
        Route::post('/add-vendor', [App\Http\Controllers\MasterVendorController::class, 'store'])->name('api.regis-user.create.vendor');
        Route::get('/upload-vendor', [App\Http\Controllers\MasterVendorController::class, 'upload'])->name('regis-user.upload.vendor');
       Route::post('/upload-vendor', [App\Http\Controllers\MasterVendorController::class, 'upload_vendor'])->name('regis-user.upload.vendor-act');
        Route::post('/master-vendor/update', [App\Http\Controllers\MasterVendorController::class, 'updateVendor'])->name('regis-user.master-vendor.update.vendor');
        Route::get('/master-vendor/edit/{id}', [App\Http\Controllers\MasterVendorController::class, 'editVendor'])->name('regis-user.master-vendor.edit.vendor');
        Route::get('/master-vendor/delete/{id}', [App\Http\Controllers\MasterVendorController::class, 'deleteVendor'])->name('regis-user.master-vendor.delete.vendor');
        //Datatables
        Route::get('/datatables/get-master-vendor', [App\Http\Controllers\MasterVendorController::class, 'getDataMasterVendor'])->name('datatables.regis-user.master.vendor');

       //Number Range
       Route::get('/number-range', [App\Http\Controllers\NumberRangeController::class, 'index'])->name('regis-user.number-range');
       Route::post('/add-number', [App\Http\Controllers\NumberRangeController::class, 'numberAdd'])->name('api.regis-user.create.number');
      
       Route::post('/number-range/update', [App\Http\Controllers\NumberRangeController::class, 'updateNumber'])->name('regis-user.number-range.update.number');
       Route::get('/number-range/edit/{id}', [App\Http\Controllers\NumberRangeController::class, 'editNumber'])->name('regis-user.number-range.edit.number');
       Route::get('/number-range/delete/{id}', [App\Http\Controllers\NumberRangeController::class, 'destroy'])->name('regis-user.number-range.delete.number');
       //Datatables
       Route::get('/datatables/get-number-range', [App\Http\Controllers\NumberRangeController::class, 'getNumberRange'])->name('datatables.regis-user.number.range');

       
      //Master PDA User
      Route::get('/master-pdauser', [App\Http\Controllers\MasterPDAUserController::class, 'getMasterPDAUser'])->name('regis-user.master-pdauser');
      Route::post('/add-pdauser', [App\Http\Controllers\MasterPDAUserController::class, 'store'])->name('api.regis-user.create.pdauser');
     
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
        //Master Data MT
        Route::prefix('master-data-mt')->group(function(){
            Route::get('customers', [CustomerController::class, 'index'])->name('customers.index');
            Route::get('customers/create', [CustomerController::class, 'create'])->name('customers.create');
            Route::post('customers', [CustomerController::class, 'store'])->name('customers.store');
            Route::get('customers/{customer}', [CustomerController::class, 'show'])->name('customers.show');
            Route::get('customers/{customer}/edit', [CustomerController::class, 'edit'])->name('customers.edit');
            Route::put('customers/{customer}', [CustomerController::class, 'update'])->name('customers.update');
            Route::delete('customers/{customer}', [CustomerController::class, 'destroy'])->name('customers.destroy');
        
            // Projects
            Route::get('projects', [ProjectController::class, 'index'])->name('projects.index');
            Route::get('projects/create', [ProjectController::class, 'create'])->name('projects.create');
            Route::post('projects', [ProjectController::class, 'store'])->name('projects.store');
            Route::get('projects/{project}', [ProjectController::class, 'show'])->name('projects.show');
            Route::get('projects/{project}/edit', [ProjectController::class, 'edit'])->name('projects.edit');
            Route::put('projects/{project}', [ProjectController::class, 'update'])->name('projects.update');
            Route::delete('projects/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy');
        
            // Vendors
            Route::get('vendors', [VendorController::class, 'index'])->name('vendors.index');
            Route::get('vendors/create', [VendorController::class, 'create'])->name('vendors.create');
            Route::post('vendors', [VendorController::class, 'store'])->name('vendors.store');
            Route::get('vendors/{vendor}', [VendorController::class, 'show'])->name('vendors.show');
            Route::get('vendors/{vendor}/edit', [VendorController::class, 'edit'])->name('vendors.edit');
            Route::put('vendors/{vendor}', [VendorController::class, 'update'])->name('vendors.update');
            Route::delete('vendors/{vendor}', [VendorController::class, 'destroy'])->name('vendors.destroy');
        
            // Asset Types
            Route::get('asset-types', [AssetTypeController::class, 'index'])->name('asset-types.index');
            Route::get('asset-types/create', [AssetTypeController::class, 'create'])->name('asset-types.create');
            Route::post('asset-types', [AssetTypeController::class, 'store'])->name('asset-types.store');
            Route::get('asset-types/{asset_type}', [AssetTypeController::class, 'show'])->name('asset-types.show');
            Route::get('asset-types/{asset_type}/edit', [AssetTypeController::class, 'edit'])->name('asset-types.edit');
            Route::put('asset-types/{asset_type}', [AssetTypeController::class, 'update'])->name('asset-types.update');
            Route::delete('asset-types/{asset_type}', [AssetTypeController::class, 'destroy'])->name('asset-types.destroy');
        
            // Parts
            Route::get('parts', [PartController::class, 'index'])->name('parts.index');
            Route::post('parts/sync-sap', [PartController::class, 'syncFromSap'])->name('parts.sync-sap');
            Route::get('parts/create', [PartController::class, 'create'])->name('parts.create');
            Route::post('parts', [PartController::class, 'store'])->name('parts.store');
            Route::get('parts/{part}', [PartController::class, 'show'])->name('parts.show');
            Route::get('parts/{part}/edit', [PartController::class, 'edit'])->name('parts.edit');
            Route::put('parts/{part}', [PartController::class, 'update'])->name('parts.update');
            Route::delete('parts/{part}', [PartController::class, 'destroy'])->name('parts.destroy');
        
            // Proses
            Route::get('proses', [ProsesController::class, 'index'])->name('proses.index');
            Route::get('proses/create', [ProsesController::class, 'create'])->name('proses.create');
            Route::post('proses', [ProsesController::class, 'store'])->name('proses.store');
            Route::get('proses/{proses}', [ProsesController::class, 'show'])->name('proses.show');
            Route::get('proses/{proses}/edit', [ProsesController::class, 'edit'])->name('proses.edit');
            Route::put('proses/{proses}', [ProsesController::class, 'update'])->name('proses.update');
            Route::delete('proses/{proses}', [ProsesController::class, 'destroy'])->name('proses.destroy');
        
            // Pemiliks
            Route::get('pemiliks', [PemilikController::class, 'index'])->name('pemiliks.index');
            Route::get('pemiliks/create', [PemilikController::class, 'create'])->name('pemiliks.create');
            Route::post('pemiliks', [PemilikController::class, 'store'])->name('pemiliks.store');
            Route::get('pemiliks/{pemilik}', [PemilikController::class, 'show'])->name('pemiliks.show');
            Route::get('pemiliks/{pemilik}/edit', [PemilikController::class, 'edit'])->name('pemiliks.edit');
            Route::put('pemiliks/{pemilik}', [PemilikController::class, 'update'])->name('pemiliks.update');
            Route::delete('pemiliks/{pemilik}', [PemilikController::class, 'destroy'])->name('pemiliks.destroy');
        
            // Assets Part
            Route::get('assetsPart', [AssetsController::class, 'index'])->name('assetsPart.index');
            Route::get('assetsPart/create', [AssetsController::class, 'create'])->name('assetsPart.create');
            Route::post('assetsPart', [AssetsController::class, 'store'])->name('assetsPart.store');
            Route::post('assetsPart/import', [AssetsController::class, 'import'])->name('assetsPart.import');
            Route::post('assetsPart/bulk-delete', [AssetsController::class, 'bulkDelete'])->name('assetsPart.bulkDelete');
            Route::get('assetsPart/export', [AssetsController::class, 'export'])->name('assetsPart.export');
            Route::get('assetsPart/{assetsPart}', [AssetsController::class, 'show'])->name('assetsPart.show');
            Route::get('assetsPart/{assetsPart}/edit', [AssetsController::class, 'edit'])->name('assetsPart.edit');
            Route::put('assetsPart/{assetsPart}', [AssetsController::class, 'update'])->name('assetsPart.update');
            Route::delete('assetsPart/{assetsPart}', [AssetsController::class, 'destroy'])->name('assetsPart.destroy');
        
            // Move
            Route::post('assetsPart/{no_assets}/move', [AssetsController::class, 'move'])->name('assetsPart.move');
        
            // Photos
            Route::get('photos', [PhotoController::class, 'index'])->name('photos.index');
            Route::get('photos/create', [PhotoController::class, 'create'])->name('photos.create');
            Route::post('photos', [PhotoController::class, 'store'])->name('photos.store');
            Route::get('photos/{photo}', [PhotoController::class, 'show'])->name('photos.show');
            Route::get('photos/{photo}/edit', [PhotoController::class, 'edit'])->name('photos.edit');
            Route::put('photos/{photo}', [PhotoController::class, 'update'])->name('photos.update');
            Route::delete('photos/{photo}', [PhotoController::class, 'destroy'])->name('photos.destroy');
        
            // Riwayat
            Route::get('riwayat', [RiwayatController::class, 'index'])->name('riwayat.index');
            Route::get('riwayat/create', [RiwayatController::class, 'create'])->name('riwayat.create');
            Route::post('riwayat', [RiwayatController::class, 'store'])->name('riwayat.store');
            Route::get('riwayat/{riwayat}', [RiwayatController::class, 'show'])->name('riwayat.show');
            Route::get('riwayat/{riwayat}/edit', [RiwayatController::class, 'edit'])->name('riwayat.edit');
            Route::put('riwayat/{riwayat}', [RiwayatController::class, 'update'])->name('riwayat.update');
            Route::delete('riwayat/{riwayat}', [RiwayatController::class, 'destroy'])->name('riwayat.destroy');
        
            // User Manajemen
            Route::get('user-manajemen', [UserManagementController::class, 'index'])->name('user-manajemen.index');
            Route::get('user-manajemen/create', [UserManagementController::class, 'create'])->name('user-manajemen.create');
            Route::post('user-manajemen', [UserManagementController::class, 'store'])->name('user-manajemen.store');
            Route::get('user-manajemen/{user}', [UserManagementController::class, 'show'])->name('user-manajemen.show');
            Route::get('user-manajemen/{user}/edit', [UserManagementController::class, 'edit'])->name('user-manajemen.edit');
            Route::put('user-manajemen/{user}', [UserManagementController::class, 'update'])->name('user-manajemen.update');
            Route::delete('user-manajemen/{user}', [UserManagementController::class, 'destroy'])->name('user-manajemen.destroy');

            

        });

        Route::prefix('mt-asset')->group(function(){   
            Route::get('history', [App\Http\Controllers\Maintenance\MovementAssetsController::class,'history'])->name('mt-asset.history');
            Route::get('action', [App\Http\Controllers\Maintenance\ActionMTController::class,'index'])->name('mt-asset.index');
            Route::get('riwayat', [App\Http\Controllers\Maintenance\ActionMTController::class,'riwayat'])->name('mt-asset.riwayat');
            Route::post('/kunjungan', [App\Http\Controllers\Maintenance\ActionMTController::class, 'kunjungan'])->name('kunjungan.schedule');
            Route::delete('/kunjungan/{id}', [App\Http\Controllers\Maintenance\ActionMTController::class, 'KunjunganDestroy'])->name('kunjungan.destroy');
            Route::post('/kunjungan/reschedule', [App\Http\Controllers\Maintenance\ActionMTController::class, 'reschedule'])->name('kunjungan.reschedule');
            Route::post('/maintenance/upload', [App\Http\Controllers\Maintenance\ActionMTController::class, 'uploadMaintenance'])->name('maintenance.upload');
            Route::get('/verification', [App\Http\Controllers\Maintenance\ActionMTController::class, 'verification'])->name('verification.index');
            Route::put('/maintenance/verify/{id}/approve', [App\Http\Controllers\Maintenance\ActionMTController::class, 'approveMaintenance'])->name('maintenance.approve');
            Route::put('/maintenance/verify/{id}/reject', [App\Http\Controllers\Maintenance\ActionMTController::class, 'rejectMaintenance'])->name('maintenance.reject');

            
           });
        //CONFIG ROUTES
        Route::prefix('config')->group(function(){
            Route::get('/permission', [App\Http\Controllers\ConfigController::class, 'permission'])->name('config.permission');
            Route::get('/permission/delete/{id}', [App\Http\Controllers\ConfigController::class, 'deletePermission'])->name('config.permission.delete');
            Route::get('/permission/edit/{id}', [App\Http\Controllers\ConfigController::class, 'editPermission'])->name('config.permission.edit');
            Route::get('/permission/create', [App\Http\Controllers\ConfigController::class, 'createPermission'])->name('config.permission.create');
            Route::post('/permission/save', [App\Http\Controllers\ConfigController::class, 'insertPermission'])->name('config.permission.save');
            Route::post('/permission/update', [App\Http\Controllers\ConfigController::class, 'updatePermission'])->name('config.permission.update');
            Route::get('/datatables/get-permission', [App\Http\Controllers\ConfigController::class, 'getDatatablePermission'])->name('api.perm.datatables');
            // ROLES
            Route::get('/role', [App\Http\Controllers\ConfigController::class, 'role'])->name('config.role');
            Route::get('/role/edit/{id}', [App\Http\Controllers\ConfigController::class, 'editRole'])->name('config.role.edit');
            Route::get('/role/delete/{id}', [App\Http\Controllers\ConfigController::class, 'deleteRole'])->name('config.role.delete');
            Route::get('/role/create', [App\Http\Controllers\ConfigController::class, 'createRole'])->name('config.role.add');
            Route::post('/role/save', [App\Http\Controllers\ConfigController::class, 'saveRole'])->name('config.role.save');
            Route::post('/role/update', [App\Http\Controllers\ConfigController::class, 'updateRole'])->name('config.role.update');
            Route::get('/datatables/get-roles', [App\Http\Controllers\ConfigController::class, 'getDatatableRole'])->name('api.role.datatables');

        });
        // DELIVERY SCHEDULE ROUTES
        Route::prefix('delivery-schedule')->group(function(){
            Route::get('/dummy-file-act', [App\Http\Controllers\DeliveryScheduleController::class, 'createDummyFile'])->name('dummy-file');
            Route::get('/mf', [App\Http\Controllers\DeliveryScheduleController::class, 'index'])->name('delivery.schedule.mf');
            Route::post('/mf/download', [App\Http\Controllers\DeliveryScheduleController::class, 'zipMF'])->name('delivery.schedule.mf.download');
            Route::get('/spc', [App\Http\Controllers\DeliveryScheduleController::class, 'index_spo'])->name('delivery.schedule.spc');
            Route::post('/spc/download', [App\Http\Controllers\DeliveryScheduleController::class, 'zipMFSP'])->name('delivery.schedule.spc.download');
            //Datatables
            Route::get('/mf/get-data',[App\Http\Controllers\DeliveryScheduleController::class, 'getDeliveryMf'])->name('api.schedule.delivery.datatables');
            Route::get('/spc/get-data',[App\Http\Controllers\DeliveryScheduleController::class, 'getDeliverySPC'])->name('api.schedule.delivery.spc.datatables');
        });

        // Monitoring Delivery Routes
        Route::prefix('monitoring-delivery')->group(function(){
            Route::get('/', [App\Http\Controllers\MonitoringDeliveryController::class, 'index'])->name('monitoring.delivery');
            Route::get('/detail/materials/{manifest?}',[App\Http\Controllers\MonitoringDeliveryController::class, 'detail_material'])->name('monitoring.delivery.detail.material');
            Route::get('/detail/kanbans/{manifest?}',[App\Http\Controllers\MonitoringDeliveryController::class, 'detail_kanban'])->name('monitoring.delivery.detail.kanban');
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
    Route::get('/dashboard', [App\Http\Controllers\ProjectManagementController::class, 'dashboardMonProject']);
    Route::get('/blank', function (){
        return redirect('/dashboard');
    });


    Route::prefix('purchasing-process')->group(function(){
        Route::get('/batch-mail-send', [App\Http\Controllers\PurchasingProcessController::class, 'sendmail'])->name('purchasing.process.batch-mail');
        Route::get('/upload-po', [App\Http\Controllers\PurchasingProcessController::class, 'upload'])->name('purchasing.process.uploadpo');
        Route::post('/select-all-po', [App\Http\Controllers\PurchasingProcessController::class, 'selectAll'])->name('purchasing.process.selectAll');
        Route::get('/list-po', [App\Http\Controllers\PurchasingProcessController::class, 'index'])->name('purchasing.process.listpo');
        Route::get('/send-mail-po', [App\Http\Controllers\PurchasingProcessController::class, 'send_mail'])->name('purchasing.process.send.mail');
        Route::post('/datatables/get-list-po', [App\Http\Controllers\PurchasingProcessController::class, 'getListPo'])->name('datatables.purchasing.process.listpo');
        Route::post('/datatables/send-list-po', [App\Http\Controllers\PurchasingProcessController::class, 'getListPoSend'])->name('datatables.purchasing.process.listposend');
        Route::get('/download-list-po', [App\Http\Controllers\PurchasingProcessController::class, 'download'])->name('purchasing.process.download.listpo');
        Route::get('/datatables/get-download-list-po', [App\Http\Controllers\PurchasingProcessController::class, 'getDownloadListPo'])->name('datatables.purchasing.process.download.listpo');
        Route::post('/zip/download-list-po', [App\Http\Controllers\PurchasingProcessController::class, 'zipPurchasingProcess'])->name('purchasing.process.download.zip');
        Route::post('/upload-po', [App\Http\Controllers\PurchasingProcessController::class, 'importPo'])->name('purchasing.process.import.po');
    });

    Route::prefix('component')->group(function () {
        Route::get('/forminput', function () {
             return view('example.form');
        });
        Route::get('/datatable', function () {
            return view('example.table');
       });

        
    });
});