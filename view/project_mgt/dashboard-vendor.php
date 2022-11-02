<?php
    include "project-mgt-query.php";
    include "project-mgt-func.php";
?>

<div class="box-header">
    <h3 class="box-title">Dashboard Vendor Project</h3>   
</div><!-- /.box-header -->
<hr style="margin-top: 1px;">

<?php
        $id_user = $_SESSION['id_user'];

        $query = get_vendor_user($id_user);
        $row = mysqli_fetch_assoc($query);
        $id_vendor  = $row['id_vendor'];

?>

<div class="box-body table-responsive">                        
    <table id="example2" class="table table-bordered table-striped">                      
        
        <thead>
            <tr>
                <th><small>Project Name</small></th>
                <!--
                <th><small>Dwld (Vdr)</small></th>
                -->
                <th><small>Doc Assignment (Proc)</small></th>
                <th><small>Upld (Vdr)</small></th>
                <th><small>Fin. Check (Proc)</small></th>
                <th><small>Fin. Check (QA)</small></th>
                <th><small>Stat</small></th>
            </tr>
        </thead>
        <tbody> 
                                  
           <?php
                //PHP TAG
                
                $no =1;
                $arr_data = array();
                $arr        = array();
                $arr_mdt    = array();
                $arr2_mdt   = array();

                $query_exec = dashboard_vendor_data($id_vendor);
                while ($row = mysqli_fetch_assoc($query_exec)) {
                    $id_project = $row['id_project'];
                    $id_vendor = $row['id_vendor'];
                    $id_product = $row['id_product'];
                    $id_part    = $row['id_part'];
                    $id_doc_part= $row['id_doc_part'];

                    //Doc Assignment
                    $count_rows = 0;
                    $arr = array();
                    $query_doc_stat = get_vendor_has_assigned_detail2($id_project, $id_vendor, 'P');
                    while ($row_loop = mysqli_fetch_assoc($query_doc_stat)) {

                        $id_product_dt     = $row_loop['id_product'];
                        $id_part_dt        = $row_loop['id_part'];
                        $id_doc_part_dt    = $row_loop['id_doc_part'];
                        $doc_required_dt   = $row_loop['doc_required'];

                        $query_exec_data1 = get_proj_doc_assign_data($id_project, $id_product_dt, $id_part_dt, $id_doc_part_dt);
                        $row_data1 = mysqli_fetch_assoc($query_exec_data1);

                        $query_exec_data2 = get_proj_doc_assign_data_status($id_project, $id_product_dt, $id_part_dt, $id_doc_part_dt);
                        $row_data2 = mysqli_fetch_assoc($query_exec_data2);

                        $count_row_data = mysqli_num_rows($query_exec_data1);
                        $sum_check_data = $row_data2['check_status'];

                        //echo $id_project." | ".$id_vendor." | ".$id_product_dt." | ".$id_part_dt." | ".$id_doc_part_dt."<br>";

                        if ($count_row_data == $sum_check_data) {
                            array_push($arr, "1");
                        }

                        $count_rows++;
                    }

                    $checked_doc = count($arr);
                    if ($checked_doc == $count_rows AND ($checked_doc != 0 AND $count_rows != 0) ){
                        $doc_assignment_stat =  "<h4><span class='badge bg-green'>Completed ($checked_doc/$count_rows)</span></h4>";
                        $doc_assignment = 1;
                    } elseif ($checked_doc != $count_rows AND ($checked_doc > 0 AND $count_rows != 0)) {
                        $doc_assignment_stat =  "<h4><span class='badge bg-yellow'>Uncomplete ($checked_doc/$count_rows)</span></h4>";
                        $doc_assignment = 0;
                    } else {
                        $doc_assignment_stat =  "<h4><span class='badge bg-red'>No Assignment($checked_doc/$count_rows)</span></h4>";
                        $doc_assignment = 0;
                    }

                    //CHECK STAT (PROC)
                    //count uploaded doc by engineering and make stat uploaded doc
                    $query_exec3 = get_proj_doc_assign_data_all($id_project);
                    $row3 = mysqli_fetch_assoc($query_exec3);

                    $query_exec4 = get_proj_doc_assign_data_status_all($id_project);
                    $row4 = mysqli_fetch_assoc($query_exec4);

                    $count_row3 = mysqli_num_rows($query_exec3);
                    $sum_check = $row4['check_status'];

                    if ($count_row3 == $sum_check AND ($sum_check != "" AND $count_row3 != "") ){
                        $stat_check =  "<h4><span class='badge bg-green'>Completed ($sum_check/$count_row3)</span></h4>";
                    } elseif ($count_row3 != $sum_check AND ($count_row3 != 0 AND $sum_check != 0)) {
                        $stat_check =  "<h4><span class='badge bg-yellow'>Uncomplete ($sum_check/$count_row3)</span></h4>";
                    } else {
                        $sum_check = 0;
                        $stat_check =  "<h4><span class='badge bg-red'>Unchecked ($sum_check/$count_row3)</span></h4>";
                    }

                    //UPLOAD (ENG)
                    $query_exec4    = get_proj_doc_assign_data2($id_project);
                    $row4           = mysqli_fetch_assoc($query_exec4);
                    $count_row4     = mysqli_num_rows($query_exec4);

                    $query_exec5    = get_proj_doc_upload_data_status($id_project);
                    $row5           = mysqli_fetch_assoc($query_exec5);
                    $count_row5     = mysqli_num_rows($query_exec5);
                    

                    if ( $count_row4 == $count_row5 AND ($count_row4 != 0 AND $count_row5 != 0) ){
                        $upload_stat =  "<h4><span class='badge bg-green'>Completed ($count_row4/$count_row5)</span></h4>";
                    } elseif ($count_row4 != $count_row5 AND ($count_row4 > 0 AND $count_row5 != 0)) {
                        $upload_stat =  "<h4><span class='badge bg-yellow'>Uncomplete ($count_row4/$count_row5)</span></h4>";
                    } else {
                        $upload_stat =  "<h4><span class='badge bg-red'>No upload($count_row4/$count_row5)</span></h4>";
                    }

                    //UPLOAD (VDR)
                    $query_exec6    = get_proj_doc_assign_data3($id_project, $id_vendor);
                    $row6           = mysqli_fetch_assoc($query_exec6);
                    $count_row6     = mysqli_num_rows($query_exec6);

                    $query_exec7    = get_proj_doc_upload_data_status2($id_project, $id_vendor);
                    $row7           = mysqli_fetch_assoc($query_exec7);
                    $count_row7     = mysqli_num_rows($query_exec7);

                    if ( $count_row6 == $count_row7 AND ($count_row6 != 0 AND $count_row7 != 0) ){
                        $upload_vendor_stat =  "<h4><span class='badge bg-green'>Completed ($count_row7/$count_row6)</span></h4>";
                        $checked_upload_vdr = 1;
                    } elseif ($count_row6 != $count_row7 AND ($count_row6 != 0 AND $count_row7 > 0)) {
                        $upload_vendor_stat =  "<h4><span class='badge bg-yellow'>Uncomplete ($count_row7/$count_row6)</span></h4>";
                        $checked_upload_vdr = 0;
                    } else {
                        $upload_vendor_stat =  "<h4><span class='badge bg-red'>No upload($count_row7/$count_row6)</span></h4>";
                        $checked_upload_vdr = 0;
                    }

                    //FIN CHECK (PROC)
                    $query_exec8 = get_proj_vendor_assign_data_all($id_project, $id_vendor);
                    $row8 = mysqli_fetch_assoc($query_exec8);

                    $query_exec9 = get_proj_vendor_assign_data_status_all($id_project, $id_vendor);
                    $row9 = mysqli_fetch_assoc($query_exec9);

                    $query_exec10 = get_proj_vendor_assign_data_status_all2($id_project, $id_vendor);
                    $row10 = mysqli_fetch_assoc($query_exec10);

                    $count_row8 = mysqli_num_rows($query_exec8);
                    $sum_check_a = $row9['check_status'];
                    $sum_check_b = $row10['check_status_b'];

                    $data = $id_project.','.$id_vendor;
                    
                    if ($count_row8 == $sum_check_a AND ($sum_check_a != "" AND $count_row8 != "") ){
                        $stat_check_fin_proc =  "<h4><span class='badge bg-green'>Completed ($sum_check_a/$count_row8)</span></h4>";
                        $checked_fin_proc = 1;

                    } elseif ($count_row8 != $sum_check_a AND ($count_row8 != 0 AND $sum_check_a != 0)) {
                        $stat_check_fin_proc =  "<h4><span class='badge bg-yellow'>Uncomplete ($sum_check_a/$count_row8)</span></h4>";
                        $checked_fin_proc = 0;

                    }elseif ($count_row8 != $sum_check_a AND ($count_row8 != 0 AND $sum_check_a < $count_row8)) {
                        $stat_check_fin_proc =  "<h4><span class='badge bg-yellow'>Uncomplete ($sum_check_a/$count_row8)</span></h4>";
                        $checked_fin_proc = 0;
                    } else {
                        $sum_check_a = 0;
                        $stat_check_fin_proc =  "<h4><span class='badge bg-red'>Unchecked ($sum_check_a/$count_row8)</span></h4>";
                        $checked_fin_proc = 0;
                    }

                    //check by qa
                    if ($count_row8 == $sum_check_b AND ($sum_check_b != "" AND $count_row8 != "") ){
                        $stat_check_fin_qa   =  "<h4><span class='badge bg-green'>Completed ($sum_check_b/$count_row8)</span></h4>";
                        $checked_fin_qa = 1;
                    } elseif ($count_row8 != $sum_check_b AND ($count_row8 != 0 AND $sum_check_b != 0)) {
                        $stat_check_fin_qa   =  "<h4><span class='badge bg-yellow'>Uncomplete ($sum_check_b/$count_row8)</span></h4>";
                        $checked_fin_qa = 0;
                    } elseif ($count_row8 != $sum_check_b AND ($count_row8 != 0 AND $sum_check_b < $count_row8 )) {
                        $stat_check_fin_qa   =  "<h4><span class='badge bg-yellow'>Uncomplete ($sum_check_b/$count_row8)</span></h4>";
                        $checked_fin_qa = 0;
                    } else {
                        $sum_check_b = 0;
                        $checked_fin_qa = 0;
                        $stat_check_fin_qa   =  "<h4><span class='badge bg-red'>Unchecked ($sum_check_b/$count_row8)</span></h4>";
                    }

                    //close project
                    if ($checked_upload_vdr == 1 AND $checked_fin_proc == 1 AND $checked_fin_qa == 1 AND $doc_assignment == 1){
                        $proj_stat      =  "<a href='DATA/zip_it_all.php?data=$data' target='_blank' data-toggle='tooltip' title='click to download'><h4><span class='badge bg-green'>CLOSED <i class='fa fa-download'></i></span></h4></a>";
                    } elseif ($checked_upload_vdr != 1 OR $checked_fin_proc != 1 OR $checked_fin_qa != 1 OR $doc_assignment != 1) {
                        $proj_stat      =  "<h4><span class='badge bg-yellow'>OPEN</span></h4>";
                    } else {
                        $proj_stat      =  "<h4><span class='badge bg-red'>UNDEFINED</span></h4>";
                    }
            ?>
                <tr>
                    <!--
                    <td><small><?php echo $row['id_project'];?></small></td>
                    -->
                    <td><small><?php echo $row['nm_project'];?></small></td>
                    <!--
                    <td><?php echo $upload_stat; ?></td>
                    <td><?php echo $stat_check;?></td>
                    -->
                    <td><?php echo $doc_assignment_stat; ?></td>
                    <td><?php echo $upload_vendor_stat; ?></td>
                    <td><?php echo $stat_check_fin_proc; ?></td>
                    <td><?php echo $stat_check_fin_qa; ?></td>
                    <td><?php echo $proj_stat?></td> <!-- if open can't download if open can download fin docs-->
                </tr>

            <?php

                }// while ($row = mysqli_fetch_assoc($query_exec))
                
            ?>                               
        </tbody>                       
        
    </table>

</div>

        <!-- jQuery 2.0.2 -->
        <script src="../jquery-2/jquery.min.js"></script>
        <!-- Bootstrap -->
        <script src="../js/bootstrap.min.js" type="text/javascript"></script>
        <!-- DATA TABES SCRIPT -->
        <script src="../js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
        <script src="../js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
        <!-- AdminLTE App -->
        <script src="../js/AdminLTE/app.js" type="text/javascript"></script>

        <!-- page script -->
        <script type="text/javascript">
            $(function() {
                $("#example1").dataTable();
                $('#example2').dataTable({
                    "bPaginate": true,
                    "bLengthChange": false,
                    "bFilter": true,
                    "bSort": true,
                    "bInfo": false,
                    "bAutoWidth": false
                });
            });
        </script>

    </body>
</html>