<?php

//include "../conn/connection.php";
include "master-data-query.php";

?>
           
<div class="box-header">
	<h3 class="box-title">Edit Menu Group</h3>
</div>
<hr style="margin-top: 1px;">

<?php

    $id_menu_group = $_GET['id_menu_group'];
    $id_user = $_SESSION['id_user'];
    
     $query_exec2 = get_menu_group_data_by_id($id_menu_group);
    
        while ($row2 = mysqli_fetch_assoc($query_exec2)) {
           
        $menu_group_name    = $row2['menu_group_name'];
        $menu_group_obj     = $row2['menu_group_object'];
        $mg_status          = $row2['mg_status'];

?>
    <!-- registration/act-master-data.php -->
    <form role=form name="myForm" id="myForm" onSubmit="return validateForm()" action="" method="post" enctype="multipart/form-data">
        
        <div class="box-body">    

            <input type="hidden" id="id_menu_group" name="id_menu_group" class="form-control" value="<?php echo $id_menu_group; ?>">
            <input type="hidden" id="id_user" name="id_user" value ="<?php echo $id_user; ?>">

            <div class="form-group">
                <label>Menu Group Name</label>
                <input type="text" class="form-control" id="menu_group_name" name="menu_group_name" value="<?php echo $menu_group_name; ?>" required> 
            </div>

            <div class="form-group">
                <label>Menu Group Object</label>
                <input type="text" class="form-control" id="menu_group_object" name="menu_group_object" value="<?php echo $menu_group_obj; ?>" focused required> 
            </div>
                
            <div class="form-group">
                <label>Status User</label>
                <select class="form-control" id="mg_status" name="mg_status" >
                    <option value="A" <?php if($mg_status == 'A'){ echo "selected"; } ?> >Active</option>
                    <option value="N" <?php if($mg_status != 'A'){ echo "selected"; } ?> >Not-active</option>
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
                        $query_exec = get_menu_list_all_unassigned($id_menu_group); 
                        
                        $dataQuery = array();
                        $query_check = get_menu_list_all_by_id_menu_group($id_menu_group);
                        while ($row2 = mysqli_fetch_assoc($query_check)) {
                            array_push($dataQuery, $row2['id_menu']);
                        }

                        $dataQuery_negate = array();
                        $query_check_negate = get_menu_list_all_by_id_menu_group_negate($id_menu_group);
                        while ($row_negate = mysqli_fetch_assoc($query_check_negate)) {
                            array_push($dataQuery_negate, $row_negate['id_menu']);
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

                            if(in_array($row['id_menu'], $dataQuery_negate)){
                                $disable = 'checked disabled';
                            }else {
                                $disable = '';
                            }       
                                                
                            echo "    <tr>";
                            echo "        <td><input type='checkbox' name='selectmnu[]' value='".$row['id_menu']."' ".$check." ".$disable." ></td>"; //".$check."
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
        	    <button type="submit" id="edit-menu-group" name="edit-menu-group" class="btn btn-primary"><i class="fa fa-pencil-square-o"></i> Update</button>
        	</div>
    </form>

    <?php

        }

        if(isset($_POST['edit-menu-group'])){

            $id_menu_group      = $_POST['id_menu_group']; 
            $menu_group_name    = $_POST['menu_group_name'];
            $menu_group_obj     = $_POST['menu_group_object'];
            $id_user            = $_POST['id_user']; 
            $mg_status          = $_POST['mg_status'];
            $selected_menu      = $_POST['selectmnu'];

            $count_menu  = count($selected_menu);

            if($count_menu != 0){   

                //count menu on menu group
                $query_exec = get_menu_list_all_by_id_menu_group($id_menu_group); 
                $row_count = mysqli_num_rows($query_exec);

                if ($row_count > 0) {

                    $arr_menucheck = array();
                    for($i = 0; $i < $count_menu; $i++ ){
                        array_push($arr_menucheck, $selected_menu[$i]);
                    }

                    $arr_menuassigned = array();
                    while ($row = mysqli_fetch_assoc($query_exec)) {
                        array_push($arr_menuassigned, $row['id_menu']);
                    }

                    $arr_uncheckmenu = array_diff($arr_menuassigned, $arr_menucheck);

                     //menu group edit
                    delete_menu_group_assigned($id_menu_group);
                    update_menu_group_data($id_menu_group, $menu_group_name, $menu_group_obj, $id_user, $mg_status);
                    $assigned = 'Y';
                    for($i = 0; $i < $count_menu; $i++ ){
                         //insert data menu_group 
                        insert_menu_group_assign_data($id_menu_group, $selected_menu[$i], $id_user);
                         //update menu assigned
                        update_menu_list_assigned_stat($selected_menu[$i], $id_user, $assigned);
                         //echo "<script>alert('".$selected_menu[$i]."');</script>";
                    }
                    
                    $count_unchecked = count($arr_uncheckmenu);
                    for($n = 0; $n < $count_menu; $n++ ){
                        //update assigned
                        update_menu_list_assigned_stat($arr_uncheckmenu[$n], $id_user, "N");
                    }

                    /*
                    echo "<script>".print_r($arr_menucheck)."</script><br>";
                    echo "<script>".print_r($arr_menuassigned)."</script><br>";
                    echo "<script>".print_r($arr_uncheckmenu)."</script><br>";
                    */

                } else {

                    //menu group edit
                    delete_menu_group_assigned($id_menu_group);
                    update_menu_group_data($id_menu_group, $menu_group_name, $menu_group_obj, $id_user, $mg_status);
                    $assigned = 'Y';
                    for($i = 0; $i < $count_menu; $i++ ){
                        //insert data menu_group 
                        insert_menu_group_assign_data($id_menu_group, $selected_menu[$i], $id_user);
                        //update menu assigned
                        update_menu_list_assigned_stat($selected_menu[$i], $id_user, $assigned);
                        //echo "<script>alert('".$selected_menu[$i]."');</script>";
                    }
                }

                //update status menu_group = assigned
                update_menu_group_assigned_stat($id_menu_group, $id_user, $assigned);

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
                    window.location = (\'../view/home.php?mnu=mnugroup\');
                });

                </script>
                ';
                
                
            } else {

                if($id_menu_group == "1" OR $menu_group_obj == "userreg"){

                    echo '
                        <script>
                        swal({
                            title: "Error!",
                            text: "This Menu Group not modifiable!",
                            type: "error",
                            customClass: \'swal-wide\',
                            allowOutsideClick: false
                        })
                            .then(function() {
                            window.location = (\'../view/home.php?mnu=mnugroup\');
                        });

                        </script>
                        ';

                }else{

                    //updata status menu_group = unassigned
                    $assigned = 'N';
                    delete_menu_group_assigned($id_menu_group);
                    update_menu_group_assigned_stat($id_menu_group, $id_user, $assigned);

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
                        window.location = (\'../view/home.php?mnu=mnugroup\');
                    });

                    </script>
                    ';

                }
                
            }
            

        }

        
        //if success
            //check data base on id menu group and id_menu
            //if selected menu != 0
                //delete data where id_menu_group = x
                //loop selected menu
                    //insert data menu_group and update menu status = assigned
                //endloop

                //update status menu_group = assigned
                //message success
                //go to url menu group
            //else
                //updata status menu_group = unassigned
                //message warning no menu selected
            //endif
        //endif

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