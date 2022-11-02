<?php
    include "project-mgt-query.php";
    include "../conn/conn.php";
?>

<?php
        $id_user = '00010';

        $query = get_vendor_user($id_user);
        $row = mysqli_fetch_assoc($query);
        $id_vendor  = $row['id_vendor'];

?>
<div class="box-body table-responsive">
<table id="example2" class="table table-bordered table-striped">                      
        
        <thead>
            <tr>
                <!--
                <th><small>ID Project</small></th>
                -->
                <th><small>Project Name</small></th>
                <th><small>Upload (Eng)</small></th>
                <th><small>Check (Proc)</small></th>
                <!--
                <th><small>Dwld (Vdr)</small></th>
                -->
                <th><small>Upld (Vdr)</small></th>
                <th><small>Fin. Check (Proc)</small></th>
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
                    } elseif ($count_row6 != $count_row7 AND ($count_row6 != 0 AND $count_row7 > 0)) {
                        $upload_vendor_stat =  "<h4><span class='badge bg-yellow'>Uncomplete ($count_row7/$count_row6)</span></h4>";
                    } else {
                        $upload_vendor_stat =  "<h4><span class='badge bg-red'>No upload($count_row7/$count_row6)</span></h4>";
                    }

                    //FIN CHECK (PROC)
                    $query_exec8 = get_proj_vendor_assign_data_all($id_project, $id_vendor);
                    $row8 = mysqli_fetch_assoc($query_exec8);

                    $query_exec9 = get_proj_vendor_assign_data_status_all($id_project, $id_vendor);
                    $row9 = mysqli_fetch_assoc($query_exec9);

                    $count_row8 = mysqli_num_rows($query_exec8);
                    $sum_check2 = $row9['check_status'];

                    $data = $id_project.','.$id_vendor;
                    
                    if ($count_row8 == $sum_check2 AND ($sum_check2 != "" AND $count_row8 != "") ){
                        $stat_check_fin =  "<h4><span class='badge bg-green'>Completed ($sum_check2/$count_row8)</span></h4>";
                        $proj_stat      =  "<a href='DATA/zip_it_all.php?data=$data' target='_blank' data-toggle='tooltip' title='click to download'><h4><span class='badge bg-green'>CLOSED <i class='fa fa-download'></i></span></h4></a>";
                    } elseif ($count_row8 != $sum_check2 AND ($count_row8 != 0 AND $sum_check2 != 0)) {
                        $stat_check_fin =  "<h4><span class='badge bg-yellow'>Uncomplete ($sum_check2/$count_row8)</span></h4>";
                        $proj_stat      =  "<h4><span class='badge bg-yellow'>OPEN</span></h4>";
                    }elseif ($count_row8 != $sum_check2 AND ($count_row8 != 0 AND $sum_check2 < $count_row8)) {
                        $stat_check_fin =  "<h4><span class='badge bg-yellow'>Uncomplete ($sum_check2/$count_row8)</span></h4>";
                        $proj_stat      =  "<h4><span class='badge bg-yellow'>OPEN</span></h4>";
                    } else {
                        $sum_check2 = 0;
                        $stat_check_fin =  "<h4><span class='badge bg-red'>Unchecked ($sum_check2/$count_row8)</span></h4>";
                        $proj_stat      =  "<h4><span class='badge bg-red'>UNDEFINED</span></h4>";
                    }
            ?>
                <tr>
                    <!--
                    <td><small><?php echo $row['id_project'];?></small></td>
                    -->
                    <td><small><?php echo $row['nm_project'];?></small></td>
                    <td><?php echo $upload_stat; ?></td>
                    <td><?php echo $stat_check;?></td>
                    <td><?php echo $upload_vendor_stat; ?></td>
                    <td><?php echo $stat_check_fin; ?></td>
                    <td><?php echo $proj_stat?></td> <!-- if open can't download if open can download fin docs-->
                </tr>

            <?php

                }// while ($row = mysqli_fetch_assoc($query_exec))
                
            ?>                               
        </tbody>                       
        
    </table>
 </div>

 <!-- DATA TABES SCRIPT -->
 <script src="../jquery/jquery.min.js"></script>
        <script src="../js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
        <script src="../js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
        <!-- page script -->
        <script type="text/javascript">
            $(function() {
                $("#example1").dataTable();
                $('#example2').dataTable({
                    "bPaginate": true,
                    "bLengthChange": true,
                    "bFilter": true,
                    "bSort": true,
                    "bInfo": true,
                    "bAutoWidth": false
                });
            });
        </script>