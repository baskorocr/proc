<?php

//include "../conn/connection.php";
include "master-data-query.php";

?>
           
<div class="box-header">
	<h3 class="box-title">Edit Access Group</h3>
</div>
<hr style="margin-top: 1px;">

<?php

    $id_access_group = $_GET['id_acc'];
    $id_user = $_SESSION['id_user'];
    
     $query_exec2 = get_access_group_data_by_id($id_access_group);
    
        while ($row2 = mysqli_fetch_assoc($query_exec2)) {
           
        $access_group_name    = $row2['access_group_name'];
        $ag_status           = $row2['ag_status'];

?>
    <form role=form name="myForm" id="myForm" onSubmit="return validateForm()" action="" method="post" enctype="multipart/form-data">
        
        <div class="box-body">    

            <input type="hidden" id="id_access_group" name="id_access_group" class="form-control" value="<?php echo $id_access_group; ?>">
            <input type="hidden" id="id_user" name="id_user" value ="<?php echo $id_user; ?>">

            <div class="form-group">
                <label>Access Group Name</label>
                <input type="text" class="form-control" id="access_group_name" name="access_group_name" value="<?php echo $access_group_name; ?>" required> 
            </div>
                
            <div class="form-group">
                <label>Status Access Group</label>
                <select class="form-control" id="ag_status" name="ag_status" >
                    <option value="A" <?php if($ag_status == 'A'){ echo "selected"; } ?> >Active</option>
                    <option value="N" <?php if($ag_status != 'A'){ echo "selected"; } ?> >Not-active</option>
                </select>
            </div>                                                                       
    
    	</div><!-- /.box-body -->

        <div class="box-body table-responsive">                        
            <table id="example2" class="table table-bordered table-striped table-hover display nowrap"  style="width:100%">

                <thead>
                    <tr>
                        <th class="no-sort"><i class="fa fa-list"></i></th>
                        <th>Menu Name</th>
                        <th>Menu Object</th>
                        <th>Object Path</th>
                        <th>Last Changed by</th>
                        <th>Last Changed</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                <?php
                        //PHP TAG
                        $no =1;
                        $query_exec = get_menu_all_by_access_group($id_access_group);

                        $dataQuery = array();
                        $query_check = get_menu_all_by_id_access_group($id_access_group);
                        while ($row2 = mysqli_fetch_assoc($query_check)) {
                            array_push($dataQuery, $row2['id_menu']);
                        }

                        while ($row = mysqli_fetch_assoc($query_exec)) {

                            if ($row['mn_status']=='A') {
                                $status = "<small class='label label-success'> Active</small>";
                            } elseif ($row['mn_status']=='N') {
                                $status = "<small class='label label-danger'> Non-Active</small>";
                            }

                            if ($row['assigned'] == 'Y'){
                                $assigned = "<small class='label label-success'> Assigned</small>";
                            }elseif ($row['assigned'] == 'N') {
                                $assigned = "<small class='label label-warning'> Not-Assigned</small>";
                            }

                            $foreign_nm = $row['role'];
                            $dateformat_chg = strtotime($row['last_changed']);
                            $last_changed = date("d.m.Y H:i", $dateformat_chg);
                            
                            if(in_array($row['id_menu'], $dataQuery)){
                                $check = 'checked';
                            }else {
                                $check = '';
                            }            

                            echo "    <tr>";
                            echo "        <td><input type='checkbox' name='selectmnu[]' value='".$row['id_menu']."' ".$check."  ></td>";
                            echo "        <td>".$row['menu_name']."</td>";
                            echo "        <td>".$row['menu_object']."</td>";
                            echo "        <td>".$row['object_path']."</td>";
                            echo "        <td>".$row['nm_user']."</td>";
                            echo "        <td>".$last_changed."</td>";
                            echo "        <td align='left'>".$status."</td>"; //label-danger if not active
                            
                            echo "    </tr>";
                        }
                    ?>
                    </tbody>
                </table>
            </div><!-- /.box-body -->

        	<div class="box-footer">
        	    <button type="submit" id="edit-access-group" name="edit-access-group" class="btn btn-primary"><i class="fa fa-pencil-square-o"></i> Update</button>
        	</div>
    </form>

    <?php

        }

        if(isset($_POST['edit-access-group'])){

            $id_access_group    = $_POST['id_access_group']; 
            $access_group_name  = $_POST['access_group_name'];
            $menu_group_obj     = $_POST['menu_group_object'];
            $id_user            = $_POST['id_user']; 
            $ag_status          = $_POST['ag_status'];
            $selected_menu      = $_POST['selectmnu'];

            $count_menu  = count($selected_menu);
            
            if($count_menu != 0){

                /*
                $query_check = get_menu_all_by_id_access_group($id_access_group);
                $row_count = mysql_num_rows($query_exec);

                if ($row_count > 0) {
                    
                    $arr_menucheck = array();
                    for($i = 0; $i < $count_menu; $i++ ){
                        array_push($arr_menucheck, $selected_menu[$i]);
                    }

                    $arr_menuassigned = array();
                    while ($row = mysql_fetch_assoc($query_exec)) {
                        array_push($arr_menuassigned, $row['id_menu']);
                    }

                    $arr_uncheckmenu = array_diff($arr_menuassigned, $arr_menucheck);

                    delete_access_group_assigned($id_access_group);
                    update_access_group_data($id_access_group, $access_group_name, $id_user, $ag_status);

                    $assigned = 'Y';
                    for($i = 0; $i < $count_menu; $i++ ){
                        //insert data menu_group 
                        insert_access_group_assign_data($id_access_group, $selected_menu[$i], $id_user);
                        //update menu assigned
                        update_access_group_assigned_stat($id_access_group, $id_user, $assigned);
                        echo "<script>alert('".$selected_menu[$i]."');</script>";
                    }

                }
                else 
                {
                    
                }
                */

                update_access_group_data($id_access_group, $access_group_name, $id_user, $ag_status);
                delete_access_group_assigned($id_access_group);

                $assigned = 'Y';
                for($i = 0; $i < $count_menu; $i++ ){
                    //insert data menu_group 
                    insert_access_group_assign_data($id_access_group, $selected_menu[$i], $id_user);
                    //update menu assigned
                    update_access_group_assigned_stat($id_access_group, $id_user, $assigned);
                        //echo "<script>alert('".$selected_menu[$i]."');</script>";
                }

                //update status menu_group = assigned
                update_access_group_assigned_stat($id_access_group, $id_user, $assigned);

                echo '
                <script>
                swal({
                    title: "Success!",
                    text: "Data has been updated!",
                    type: "success",
                    customClass: \'swal-wide\',
                    allowOutsideClick: false
                })
                    .then(function() {
                    window.location = (\'../view/home.php?mnu=accgrmaster\');
                });

                </script>
                ';
            }
            else
            {
               
                    //updata status menu_group = unassigned
                    $assigned = 'N';
                    delete_access_group_assigned($id_access_group);
                    update_access_group_assigned_stat($id_access_group, $id_user, $assigned);

                    echo '
                    <script>
                    swal({
                        title: "Warning!",
                        text: "No menu selected!",
                        type: "warning",
                        customClass: \'swal-wide\',
                        allowOutsideClick: false
                    })
                        .then(function() {
                        window.location = (\'../view/home.php?mnu=accgrmaster\');
                    });

                    </script>
                    ';

                

            }
        
        }

    ?>

<script src="../jquery-2/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="../js/bootstrap.min.js" type="text/javascript"></script>
<!-- AdminLTE App -->
<script src="../js/AdminLTE/app.js" type="text/javascript"></script>

<!-- DATA TABLES SCRIPT -->
<script src="../js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="../js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>

<script type="text/javascript">
    $(function() {
        $("#example2").dataTable( {
            "scrollX": true,
            "filter" : true,
            "lengthChange" : false,
            "sort"         : true,
            "paginate"     : false,
            "autowidth"    : false,
            "pagingType"   : "simple_numbers"
        } );
    });

</script>

    </body>
</html>