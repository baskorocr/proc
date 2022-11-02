<?php
session_start();
//error_reporting(0);
include "lib/timeout.php";
if($_SESSION['login']==1){
    if(!cek_login()){
        $_SESSION['login'] = 0;
    }
}
if($_SESSION['login']==0){
    //header('location:logout.php');
    header('location:lock/');
}else{
    if (empty($_SESSION['role'])){
        echo"
        <p align=center><h1>You have no authorized to access the content.</h1></p>
        <a href=login.php><button>Please use your login access</button></a></center>";
    }else{   

?>

<!-- Copyright &copy; 2014-2016 <a href="https://adminlte.io">Almsaeed Studio -->

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>eProc Dharma Polimetal</title>
        <link rel="icon" type="image/x-icon" href="../img/favicon3.png" />
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

        <!-- bootstrap 3.0.2 -->
        <link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="../css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="../css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <!-- Morris chart -->
        <!--
        <link href="../css/morris/morris.css" rel="stylesheet" type="text/css" />
        -->
        <!-- jvectormap -->
        <link href="../css/jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
        <!-- fullCalendar -->
        <link href="../css/fullcalendar/fullcalendar.css" rel="stylesheet" type="text/css" />
        <!-- Daterange picker -->
        <link href="../css/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
        <!-- bootstrap wysihtml5 - text editor -->
        <!--
        <link href="../css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" />
        -->
        <!-- Theme style -->
        <link href="../css/AdminLTE.css" rel="stylesheet" type="text/css" />
        <!-- DATA TABLES -->
            
        <link href="../css/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />

        <!--
        <link href="../css/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
        -->
        <link href="../css/datatables/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
        

        <link rel="stylesheet" href="../select/dist/css/bootstrap-select.css">
        
		<!--
        <link href="../css/footable/css/footable.bootstrap.min.css" rel="stylesheet" type="text/css" />
		-->

        <!-- sweet alert -->
        <link href="../css/sweet-alert.css" rel="stylesheet" type="text/css" />
        <script src="../js/sweet-alert/sweetalert.min.js" type="text/javascript"></script>

        <link rel="stylesheet" href="../footable/plugin/css/footable.bootstrap.min.css">

        <!--
        <script src="../js/plugins/datepicker/bootstrap-datepicker.js"></script>
        -->
        <link rel="stylesheet" href="../css/datepicker/datepicker.css">
		
    </head>

    <body  class="skin-black">

    <!--
	<script type="text/javascript" src="//localhost:7777/php-live-support-chat/livechat/php/app.php?widget-init.js"></script>
	-->
       
       <!-- MENU CONTROL
            #MENU TOP
            #MENU SIDE
        -->
       <!--
        <script>
            swal({
                title: 'Auto close alert!',
                text: 'I will close in 5 seconds.',
                timer: 5000,
                customClass: 'swal-wide',
                allowOutsideClick: false,
                onOpen: function () {
                    swal.showLoading()
                }
            }).then(
                function () {},
                // handling the promise rejection
                function (dismiss) {
                    if (dismiss === 'timer') {
                        window.location = ('../view/home.php?mnu=projmaster');
                    }
                }
            )
        </script>
        -->

        <?php include "menu/top-menu.php";?>
        <?php include "menu/side-menu.php";?>

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">

                <!-- Main content -->
                <section class="content">

                    <div class="box">
                        <div class="box-body">

                            <?php

                                //ROLE ADMIN
                                $menu = $_GET['mnu'];
                                if($_SESSION['role']=='admin'){
                                    
                                    switch ($menu) {
                                        //=========================USER LOG====================================================
                                        case "usrlog":
                                            require "registration/user-log.php";
                                            break;

                                        case "srvlog":
                                            require "other/service-log.php";
                                            break;  
                                            
                                        case "mnumaster":
                                            require "registration/menu-master.php";
                                            break;  

                                        case "menuedit":
                                            require "registration/edit-menu-master.php";
                                            break;

                                        case "mnugroup":
                                            require "registration/menu-group-master.php";
                                            break; 
                                            
                                        case "mnugroupedit":
                                            require "registration/edit-menu-group.php";
                                            break;

                                        case "accgrmaster":
                                            require "registration/access-group-master.php";
                                            break; 
                                            
                                        case "accgroupedit":
                                            require "registration/edit-access-group.php";
                                            break;    
     
                                        //=========================USER MASTER DATA============================================
                                        case "vmaster":
                                            require "registration/vendor-master.php";
                                            break;
                                        case "vdrmstdtupld":
                                            require "registration/upload-vendor-master.php";
                                            break;
                                        case "vmasteredit":
                                            require "registration/edit-vendor-master.php";
                                            break;
                                        case "umaster":
                                            require "registration/user-master.php";
                                            break;
                                        case "umasteredit":
                                            require "registration/edit-user-master.php";
                                            break;
                                        case "usermstrupld":
                                           require "registration/upload-user-master.php";
                                           break;
                                        case "chpwd":
                                           require "registration/edit-pass.php";
                                           break;
                                        case "pdaccs":
                                           require "registration/pda-master.php";
                                           break;   
                                        case "pdamasteredit":
                                           require "registration/edit-pda-master.php";
                                           break; 
										case "vdremailupdate":
                                           require "registration/update-user-email.php";
                                           break; 
                                        case "emailgrp":
                                            require "registration/email-group-master.php";
                                            break; 
                                        case "emailgrpedit":
                                            require "registration/edit-email-group.php";
                                            break; 
                                        case "emailgrlist":
                                            require "registration/email-group-list.php";
                                            break; 
                                        case "emailgrlistedit":
                                            require "registration/edit-email-list-group.php";
                                            break;                                  
                                        case "numrange":
                                            require "registration/number-range.php";
                                            break; 
                                        case "numrangeedit":
                                            require "registration/edit-number-range.php";
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
                                        case "newass":
                                            require "project_mgt/assignment-new.php";
                                            break;
                                        case "crproj":
                                            require "project_mgt/assignment-create.php";
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
                                        case "partforprod":
                                            require "project_mgt/part-for-product.php";
                                            break;
                                        case "partforprodedit":
                                            require "project_mgt/edit-part-for-product.php";
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
                                        case "listcheckmaster":
                                            require "project_mgt/doc-check-list-master.php";
                                            break;
                                        case "asslistcheckdoc":
                                            require "project_mgt/doc-check-list.php";
                                            break;
                                        case "addlistcheckdoc":
                                            require "project_mgt/add-doc-check-list.php";
                                            break;
                                        case "listcheckedit":
                                            require "project_mgt/edit-doc-list-check.php";
                                            break;
                                        case "uplddraw":
                                            require "project_mgt/upload-drawing.php";
                                            break;
                                        case "vuplddraw":
                                            require "project_mgt/view-uploaded-drawing.php";
                                            break;
                                        case "vassign":
                                            require "project_mgt/assign-vendor.php";
                                            break;
                                        case "vuplddrawvdr":
                                            require "project_mgt/view-uploaded-drawing-vendor.php";
                                            break;
                                        case "uplddoceng":
                                            require "project_mgt/upload-doc-eng.php";
                                            break;
                                        case "vupldeng":
                                            require "project_mgt/view-uploaded-drawing-eng.php";
                                            break;
                                        case "monitoring":
                                            require "project_mgt/dashboard-monitoring-project.php";
                                            break;
                                        case "checkdoc":
                                            require "project_mgt/check_doc.php";
                                            break;
                                        case "checkdoceng":
                                            require "project_mgt/check_doc_eng.php";
                                            break;
                                        case "checkdocproc":
                                            require "project_mgt/check_doc_vendor_proc.php";
                                            break;
                                        case "checkvendview":
                                            require "project_mgt/check_doc_vendor_view.php";
                                            break;
                                        case "vendprojmonitor":
                                            require "project_mgt/dashboard-vendor.php";
                                            break;
                                        case "flmstr":
                                            require "project_mgt/files-in-directory.php";
                                            break;
                                            

                                        //========= SCHCEDULE DELIVERY ========
                                        case "schmasterupl" :
                                            require "schedule_delivery/sch-master-upload.php";
                                            break;

                                        case "schmasteradd" :
                                            require "schedule_delivery/sch-master-additional.php";
                                            break;

                                        case "schmastersct" :
                                            require "schedule_delivery/sch-master-select.php";
                                            break;

                                        case "schmasterview" :
                                            require "schedule_delivery/sch-master-output.php";
                                            break;

                                        case "schmastervend" :
                                            require "schedule_delivery/sch-master-vendor.php";
                                            break;

                                        case "schmasterfix" :
                                            require "schedule_delivery/sch-master-fix.php";
                                            break;

                                        case "gdrcpt" :
                                            require "schedule_delivery/good-receipt.php";
                                            break;

                                        case "schvdrview" :
                                            require "schedule_delivery/sch-vendor-output.php";
                                            break;

                                        case "schplanact" :
                                            require "schedule_delivery/sch-plan-act.php";
                                            break;

                                        case "schplanactview" :
                                            require "schedule_delivery/sch-plan-act-output.php";
                                            break;

                                        case "rawstckupl" :
                                            require "schedule_delivery/raw-stock-upload.php";
                                            break;

                                        case "matstckupl" :
                                            require "schedule_delivery/mat-stock-upload.php";
                                            break;

                                        case "dwldmfo" :
                                            require "schedule_delivery/download-manifest.php";
                                            break;
                                        
                                        case "dwldspo" :
                                            require "schedule_delivery/download-special.php";
                                            break;    

                                        case "dashsch" :
                                            require "schedule_delivery/sch-vendor-dashboard.php";
                                            break;

                                        case "mfmtr" :
                                            require "schedule_delivery/sch-detail-mat.php";
                                            break;

                                        case "mfkbn" :
                                            require "schedule_delivery/sch-detail-kanban.php";
                                            break;

                                        //=========================PURCHASING PROCESS============================================

                                        case "uplaprvpo" :
                                            require "purchasing_process/po-approve-upload.php";
                                            break;

                                        case "batchpo" :
                                            require "purchasing_process/po-batch-mail.php";
                                            break;

                                        case "dlistpo" :
                                            require "purchasing_process/po-list-master.php";
                                            break;

                                        case "dwldpo" :
                                            require "purchasing_process/download-po-mail.php";
                                            break;

                                        case "getpo" :
                                            require "purchasing_process/get-po.php";
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

                                        //=========================DEFAULT PAGE============================================
                                        default:
                                            require "project_mgt/dashboard-monitoring-project.php";
                                    }

                                // ROLE VENDOR
                                } elseif($_SESSION['role']=='vendor') {

                                    switch ($menu) {

                                        case "chpwd":
                                           require "registration/edit-pass.php";
                                           break;
                                        case "lockscr":
                                            require "lock/";
                                            break;

                                    //=========================PROJECT MGT============================================
                                        case "vuplddrawvdr":
                                            require "project_mgt/view-uploaded-drawing-vendor.php";
                                            break;
                                        case "uplddoceng":
                                            require "project_mgt/upload-doc-eng.php";
                                            break;
                                        case "vendprojmonitor":
                                            require "project_mgt/dashboard-vendor.php";
                                            break;
                                        case "checkvendview":
                                            require "project_mgt/check_doc_vendor_view.php";
                                            break;

                                        //=========================PURCHASING PROCESS============================================
                                        case "dwldpo" :
                                            require "purchasing_process/download-po-mail.php";
                                            break;

                                        case "getpo" :
                                            require "purchasing_process/get-po.php";
                                            break;

                                        //============SCHEDULE DELIVERY==========
                                        case "dwldmfo" :
                                            require "schedule_delivery/download-manifest.php";
                                            break;

                                        case "dwldspo" :
                                            require "schedule_delivery/download-special.php";
                                            break;    

                                        case "dashsch" :
                                            require "schedule_delivery/sch-vendor-dashboard.php";
                                            break;

                                        case "mfmtr" :
                                            require "schedule_delivery/sch-detail-mat.php";
                                            break;

                                        case "mfkbn" :
                                            require "schedule_delivery/sch-detail-kanban.php";
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
                                        
                                        case "isodoctype":
                                            require "doc_iso/report-iso-doc-type.php";
                                            break;

                                        case "isodocstat":
                                            require "doc_iso/report-iso-doc-stat.php";
                                            break;

                                        default:
                                            require "project_mgt/dashboard-vendor.php";
                                    }

                                } elseif($_SESSION['role']=='qa') {

                                    switch ($menu) {

                                        case "chpwd":
                                           require "registration/edit-pass.php";
                                           break;
                                        case "lockscr":
                                            require "lock/";
                                            break;

                                    //=========================PROJECT MGT============================================
                                        case "vupldeng":
                                            require "project_mgt/view-uploaded-drawing-eng.php";
                                            break;
                                        case "checkdocproc":
                                            require "project_mgt/check_doc_vendor_proc.php";
                                            break;
                                        case "monitoring":
                                            require "project_mgt/dashboard-monitoring-project.php";
                                            break;


                                        default:
                                            require "project_mgt/dashboard-monitoring-project.php";
                                    }

                                } elseif($_SESSION['role']=='proc') {

                                    switch ($menu) {

                                        case "chpwd":
                                           require "registration/edit-pass.php";
                                           break;
                                        case "lockscr":
                                            require "lock/";
                                            break;

                                        //=========================USER MASTER DATA============================================
                                        case "vmaster":
                                            require "registration/vendor-master.php";
                                            break;
                                        case "vdrmstdtupld":
                                            require "registration/upload-vendor-master.php";
                                            break;
                                        case "vmasteredit":
                                            require "registration/edit-vendor-master.php";
                                            break;
                                        case "umaster":
                                            require "registration/user-master.php";
                                            break;
                                        case "umasteredit":
                                            require "registration/edit-user-master.php";
                                            break;
                                        case "usermstrupld":
                                           require "registration/upload-user-master.php";
                                           break;

                                        //=========================PROJECT MGT============================================

                                        case "docforpart":
                                            require "project_mgt/doc-for-part.php";
                                            break;
                                        case "listcheckmaster":
                                            require "project_mgt/doc-check-list-master.php";
                                            break;
                                        case "listcheckedit":
                                            require "project_mgt/edit-doc-list-check.php";
                                            break;
                                        case "asslistcheckdoc":
                                            require "project_mgt/doc-check-list.php";
                                            break;
                                        case "addlistcheckdoc":
                                            require "project_mgt/add-doc-check-list.php";
                                            break;
                                         case "vuplddraw":
                                            require "project_mgt/view-uploaded-drawing.php";
                                            break;
                                        case "vassign":
                                            require "project_mgt/assign-vendor.php";
                                            break;
                                        case "vupldeng":
                                            require "project_mgt/view-uploaded-drawing-eng.php";
                                            break;
                                        case "monitoring":
                                            require "project_mgt/dashboard-monitoring-project.php";
                                            break;
                                        case "checkdoc":
                                            require "project_mgt/check_doc.php";
                                            break;
                                        case "checkdocproc":
                                            require "project_mgt/check_doc_vendor_proc.php";
                                            break;

                                        //=========================PURCHASING PROCESS============================================
                                        case "uplaprvpo" :
                                            require "purchasing_process/po-approve-upload.php";
                                            break;

                                        case "batchpo" :
                                            require "purchasing_process/po-batch-mail.php";
                                            break;

                                        case "dlistpo" :
                                            require "purchasing_process/po-list-master.php";
                                            break;

                                        case "dwldpo" :
                                            require "purchasing_process/download-po-mail.php";
                                            break;

                                        case "getpo" :
                                            require "purchasing_process/get-po.php";
                                            break;

										//============SCHEDULE DELIVERY========== add by HOS 30.07.2020
                                        case "dwldmfo" :
                                            require "schedule_delivery/download-manifest.php";
                                            break;

                                        case "dwldspo" :
                                            require "schedule_delivery/download-special.php";
                                            break;    

                                        case "dashsch" :
                                            require "schedule_delivery/sch-vendor-dashboard.php";
                                            break;

                                        case "mfmtr" :
                                            require "schedule_delivery/sch-detail-mat.php";
                                            break;

                                        case "mfkbn" :
                                            require "schedule_delivery/sch-detail-kanban.php";
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
                                } elseif($_SESSION['role']=='eng') {

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

        <!-- jQuery 2.0.2 
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
		-->

        <script src="../ajax/ajax-jquery.min.js"></script>

		<script src="../jquery-2/jquery.min.js"></script>
		
        <!-- jQuery UI 1.10.3 -->
        <script src="../js/jquery-ui-1.10.3.min.js" type="text/javascript"></script>
        
		<!-- Bootstrap -->
        <script src="../js/bootstrap.min.js" type="text/javascript"></script>
		
		<!-- AdminLTE App -->
		<script src="../js/AdminLTE/app.js" type="text/javascript"></script>
		
        <!-- Morris.js charts 
        <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
		-->
       <!--
		<script src="../css/raphael/raphael-min.js"></script>
        <script src="../js/plugins/morris/morris.min.js" type="text/javascript"></script>
        -->
        <!-- Sparkline -->
        <script src="../js/plugins/sparkline/jquery.sparkline.min.js" type="text/javascript"></script>
        <!-- jvectormap -->
        <script src="../js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js" type="text/javascript"></script>
        <script src="../js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script>
        <!-- fullCalendar -->
        <script src="../js/plugins/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
        <!-- jQuery Knob Chart -->
        <script src="../js/plugins/jqueryKnob/jquery.knob.js" type="text/javascript"></script>
        <!-- daterangepicker -->
        <script src="../js/plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
        <!-- Bootstrap WYSIHTML5 -->
       <!--
        <script src="../js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
        -->
        <!-- iCheck -->
       <!--
        <script src="../js/plugins/iCheck/icheck.min.js" type="text/javascript"></script>
        -->

        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
       <!--
        <script src="../js/AdminLTE/dashboard.js" type="text/javascript"></script>
        -->

        <!-- Bootstrap -->
		
        <script src="../js/bootstrap.min.js" type="text/javascript"></script>
		
		
		<!-- DATA TABLES SCRIPT -->
        <script src="../js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
        <script src="../js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>

       <script src="../js/plugins/datatables/addon/dataTables.buttons.min.js" type="text/javascript"></script>
       <script src="../js/plugins/datatables/addon/buttons.flash.min.js" type="text/javascript"></script>
       <script src="../js/plugins/datatables/addon/jszip.min.js" type="text/javascript"></script>
       <script src="../js/plugins/datatables/addon/pdfmake.min.js" type="text/javascript"></script>
       <script src="../js/plugins/datatables/addon/vfs_fonts.js" type="text/javascript"></script>
       <script src="../js/plugins/datatables/addon/buttons.html5.min.js" type="text/javascript"></script>
       <script src="../js/plugins/datatables/addon/buttons.print.min.js" type="text/javascript"></script>
       
       <script src="../js/plugins/input-mask/jquery.inputmask.js" type="text/javascript"></script>
       <script src="../js/plugins/input-mask/jquery.inputmask.date.extensions.js" type="text/javascript"></script>
       <script src="../js/plugins/input-mask/jquery.inputmask.extensions.js" type="text/javascript"></script>

       <script src="../footable/plugin/js/footable.min.js"></script>

		<!--
       <script src="../css/footable/js/footable.min.js" type="text/javascript"></script>
	   -->


        <script type="text/javascript">
            inactivityTimeout = false;
            resetTimeout();
            function onUserInactivity() {
               window.location.href = "lock/";
            }

            function resetTimeout() {
               clearTimeout(inactivityTimeout);
               inactivityTimeout = setTimeout(onUserInactivity, 1000 * 3600); //60 minutes
            }

            window.onmousemove = resetTimeout;
            window.onkeypress  = resetTimeout;
        </script>

        <!-- Page script -->
        <script type="text/javascript">
            $(function() {
                //Datemask dd/mm/yyyy
                $("#datemask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
                //Datemask2 mm/dd/yyyy
                $("#datemask2").inputmask("mm.dd.yyyy", {"placeholder": "mm.dd.yyyy"});
                //Money Euro
                $("[data-mask]").inputmask();

                //Date range picker
                $('#reservation').daterangepicker();
                //Date range picker with time picker
                $('#reservationtime').daterangepicker({timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm A'});
                //Date range as a button
                $('#daterange-btn').daterangepicker(
                        {
                            ranges: {
                                'Today': [moment(), moment()],
                                'Yesterday': [moment().subtract('days', 1), moment().subtract('days', 1)],
                                'Last 7 Days': [moment().subtract('days', 6), moment()],
                                'Last 30 Days': [moment().subtract('days', 29), moment()],
                                'This Month': [moment().startOf('month'), moment().endOf('month')],
                                'Last Month': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
                            },
                            startDate: moment().subtract('days', 29),
                            endDate: moment()
                        },
                function(start, end) {
                    $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                }
                );

                //datepicker
   
                //$('.datepicker').datepicker();

                //iCheck for checkbox and radio inputs
                $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
                    checkboxClass: 'icheckbox_minimal',
                    radioClass: 'iradio_minimal'
                });
                //Red color scheme for iCheck
                $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
                    checkboxClass: 'icheckbox_minimal-red',
                    radioClass: 'iradio_minimal-red'
                });
                //Flat red color scheme for iCheck
                $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
                    checkboxClass: 'icheckbox_flat-red',
                    radioClass: 'iradio_flat-red'
                });

                //Colorpicker
                $(".my-colorpicker1").colorpicker();
                //color picker with addon
                $(".my-colorpicker2").colorpicker();

                //Timepicker
                $(".timepicker").timepicker({
                    showInputs: false
                });
            });

             //Date Picker
    

        </script>


    </body>
</html>

<?php

    }//}else{  

}//if($_SESSION['login']==0)
?>