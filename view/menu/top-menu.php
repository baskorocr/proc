 <!-- header logo: style can be found in header.less -->
<?php

    /*
    include_once "../conn/conn.php";
    include_once "../project_mgt/project-mgt-query.php";
    */

?>
<!-- bootstrap 3.0.2 -->
        <meta charset="UTF-8">
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="../css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="../css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <!-- Morris chart -->
        <link href="../css/morris/morris.css" rel="stylesheet" type="text/css" />
        <!-- jvectormap -->
        <link href="../css/jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
        <!-- fullCalendar -->
        <link href="../css/fullcalendar/fullcalendar.css" rel="stylesheet" type="text/css" />
        <!-- Daterange picker -->
        <link href="../css/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
        <!-- bootstrap wysihtml5 - text editor -->
        <link href="../css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="../css/AdminLTE.css" rel="stylesheet" type="text/css" />
         <!-- DATA TABLES -->
        <link href="../css/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />

        <link rel="stylesheet" href="../select/dist/css/bootstrap-select.css">

<?php
    
    include "menu-query.php";
    require "lib/ip-detect.php";
    include "function-menu.php";

    $ip         = ip_detect();
    //$ip         = public_ip();
    $mac        = mac_detect(); 

    $id_user = $_SESSION['id_user'];

    $query = get_vendor_user2($id_user);
    //$row = mysql_fetch_assoc($query);
    $row = mysqli_fetch_assoc($query);
    $id_vendor_master  = isset($row['id_vendor'])? $row['id_vendor']:"";
?>

