@extends('eproc.layouts.app')

@section('content')
{{--
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>
</div>
--}}

<?php include resource_path('views')."/eproc/menu/top-menu.php";?>
@include('eproc/menu/side-menu');

    <!-- Right side column. Contains the navbar and content of the page -->
    <aside class="right-side">

        <!-- Main content -->
        <section class="content">

            <div class="box">
                <div class="box-body">

                    <?php

                        //ROLE ADMIN
                        $menu = isset($_GET['mnu']) ? $_GET['mnu']:"";
                        if(Auth::user()->role=='admin'){
                            
                            switch ($menu) {
                                //=========================USER LOG====================================================
                                case "usrlog":
                                    require resource_path('views')."/eproc/registration/user-log.php";
                                    break;

                                case "srvlog":
                                    require resource_path('views')."/eproc/other/service-log.php";
                                    break;  
                                    
                                case "mnumaster":
                                    require resource_path('views')."/eproc/registration/menu-master.php";
                                    break;  

                                case "menuedit":
                                    require resource_path('views')."/eproc/registration/edit-menu-master.php";
                                    break;

                                case "mnugroup":
                                    require resource_path('views')."/eproc/registration/menu-group-master.php";
                                    break; 
                                    
                                case "mnugroupedit":
                                    require resource_path('views')."/eproc/registration/edit-menu-group.php";
                                    break;

                                case "accgrmaster":
                                    require resource_path('views')."/eproc/registration/access-group-master.php";
                                    break; 
                                    
                                case "accgroupedit":
                                    require resource_path('views')."/eproc/registration/edit-access-group.php";
                                    break;    

                                //=========================USER MASTER DATA============================================
                                case "vmaster":
                                    require resource_path('views')."/eproc/registration/vendor-master.php";
                                    break;
                                case "vdrmstdtupld":
                                    require resource_path('views')."/eproc/registration/upload-vendor-master.php";
                                    break;
                                case "vmasteredit":
                                    require resource_path('views')."/eproc/registration/edit-vendor-master.php";
                                    break;
                                case "umaster":
                                    require resource_path('views')."/eproc/registration/user-master.php";
                                    break;
                                case "umasteredit":
                                    require resource_path('views')."/eproc/registration/edit-user-master.php";
                                    break;
                                case "usermstrupld":
                                    require resource_path('views')."/eproc/registration/upload-user-master.php";
                                    break;
                                case "chpwd":
                                    require resource_path('views')."/eproc/registration/edit-pass.php";
                                    break;
                                case "pdaccs":
                                    require resource_path('views')."/eproc/registration/pda-master.php";
                                    break;   
                                case "pdamasteredit":
                                    require resource_path('views')."/eproc/registration/edit-pda-master.php";
                                    break; 
                                case "vdremailupdate":
                                    require resource_path('views')."/eproc/registration/update-user-email.php";
                                    break; 
                                case "emailgrp":
                                    require resource_path('views')."/eproc/registration/email-group-master.php";
                                    break; 
                                case "emailgrpedit":
                                    require resource_path('views')."/eproc/registration/edit-email-group.php";
                                    break; 
                                case "emailgrlist":
                                    require resource_path('views')."/eproc/registration/email-group-list.php";
                                    break; 
                                case "emailgrlistedit":
                                    require resource_path('views')."/eproc/registration/edit-email-list-group.php";
                                    break;                                  
                                case "numrange":
                                    require resource_path('views')."/eproc/registration/number-range.php";
                                    break; 
                                case "numrangeedit":
                                    require resource_path('views')."/eproc/registration/edit-number-range.php";
                                    break;            
                                case "lockscr":
                                    require resource_path('views')."/eproc/lock/";
                                    break;

                                //=========================PROJECT MGT============================================
                                case "projmaster":
                                    require resource_path('views')."/eproc/project_mgt/project-master.php";
                                    break;
                                case "projectmasteredit":
                                    require resource_path('views')."/eproc/project_mgt/edit-project-master.php";
                                    break;
                                case "newass":
                                    require resource_path('views')."/eproc/project_mgt/assignment-new.php";
                                    break;
                                case "crproj":
                                    require resource_path('views')."/eproc/project_mgt/assignment-create.php";
                                    break;
                                case "projectass":
                                    require resource_path('views')."/eproc/project_mgt/project-assignment.php";
                                    break;
                                case "prodmaster":
                                    require resource_path('views')."/eproc/project_mgt/product-master.php";
                                    break;
                                case "prodmasteredit":
                                    require resource_path('views')."/eproc/project_mgt/edit-product-master.php";
                                    break;
                                case "partmaster":
                                    require resource_path('views')."/eproc/project_mgt/part-master.php";
                                    break;
                                case "partmasteredit":
                                    require resource_path('views')."/eproc/project_mgt/edit-part-master.php";
                                    break;
                                case "partforprod":
                                    require resource_path('views')."/eproc/project_mgt/part-for-product.php";
                                    break;
                                case "partforprodedit":
                                    require resource_path('views')."/eproc/project_mgt/edit-part-for-product.php";
                                    break;
                                case "docmaster":
                                    require resource_path('views')."/eproc/project_mgt/doc-master.php";
                                    break;
                                case "docmasteredit":
                                    require resource_path('views')."/eproc/project_mgt/edit-doc-master.php";
                                    break;
                                case "docforpart":
                                    require resource_path('views')."/eproc/project_mgt/doc-for-part.php";
                                    break;
                                case "listcheckmaster":
                                    require resource_path('views')."/eproc/project_mgt/doc-check-list-master.php";
                                    break;
                                case "asslistcheckdoc":
                                    require resource_path('views')."/eproc/project_mgt/doc-check-list.php";
                                    break;
                                case "addlistcheckdoc":
                                    require resource_path('views')."/eproc/project_mgt/add-doc-check-list.php";
                                    break;
                                case "listcheckedit":
                                    require resource_path('views')."/eproc/project_mgt/edit-doc-list-check.php";
                                    break;
                                case "uplddraw":
                                    require resource_path('views')."/eproc/project_mgt/upload-drawing.php";
                                    break;
                                case "vuplddraw":
                                    require resource_path('views')."/eproc/project_mgt/view-uploaded-drawing.php";
                                    break;
                                case "vassign":
                                    require resource_path('views')."/eproc/project_mgt/assign-vendor.php";
                                    break;
                                case "vuplddrawvdr":
                                    require resource_path('views')."/eproc/project_mgt/view-uploaded-drawing-vendor.php";
                                    break;
                                case "uplddoceng":
                                    require resource_path('views')."/eproc/project_mgt/upload-doc-eng.php";
                                    break;
                                case "vupldeng":
                                    require resource_path('views')."/eproc/project_mgt/view-uploaded-drawing-eng.php";
                                    break;
                                case "monitoring":
                                    require resource_path('views')."/eproc/project_mgt/dashboard-monitoring-project.php";
                                    break;
                                case "checkdoc":
                                    require resource_path('views')."/eproc/project_mgt/check_doc.php";
                                    break;
                                case "checkdoceng":
                                    require resource_path('views')."/eproc/project_mgt/check_doc_eng.php";
                                    break;
                                case "checkdocproc":
                                    require resource_path('views')."/eproc/project_mgt/check_doc_vendor_proc.php";
                                    break;
                                case "checkvendview":
                                    require resource_path('views')."/eproc/project_mgt/check_doc_vendor_view.php";
                                    break;
                                case "vendprojmonitor":
                                    require resource_path('views')."/eproc/project_mgt/dashboard-vendor.php";
                                    break;
                                case "flmstr":
                                    require resource_path('views')."/eproc/project_mgt/files-in-directory.php";
                                    break;
                                    

                                //========= SCHCEDULE DELIVERY ========
                                case "schmasterupl" :
                                    require resource_path('views')."/eproc/schedule_delivery/sch-master-upload.php";
                                    break;

                                case "schmasteradd" :
                                    require resource_path('views')."/eproc/schedule_delivery/sch-master-additional.php";
                                    break;

                                case "schmastersct" :
                                    require resource_path('views')."/eproc/schedule_delivery/sch-master-select.php";
                                    break;

                                case "schmasterview" :
                                    require resource_path('views')."/eproc/schedule_delivery/sch-master-output.php";
                                    break;

                                case "schmastervend" :
                                    require resource_path('views')."/eproc/schedule_delivery/sch-master-vendor.php";
                                    break;

                                case "schmasterfix" :
                                    require resource_path('views')."/eproc/schedule_delivery/sch-master-fix.php";
                                    break;

                                case "gdrcpt" :
                                    require resource_path('views')."/eproc/schedule_delivery/good-receipt.php";
                                    break;

                                case "schvdrview" :
                                    require resource_path('views')."/eproc/schedule_delivery/sch-vendor-output.php";
                                    break;

                                case "schplanact" :
                                    require resource_path('views')."/eproc/schedule_delivery/sch-plan-act.php";
                                    break;

                                case "schplanactview" :
                                    require resource_path('views')."/eproc/schedule_delivery/sch-plan-act-output.php";
                                    break;

                                case "rawstckupl" :
                                    require resource_path('views')."/eproc/schedule_delivery/raw-stock-upload.php";
                                    break;

                                case "matstckupl" :
                                    require resource_path('views')."/eproc/schedule_delivery/mat-stock-upload.php";
                                    break;

                                case "dwldmfo" :
                                    require resource_path('views')."/eproc/schedule_delivery/download-manifest.php";
                                    break;
                                
                                case "dwldspo" :
                                    require resource_path('views')."/eproc/schedule_delivery/download-special.php";
                                    break;    

                                case "dashsch" :
                                    require resource_path('views')."/eproc/schedule_delivery/sch-vendor-dashboard.php";
                                    break;

                                case "mfmtr" :
                                    require resource_path('views')."/eproc/schedule_delivery/sch-detail-mat.php";
                                    break;

                                case "mfkbn" :
                                    require resource_path('views')."/eproc/schedule_delivery/sch-detail-kanban.php";
                                    break;

                                //=========================PURCHASING PROCESS============================================

                                case "uplaprvpo" :
                                    require resource_path('views')."/eproc/purchasing_process/po-approve-upload.php";
                                    break;

                                case "batchpo" :
                                    require resource_path('views')."/eproc/purchasing_process/po-batch-mail.php";
                                    break;

                                case "dlistpo" :
                                    require resource_path('views')."/eproc/purchasing_process/po-list-master.php";
                                    break;

                                case "dwldpo" :
                                    require resource_path('views')."/eproc/purchasing_process/download-po-mail.php";
                                    break;

                                case "getpo" :
                                    require resource_path('views')."/eproc/purchasing_process/get-po.php";
                                    break;
                                
                                //======================DOC ISO MANAGE===================================    
                                case "dashiso" :
                                    require resource_path('views')."/eproc/doc_iso/dashboard-iso.php";
                                    break;

                                case "mstcert" :
                                    require resource_path('views')."/eproc/doc_iso/mstcert-iso.php";
                                    break; 
                                    
                                case "mstiso" :
                                    require resource_path('views')."/eproc/doc_iso/mstiso-iso.php";
                                    break; 

                                case "mstnotif" :
                                    require resource_path('views')."/eproc/doc_iso/mstnotif-iso.php";
                                    break;      
                                
                                case "regiso" :
                                    require resource_path('views')."/eproc/doc_iso/regiso-iso.php";
                                    break;       

                                case "mstcertedit":
                                    require resource_path('views')."/eproc/doc_iso/edit-mstcert-iso.php";
                                    break;  

                                case "mstisoedit":
                                    require resource_path('views')."/eproc/doc_iso/edit-mstiso-iso.php";
                                    break;   
                                    
                                case "mstnotifedit":
                                    require resource_path('views')."/eproc/doc_iso/edit-mstnotif-iso.php";
                                    break; 
                                
                                case "isoreport":
                                    require resource_path('views')."/eproc/doc_iso/report-iso.php";
                                    break;  
                                
                                case "isorelease":
                                    require resource_path('views')."/eproc/doc_iso/release-iso.php";
                                    break; 
                                
                                case "isorenewal":
                                    require resource_path('views')."/eproc/doc_iso/renewal-iso.php";
                                    break;

                                case "isoreview":
                                    require resource_path('views')."/eproc/doc_iso/review-iso.php";
                                    break;
                                
                                case "isochange":
                                    require resource_path('views')."/eproc/doc_iso/change-iso.php";
                                    break;
                                
                                case "isodoctype":
                                    require resource_path('views')."/eproc/doc_iso/report-iso-doc-type.php";
                                    break;

                                case "isodocstat":
                                    require resource_path('views')."/eproc/doc_iso/report-iso-doc-stat.php";
                                    break;

                                //=========================DEFAULT PAGE============================================
                                default:
                                    require resource_path('views')."/eproc/project_mgt/dashboard-monitoring-project.php";
                            }

                        // ROLE VENDOR
                        } elseif(Auth::user()->role=='vendor') {

                            switch ($menu) {

                                case "chpwd":
                                    require resource_path('views')."/eproc/registration/edit-pass.php";
                                    break;
                                case "lockscr":
                                    require "lock/";
                                    break;

                            //=========================PROJECT MGT============================================
                                case "vuplddrawvdr":
                                    require resource_path('views')."/eproc/project_mgt/view-uploaded-drawing-vendor.php";
                                    break;
                                case "uplddoceng":
                                    require resource_path('views')."/eproc/project_mgt/upload-doc-eng.php";
                                    break;
                                case "vendprojmonitor":
                                    require resource_path('views')."/eproc/project_mgt/dashboard-vendor.php";
                                    break;
                                case "checkvendview":
                                    require resource_path('views')."/eproc/project_mgt/check_doc_vendor_view.php";
                                    break;

                                //=========================PURCHASING PROCESS============================================
                                case "dwldpo" :
                                    require resource_path('views')."/eproc/purchasing_process/download-po-mail.php";
                                    break;

                                case "getpo" :
                                    require resource_path('views')."/eproc/purchasing_process/get-po.php";
                                    break;

                                //============SCHEDULE DELIVERY==========
                                case "dwldmfo" :
                                    require resource_path('views')."/eproc/schedule_delivery/download-manifest.php";
                                    break;

                                case "dwldspo" :
                                    require resource_path('views')."/eproc/schedule_delivery/download-special.php";
                                    break;    

                                case "dashsch" :
                                    require resource_path('views')."/eproc/schedule_delivery/sch-vendor-dashboard.php";
                                    break;

                                case "mfmtr" :
                                    require resource_path('views')."/eproc/schedule_delivery/sch-detail-mat.php";
                                    break;

                                case "mfkbn" :
                                    require resource_path('views')."/eproc/schedule_delivery/sch-detail-kanban.php";
                                    break;
                                    
                                //======================DOC ISO MANAGE===================================    
                                case "dashiso" :
                                    require resource_path('views')."/eproc/doc_iso/dashboard-iso.php";
                                    break;

                                case "mstcert" :
                                    require resource_path('views')."/eproc/doc_iso/mstcert-iso.php";
                                    break; 
                                    
                                case "mstiso" :
                                    require resource_path('views')."/eproc/doc_iso/mstiso-iso.php";
                                    break; 

                                case "mstnotif" :
                                    require resource_path('views')."/eproc/doc_iso/mstnotif-iso.php";
                                    break;      
                                
                                case "regiso" :
                                    require resource_path('views')."/eproc/doc_iso/regiso-iso.php";
                                    break;       

                                case "mstcertedit":
                                    require resource_path('views')."/eproc/doc_iso/edit-mstcert-iso.php";
                                    break;  

                                case "mstisoedit":
                                    require resource_path('views')."/eproc/doc_iso/edit-mstiso-iso.php";
                                    break;   
                                    
                                case "mstnotifedit":
                                    require resource_path('views')."/eproc/doc_iso/edit-mstnotif-iso.php";
                                    break; 
                                
                                case "isoreport":
                                    require resource_path('views')."/eproc/doc_iso/report-iso.php";
                                    break;  
                                
                                case "isorelease":
                                    require resource_path('views')."/eproc/doc_iso/release-iso.php";
                                    break; 
                                
                                case "isorenewal":
                                    require resource_path('views')."/eproc/doc_iso/renewal-iso.php";
                                    break;

                                case "isoreview":
                                    require resource_path('views')."/eproc/doc_iso/review-iso.php";
                                    break;
                                
                                case "isochange":
                                    require resource_path('views')."/eproc/doc_iso/change-iso.php";
                                    break;  
                                    
                                case "isodoctype":
                                    require resource_path('views')."/eproc/doc_iso/report-iso-doc-type.php";
                                    break; 
                                
                                case "isodoctype":
                                    require resource_path('views')."/eproc/doc_iso/report-iso-doc-type.php";
                                    break;

                                case "isodocstat":
                                    require resource_path('views')."/eproc/doc_iso/report-iso-doc-stat.php";
                                    break;

                                default:
                                    require resource_path('views')."/eproc/project_mgt/dashboard-vendor.php";
                            }

                        } elseif(Auth::user()->role=='qa') {

                            switch ($menu) {

                                case "chpwd":
                                    require resource_path('views')."/eproc/registration/edit-pass.php";
                                    break;
                                case "lockscr":
                                    require resource_path('views')."/eproc/lock/";
                                    break;

                            //=========================PROJECT MGT============================================
                                case "vupldeng":
                                    require resource_path('views')."/eproc/project_mgt/view-uploaded-drawing-eng.php";
                                    break;
                                case "checkdocproc":
                                    require resource_path('views')."/eproc/project_mgt/check_doc_vendor_proc.php";
                                    break;
                                case "monitoring":
                                    require resource_path('views')."/eproc/project_mgt/dashboard-monitoring-project.php";
                                    break;


                                default:
                                    require resource_path('views')."/eproc/project_mgt/dashboard-monitoring-project.php";
                            }

                        } elseif(Auth::user()->role=='proc') {

                            switch ($menu) {

                                case "chpwd":
                                    require resource_path('views')."/eproc/registration/edit-pass.php";
                                    break;
                                case "lockscr":
                                    require resource_path('views')."/eproc/lock/";
                                    break;

                                //=========================USER MASTER DATA============================================
                                case "vmaster":
                                    require resource_path('views')."/eproc/registration/vendor-master.php";
                                    break;
                                case "vdrmstdtupld":
                                    require resource_path('views')."/eproc/registration/upload-vendor-master.php";
                                    break;
                                case "vmasteredit":
                                    require resource_path('views')."/eproc/registration/edit-vendor-master.php";
                                    break;
                                case "umaster":
                                    require resource_path('views')."/eproc/registration/user-master.php";
                                    break;
                                case "umasteredit":
                                    require resource_path('views')."/eproc/registration/edit-user-master.php";
                                    break;
                                case "usermstrupld":
                                    require resource_path('views')."/eproc/registration/upload-user-master.php";
                                    break;

                                //=========================PROJECT MGT============================================

                                case "docforpart":
                                    require resource_path('views')."/eproc/project_mgt/doc-for-part.php";
                                    break;
                                case "listcheckmaster":
                                    require resource_path('views')."/eproc/project_mgt/doc-check-list-master.php";
                                    break;
                                case "listcheckedit":
                                    require resource_path('views')."/eproc/project_mgt/edit-doc-list-check.php";
                                    break;
                                case "asslistcheckdoc":
                                    require resource_path('views')."/eproc/project_mgt/doc-check-list.php";
                                    break;
                                case "addlistcheckdoc":
                                    require resource_path('views')."/eproc/project_mgt/add-doc-check-list.php";
                                    break;
                                    case "vuplddraw":
                                    require resource_path('views')."/eproc/project_mgt/view-uploaded-drawing.php";
                                    break;
                                case "vassign":
                                    require resource_path('views')."/eproc/project_mgt/assign-vendor.php";
                                    break;
                                case "vupldeng":
                                    require resource_path('views')."/eproc/project_mgt/view-uploaded-drawing-eng.php";
                                    break;
                                case "monitoring":
                                    require resource_path('views')."/eproc/project_mgt/dashboard-monitoring-project.php";
                                    break;
                                case "checkdoc":
                                    require resource_path('views')."/eproc/project_mgt/check_doc.php";
                                    break;
                                case "checkdocproc":
                                    require resource_path('views')."/eproc/project_mgt/check_doc_vendor_proc.php";
                                    break;

                                //=========================PURCHASING PROCESS============================================
                                case "uplaprvpo" :
                                    require resource_path('views')."/eproc/purchasing_process/po-approve-upload.php";
                                    break;

                                case "batchpo" :
                                    require resource_path('views')."/eproc/purchasing_process/po-batch-mail.php";
                                    break;

                                case "dlistpo" :
                                    require resource_path('views')."/eproc/purchasing_process/po-list-master.php";
                                    break;

                                case "dwldpo" :
                                    require resource_path('views')."/eproc/purchasing_process/download-po-mail.php";
                                    break;

                                case "getpo" :
                                    require resource_path('views')."/eproc/purchasing_process/get-po.php";
                                    break;

                                //============SCHEDULE DELIVERY========== add by HOS 30.07.2020
                                case "dwldmfo" :
                                    require resource_path('views')."/eproc/schedule_delivery/download-manifest.php";
                                    break;

                                case "dwldspo" :
                                    require resource_path('views')."/eproc/schedule_delivery/download-special.php";
                                    break;    

                                case "dashsch" :
                                    require resource_path('views')."/eproc/schedule_delivery/sch-vendor-dashboard.php";
                                    break;

                                case "mfmtr" :
                                    require resource_path('views')."/eproc/schedule_delivery/sch-detail-mat.php";
                                    break;

                                case "mfkbn" :
                                    require resource_path('views')."/eproc/schedule_delivery/sch-detail-kanban.php";
                                    break;
                                
                                //======================DOC ISO MANAGE===================================    
                                case "dashiso" :
                                    require "doc_iso/dashboard-iso.php";
                                    break;

                                case "mstcert" :
                                    require "doc_iso/mstcert-iso.php";
                                    break; 
                                    
                                case "mstiso" :
                                    require "doc_iso/mstiso-iso.php";
                                    break; 

                                case "mstnotif" :
                                    require "doc_iso/mstnotif-iso.php";
                                    break;      
                                
                                case "regiso" :
                                    require "doc_iso/regiso-iso.php";
                                    break;       

                                case "mstcertedit":
                                    require "doc_iso/edit-mstcert-iso.php";
                                    break;  

                                case "mstisoedit":
                                    require "doc_iso/edit-mstiso-iso.php";
                                    break;   
                                    
                                case "mstnotifedit":
                                    require "doc_iso/edit-mstnotif-iso.php";
                                    break; 
                                
                                case "isoreport":
                                    require "doc_iso/report-iso.php";
                                    break;  
                                
                                case "isorelease":
                                    require "doc_iso/release-iso.php";
                                    break; 
                                
                                case "isorenewal":
                                    require "doc_iso/renewal-iso.php";
                                    break;

                                case "isoreview":
                                    require "doc_iso/review-iso.php";
                                    break;
                                
                                case "isochange":
                                    require "doc_iso/change-iso.php";
                                    break;    
                                
                                case "isodoctype":
                                    require "doc_iso/report-iso-doc-type.php";
                                    break;

                                case "isodocstat":
                                    require "doc_iso/report-iso-doc-stat.php";
                                    break;
                                
                                default:
                                    require "project_mgt/dashboard-monitoring-project.php";
                            }
                        } elseif(Auth::user()->role=='eng') {

                            switch ($menu) {

                                case "chpwd":
                                    require "registration/edit-pass.php";
                                    break;
                                case "lockscr":
                                    require "lock/";
                                    break;

                            //=========================PROJECT MGT============================================
                                case "projmaster":
                                    require "project_mgt/project-master.php";
                                    break;
                                case "projectmasteredit":
                                    require "project_mgt/edit-project-master.php";
                                    break;
                                    case "projectass":
                                    require "project_mgt/project-assignment.php";
                                    break;
                                case "prodmaster":
                                    require "project_mgt/product-master.php";
                                    break;
                                case "prodmasteredit":
                                    require "project_mgt/edit-product-master.php";
                                    break;
                                case "partmaster":
                                    require "project_mgt/part-master.php";
                                    break;
                                case "partmasteredit":
                                    require "project_mgt/edit-part-master.php";
                                    break;
                                case "docmaster":
                                    require "project_mgt/doc-master.php";
                                    break;
                                case "docmasteredit":
                                    require "project_mgt/edit-doc-master.php";
                                    break;
                                case "docforpart":
                                    require "project_mgt/doc-for-part.php";
                                    break;
                                case "partforprod":
                                    require "project_mgt/part-for-product.php";
                                    break;
                                case "partforprodedit":
                                    require "project_mgt/edit-part-for-product.php";
                                    break;
                                case "uplddraw":
                                    require "project_mgt/upload-drawing.php";
                                    break;
                                case "checkdoceng":
                                    require "project_mgt/check_doc_eng.php";
                                    break;

                                default:
                                    require "project_mgt/upload-drawing.php";
                            }
                        }

                    ?>
                    
                </div>
            </div>

        </section><!-- /.content -->


    </aside><!-- /.right-side -->

</div><!-- ./wrapper -->

@endsection