<body class="skin-black">
    <header class="header">

    <a href="home.php" class="logo">
        <!-- Add the class icon to your logo image or logo icon to add the margining -->
        <font face="verdana" color="#fff"><b>e</b>Proc</font>
    </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <div class="navbar-right">
                    <ul class="nav navbar-nav">
                        
                    <?php 
                        $count_data = 0;
                        if ($_SESSION['role'] == "eng") {

                            $row_data = array();
                            $query_exec2 = get_assigned_project_data_all();           
                            //while($row2 = mysql_fetch_assoc($query_exec2)){
                            while($row2 = mysqli_fetch_assoc($query_exec2)){
                                $id_project = $row2['id_project'];
                                $nm_project = $row2['nm_project'];

                                $query_exec3 = get_proj_doc_assign_data_menu($id_project);
                                //$row3 = mysql_fetch_assoc($query_exec3);
                                $row3 = mysqli_fetch_assoc($query_exec3);

                                $query_exec4 = get_proj_doc_assign_data_status_menu($id_project);
                                //$row4 = mysql_fetch_assoc($query_exec4);
                                $row4 = mysqli_fetch_assoc($query_exec4);

                                //$count_row3 = mysql_num_rows($query_exec3);
                                $count_row3 = mysqli_num_rows($query_exec3);
                                $sum_check = $row4['check_status'];

                                if ($count_row3 != $sum_check OR ($count_row3 == 0 AND $sum_check == 0)) {
                                    array_push($row_data, $id_project);
                                }
                            }

                            $count_data = count($row_data);
                          
                        }// if ($_SESSION['role'] == "eng") 

                        elseif ($_SESSION['role'] == "proc") {
        
                            $row_data = array();
                            $query_exec2 = get_assigned_project_data_all();           
                            //while($row2 = mysql_fetch_assoc($query_exec2)){
                            while($row2 = mysqli_fetch_assoc($query_exec2)){
                                $id_project = $row2['id_project'];
                                $nm_project = $row2['nm_project'];

                                $query_exec3 = get_proj_doc_assign_data_menu($id_project);
                                //$row3 = mysql_fetch_assoc($query_exec3);
                                $row3 = mysqli_fetch_assoc($query_exec3);

                                $query_exec4 = get_proj_doc_assign_data_status_menu($id_project);
                                //$row4 = mysql_fetch_assoc($query_exec4);
                                $row4 = mysqli_fetch_assoc($query_exec4);

                                //$count_row3 = mysql_num_rows($query_exec3);
                                $count_row3 = mysqli_num_rows($query_exec3);
                                $sum_check = $row4['check_status'];

                                if ($count_row3 != $sum_check) {
                                    array_push($row_data, $id_project);
                                }
                            }

                            $query_exec2_1 = get_assigned_project_data_all2();           
                            //while($row2_1 = mysql_fetch_assoc($query_exec2_1)){
                            while($row2_1 = mysqli_fetch_assoc($query_exec2_1)){
                                $id_project2 = $row2_1['id_project'];
                                $nm_project2 = $row2_1['nm_project'];
                                $id_vendor2  = $row2_1['id_vendor'];
                                $nm_vendor2  = $row2_1['nm_vendor']; 
                                $allias2     = $row2_1['allias'];

                                $query_exec3_1 = get_proj_doc_assign_data_menu2($id_project2, $id_vendor2);
                                //$row3_1 = mysql_fetch_assoc($query_exec3_1);
                                $row3_1 = mysqli_fetch_assoc($query_exec3_1);

                                $query_exec4_1 = get_proj_doc_assign_data_status_menu2($id_project2, $id_vendor2);
                                //$row4_1 = mysql_fetch_assoc($query_exec4_1);
                                $row4_1 = mysqli_fetch_assoc($query_exec4_1);

                                //$count_row3_1 = mysql_num_rows($query_exec3_1);
                                $count_row3_1 = mysqli_num_rows($query_exec3_1);
                                $sum_check_1 = $row4_1['check_status'];

                                if ($count_row3_1 != $sum_check_1) {
                                    array_push($row_data, $id_project2);
                                }
                            }

                            $count_data = count($row_data);

                        }  //elseif ($_SESSION['role'] == "proc")

                        elseif ($_SESSION['role'] == "vendor") {

                            $row_data = array();
                            $query_exec2 = get_assigned_project_data_all_vendor($id_vendor_master);           
                            //while($row2 = mysql_fetch_assoc($query_exec2)){
                            while($row2 = mysqli_fetch_assoc($query_exec2)){
                                $id_project = $row2['id_project'];
                                $nm_project = $row2['nm_project'];

                                $query_exec3 =  get_proj_doc_assign_data_menu3($id_project, $id_vendor_master);
                                //$row3 = mysql_fetch_assoc($query_exec3);
                                $row3 = mysqli_fetch_assoc($query_exec3);

                                $query_exec4 = get_proj_doc_upload_data_status_menu3($id_project, $id_vendor_master);
                                //$row4 = mysql_fetch_assoc($query_exec4);
                                $row4 = mysqli_fetch_assoc($query_exec4);

                                /* $count_row3 = mysql_num_rows($query_exec3);
                                $sum_check = mysql_num_rows($query_exec4); */
								$count_row3 = mysqli_num_rows($query_exec3);
                                $sum_check = mysqli_num_rows($query_exec4);

                                if ($count_row3 != $sum_check OR ($count_row3 == 0 AND $sum_check == 0)) {
                                    array_push($row_data, $id_project);
                                }

                            $count_data = count($row_data);
                            }

                        }// if ($_SESSION['role'] == "vendor")

                        elseif ($_SESSION['role'] == "qa") {

                            $row_data = array();
                            $query_exec3_1 = get_assigned_project_data_all2();
                            //while($row3_1 = mysql_fetch_assoc($query_exec3_1)){
                            while($row3_1 = mysqli_fetch_assoc($query_exec3_1)){
                                $id_project3 = $row3_1['id_project'];
                                $nm_project3 = $row3_1['nm_project'];
                                $id_vendor3  = $row3_1['id_vendor'];
                                $nm_vendor3  = $row3_1['nm_vendor'];
                                $allias3     = $row3_1['allias'];

                                $query_exec3_2 = get_proj_doc_assign_data_menu2($id_project3, $id_vendor3);
                                //$row3_2 = mysql_fetch_assoc($query_exec3_2);
                                $row3_2 = mysqli_fetch_assoc($query_exec3_2);

                                $query_exec4_2 = get_proj_doc_assign_data_status_menu3($id_project3, $id_vendor3);
                                //$row4_2 = mysql_fetch_assoc($query_exec4_2);
                                $row4_2 = mysqli_fetch_assoc($query_exec4_2);

                                //$count_row3_2 = mysql_num_rows($query_exec3_2);
                                $count_row3_2 = mysqli_num_rows($query_exec3_2);
                                $sum_check_2 = $row4_2['check_status_b'];

                                if ($count_row3_2 != $sum_check_2) {
                                    array_push($row_data, $id_project3);
                                }
                            }

                            $count_data = count($row_data);

                        }// elseif ($_SESSION['role'] == "qa")

                        if ($count_data == 0) {
                            $task_msg = "You have no task";
                        } elseif ($count_data > 0){
                            $task_msg = "You have $count_data task(s)";
                        }
                        
                    ?>
                        <li class="dropdown tasks-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-tasks"></i>
                                <span class="label label-danger"><?php echo $count_data; ?></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header"><?php echo $task_msg; ?></li>

                                <li>
                                    <ul class="menu">

                            <?php 

                                if ($_SESSION['role'] == "eng") {
                                        
                                         echo " <li style='color: #001f3f'>
                                                    <strong>
                                                        <center><small>Document Upload (Eng) </small></center>
                                                    </strong>
                                                </li>
                                                <hr style='margin-top: 1px; margin-bottom: -2px; '>
                                                ";

                                        $no = 1;
                                        $query_exec2 = get_assigned_project_data_all();           
                                        //while($row2 = mysql_fetch_assoc($query_exec2)){
                                        while($row2 = mysqli_fetch_assoc($query_exec2)){
                                            $id_project = $row2['id_project'];
                                            $nm_project = $row2['nm_project'];

                                            $query_exec3 = get_proj_doc_assign_data_menu($id_project);
                                            //$row3 = mysql_fetch_assoc($query_exec3);
                                            $row3 = mysqli_fetch_assoc($query_exec3);

                                            $query_exec4 = get_proj_doc_assign_data_status_menu($id_project);
                                            //$row4 = mysql_fetch_assoc($query_exec4);
                                            $row4 = mysqli_fetch_assoc($query_exec4);

                                            //$count_row3 = mysql_num_rows($query_exec3);
                                            $count_row3 = mysqli_num_rows($query_exec3);
                                            $sum_check = $row4['check_status'];

                                            if ($count_row3 != $sum_check OR ($count_row3 == 0 AND $sum_check == 0) ) {
                                                if ($count_row3 == $sum_check AND ($sum_check != "" AND $count_row3 != "") ){
                                                    $stat_check =  "<span class='badge bg-green'>Completed ($sum_check/$count_row3)</span>";
                                                } elseif ($count_row3 != $sum_check AND ($count_row3 != 0 OR $sum_check != 0)) {
                                                    $stat_check =  "<span class='badge bg-yellow'>Uncompleted </span>";
                                                } else {
                                                    $sum_check = 0;
                                                    $stat_check =  "<span class='badge bg-red'>No upload </span>";
                                                }
                                    ?>
                                        <li>
                                            <a href="home.php?<?php echo token(); ?>mnu=uplddraw<?php echo token2(); ?>">
                                            <div>
                                                <small><b><?php echo "<i>".$nm_project."</i>"; ?></b></small>
                                                <div>
                                                    <small><?php echo $stat_check; ?></small>
                                                </div>
                                            </div>
                                            </a>
                                        </li>

                                <?php           
                                                $no++;
                                            }//if

                                        } //while($row2 = mysql_fetch_assoc($query_exec2))

                                    }//if ($_SESSION['role'] == "eng") 

                                    elseif ($_SESSION['role'] == "proc") {

                                        echo "  <li style='color: #001f3f'>
                                                    <strong>
                                                        <center><small>Check Document (Eng) </small></center>
                                                    </strong>
                                                </li>
                                                <hr style='margin-top: 1px; margin-bottom: -2px; '>
                                                ";
                                        
                                        $no = 1;
                                        $query_exec2 = get_assigned_project_data_all();           
                                        //while($row2 = mysql_fetch_assoc($query_exec2)){
                                        while($row2 = mysqli_fetch_assoc($query_exec2)){
                                            $id_project = $row2['id_project'];
                                            $nm_project = $row2['nm_project'];

                                            $query_exec3 = get_proj_doc_assign_data_menu($id_project);
                                            //$row3 = mysql_fetch_assoc($query_exec3);
                                            $row3 = mysqli_fetch_assoc($query_exec3);

                                            $query_exec4 = get_proj_doc_assign_data_status_menu($id_project);
                                            //$row4 = mysql_fetch_assoc($query_exec4);
                                            $row4 = mysqli_fetch_assoc($query_exec4);

                                            //$count_row3 = mysql_num_rows($query_exec3);
                                            $count_row3 = mysqli_num_rows($query_exec3);
                                            $sum_check = $row4['check_status'];

                                            if ($count_row3 != $sum_check) {
                                                if ($count_row3 == $sum_check AND ($sum_check != "" AND $count_row3 != "") ){
                                                    $stat_check =  "<span class='badge bg-green'>Completed ($sum_check/$count_row3)</span>";
                                                } elseif ($count_row3 != $sum_check AND ($count_row3 != 0 AND $sum_check != 0)) {
                                                    $stat_check =  "<span class='badge bg-yellow'>Uncompleted ($sum_check/$count_row3)</span>";
                                                } else {
                                                    $sum_check = 0;
                                                    $stat_check =  "<span class='badge bg-red'>Unchecked ($sum_check/$count_row3)</span>";
                                                }

                                ?>

                                        <li>
                                            <a href="home.php?<?php echo token(); ?>mnu=vuplddraw<?php echo token2(); ?>">
                                            <div>
                                                <small><b><?php echo "<i>".$nm_project."</i>"; ?></b></small>
                                                <div>
                                                    <small><?php echo $stat_check; ?></small>
                                                </div>
                                            </div>
                                            </a>
                                        </li>

                                <?php           
                                                $no++;
                                            }//if

                                        } //while($row2 = mysql_fetch_assoc($query_exec2))

                                        echo    "<br><li style='color: #001f3f'>
                                                    <strong>
                                                        <center><small>Check Document (Vdr) </small></center>
                                                    </strong>
                                                </li>
                                                <hr style='margin-top: 1px; margin-bottom: -2px; '>
                                                ";

                                        $no = 1;
                                        $query_exec2 = get_assigned_project_data_all2();           
                                        //while($row2 = mysql_fetch_assoc($query_exec2)){
                                        while($row2 = mysqli_fetch_assoc($query_exec2)){
                                            $id_project = $row2['id_project'];
                                            $nm_project = $row2['nm_project'];
                                            $id_vendor  = $row2['id_vendor'];
                                            $nm_vendor  = $row2['nm_vendor']; 
                                            $allias     = $row2['allias'];

                                            $query_exec3 = get_proj_doc_assign_data_menu2($id_project, $id_vendor);
                                            //$row3 = mysql_fetch_assoc($query_exec3);
                                            $row3 = mysqli_fetch_assoc($query_exec3);

                                            $query_exec4 = get_proj_doc_assign_data_status_menu2($id_project, $id_vendor);
                                            //$row4 = mysql_fetch_assoc($query_exec4);
                                            $row4 = mysqli_fetch_assoc($query_exec4);

                                            //$count_row3 = mysql_num_rows($query_exec3);
                                            $count_row3 = mysqli_num_rows($query_exec3);
                                            $sum_check = $row4['check_status'];

                                            if ($count_row3 != $sum_check) {
                                                if ($count_row3 == $sum_check AND ($sum_check != "" AND $count_row3 != "") ){
                                                    $stat_check_fin = "<span class='badge bg-green'>Completed ($sum_check/$count_row3)</span>";
                                        
                                                } elseif ($count_row3 != $sum_check AND ($count_row3 != 0 AND $sum_check != 0)) {
                                                    $stat_check_fin = "<span class='badge bg-yellow'>Uncomplete ($sum_check/$count_row3)</span>";
                                        
                                                }elseif ($count_row3 != $sum_check AND ($count_row3 != 0 AND $sum_check < $count_row3)) {
                                                    $stat_check_fin =  "<span class='badge bg-yellow'>Uncomplete ($sum_check/$count_row3)</span>";
                                        
                                                } else {
                                                    $sum_check = 0;
                                                    $stat_check_fin =  "<span class='badge bg-red'>Unchecked ($sum_check/$count_row3)</span>";
                                       
                                                }
                                    ?>

                                        <li>
                                            <a href="home.php?<?php echo token(); ?>mnu=vupldeng<?php echo token2(); ?>">
                                            <div>
                                                <small><b><?php echo "<i>".$nm_project." - ".$allias."</i>"; ?></b></small>
                                                <div>
                                                    <small><?php echo $stat_check_fin; ?></small>
                                                </div>
                                            </div>
                                            </a>
                                        </li>

                                <?php

                                       $no++;
                                            }//if

                                        } //while($row2 = mysql_fetch_assoc($query_exec2))

                                    }//if ($_SESSION['role'] == "proc")

                                    elseif ($_SESSION['role'] == "vendor") {

                                        echo "  <li style='color: #001f3f'>
                                                    <strong>
                                                        <center><small>Upload Document (vdr) </small></center>
                                                    </strong>
                                                </li>
                                                <hr style='margin-top: 1px; margin-bottom: -2px; '>
                                                ";
                                        
                                        $no = 1;
                                        $query_exec2 = get_assigned_project_data_all();           
                                        //while($row2 = mysql_fetch_assoc($query_exec2)){
                                        while($row2 = mysqli_fetch_assoc($query_exec2)){
                                            $id_project = $row2['id_project'];
                                            $nm_project = $row2['nm_project'];
                                            //$id_vendor  = $row2['id_vendor'];

                                            $query_exec3 = get_proj_doc_assign_data_menu3($id_project, $id_vendor_master);
                                            //$row3 = mysql_fetch_assoc($query_exec3);
                                            $row3 = mysqli_fetch_assoc($query_exec3);

                                            $query_exec4 = get_proj_doc_upload_data_status_menu3($id_project, $id_vendor_master);
                                            //$row4 = mysql_fetch_assoc($query_exec4);
                                            $row4 = mysqli_fetch_assoc($query_exec4);

                                            /* $count_row3 = mysql_num_rows($query_exec3);
                                            $sum_check = mysql_num_rows($query_exec4); */$count_row3 = mysqli_num_rows($query_exec3);
                                            $sum_check = mysqli_num_rows($query_exec4);

                                            if ($count_row3 != $sum_check) {
                                                if ($count_row3 == $sum_check AND ($sum_check != "" AND $count_row3 != "") ){
                                                    $stat_check =  "<span class='badge bg-green'>Completed ($sum_check/$count_row3)</span>";
                                                } elseif ($count_row3 != $sum_check AND ($count_row3 != 0 AND $sum_check != 0)) {
                                                    $stat_check =  "<span class='badge bg-yellow'>Uncompleted ($sum_check/$count_row3)</span>";
                                                } else {
                                                    $sum_check = 0;
                                                    $stat_check =  "<span class='badge bg-red'>No upload($sum_check/$count_row3)</span>";
                                                }
                                ?>

                                        <li>
                                            <a href="home.php?<?php echo token(); ?>mnu=uplddoceng<?php echo token2(); ?>">
                                            <div>
                                                <small><b><?php echo "<i>".$nm_project."</i>"; ?></b></small>
                                                <div>
                                                    <small><?php echo $stat_check; ?></small>
                                                </div>
                                            </div>
                                            </a>
                                        </li>

                                <?php

                                     $no++;
                                            }//if

                                        } //while($row2 = mysql_fetch_assoc($query_exec2))

                                    }//if ($_SESSION['role'] == "vendor")


                            elseif ($_SESSION['role'] == "qa") {

                                echo    "<li style='color: #001f3f'>
                                                    <strong>
                                                        <center><small>Check Document (Vdr) </small></center>
                                                    </strong>
                                                </li>
                                                <hr style='margin-top: 1px; margin-bottom: -2px; '>
                                                ";
                                $no = 1;
                                $query_exec2 = get_assigned_project_data_all2();
                                //while($row2 = mysql_fetch_assoc($query_exec2)){
                                while($row2 = mysqli_fetch_assoc($query_exec2)){
                                $id_project = $row2['id_project'];
                                $nm_project = $row2['nm_project'];
                                $id_vendor  = $row2['id_vendor'];
                                $nm_vendor  = $row2['nm_vendor'];
                                $allias     = $row2['allias'];

                                $query_exec3 = get_proj_doc_assign_data_menu2($id_project, $id_vendor);
                                //$row3 = mysql_fetch_assoc($query_exec3);
                                $row3 = mysqli_fetch_assoc($query_exec3);

                                $query_exec4 = get_proj_doc_assign_data_status_menu3($id_project, $id_vendor);
                                //$row4 = mysql_fetch_assoc($query_exec4);
                                $row4 = mysqli_fetch_assoc($query_exec4);

                                //$count_row3 = mysql_num_rows($query_exec3);
                                $count_row3 = mysqli_num_rows($query_exec3);
                                $sum_check = $row4['check_status_b'];

                                if ($count_row3 != $sum_check) {
                                    if ($count_row3 == $sum_check AND ($sum_check != "" AND $count_row3 != "") ){
                                        $stat_check_fin = "<span class='badge bg-green'>Completed ($sum_check/$count_row3)</span>";

                                    } elseif ($count_row3 != $sum_check AND ($count_row3 != 0 AND $sum_check != 0)) {
                                        $stat_check_fin = "<span class='badge bg-yellow'>Uncomplete ($sum_check/$count_row3)</span>";

                                    }elseif ($count_row3 != $sum_check AND ($count_row3 != 0 AND $sum_check < $count_row3)) {
                                        $stat_check_fin =  "<span class='badge bg-yellow'>Uncomplete ($sum_check/$count_row3)</span>";

                                    } else {
                                        $sum_check = 0;
                                        $stat_check_fin =  "<span class='badge bg-red'>Unchecked ($sum_check/$count_row3)</span>";

                                    }

                                ?>

                                    <li>
                                       <a href="home.php?<?php echo token(); ?>mnu=vupldeng<?php echo token2(); ?>">
                                           <div>
                                               <small><b><?php echo "<i>".$nm_project." - ".$allias."</i>"; ?></b></small>
                                               <div>
                                                   <small><?php echo $stat_check_fin; ?></small>
                                               </div>
                                           </div>
                                       </a>
                                    </li>

                            <?php

                                    $no++;

                                }//if

                                } //while($row2 = mysql_fetch_assoc($query_exec2))

                            }// elseif ($_SESSION['role'] == "qa")

                            ?>


                                    </ul> <!-- <ul class="menu"> -->
                                </li> <!-- <li> -->

                                <!--
                                <li class="footer"><a href="#">View all</a></li>
                                -->

                            </ul> <!-- <ul class="dropdown-menu"> -->
                            
                        </li> <!-- <li class="dropdown notifications-menu"> -->

                        <!-- Tasks: style can be found in dropdown.less -->
                        
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="glyphicon glyphicon-user"></i>
                                <span>
                                <?php 
                                    echo $_SESSION['nm_user']; 
                                ?>
                                <i class="caret"></i></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header bg-black">
                                   
                                    <p>
                                        <?php 
                                        
                                            if ($_SESSION['role'] == "vendor"){
                                                echo $_SESSION['nm_vendor']."<br>"; 
                                                echo "<small>".$_SESSION['username']."</small>";
                                            } else {
                                                echo $_SESSION['username'];
                                            }
                                        
                                        ?>
                                        <small><?php echo $_SESSION['nm_tipe_user']." (".$_SESSION['role'].")"; ?></small>

                                        <?php

                                            if ($_SESSION['role'] == "admin"){
                                        ?>

                                        <small><?php echo $ip; ?></small>
                                        <small><?php echo $mac; ?></small>

                                        <?php
                                            }//f ($_SESSION['role'] == "admin")
                                        ?>
                                    </p>
                                </li>
                                <!-- Menu Body -->
                               
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    
                                    <div class="pull-left">
                                        <a href="home.php?<?php echo token(); ?>mnu=chpwd<?php echo token2(); ?>" class="btn btn-default btn-flat"><i class="fa fa-lock"></i>&nbsp; Change Password</a>
                                    </div>

                                    <form method="post">
                                    <div class="pull-right">
                                        <button type="submit" name ="log" class="btn btn-default btn-flat"><i class="fa fa-sign-out"></i> Logout</button>
                                    </div>
                                    </form>
                                </li>

                                <?php
                                    if(isset($_POST['log'])){
                                        insert_user_log_menu($id_user, $ip, 'S', 'out', '');
                                        echo "<script>window.location.href = 'logout.php';</script>";
                                    }
                                ?>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
</header>




        <script src="../jquery-2/jquery.min.js"></script>
        <!-- jQuery UI 1.10.3 -->
        <script src="../js/jquery-ui-1.10.3.min.js" type="text/javascript"></script>
        <!-- Bootstrap -->
        <script src="../js/bootstrap.min.js" type="text/javascript"></script>
        <!-- Morris.js charts 
        <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
        -->
        <script src="../css/raphael/raphael-min.js"></script>
        <script src="../js/plugins/morris/morris.min.js" type="text/javascript"></script>
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
        <script src="../js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
        <!-- iCheck -->
        <script src="../js/plugins/iCheck/icheck.min.js" type="text/javascript"></script>

        <!-- AdminLTE App -->
        <script src="../js/AdminLTE/app.js" type="text/javascript"></script>
        
        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
        <script src="../js/AdminLTE/dashboard.js" type="text/javascript"></script>        

        <!-- Bootstrap -->
        <script src="../js/bootstrap.min.js" type="text/javascript"></script>
        <!-- DATA TABES SCRIPT -->
        <script src="../js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
        <script src="../js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>

        <script src="../select/dist/js/bootstrap-select.js"></script>
</body>