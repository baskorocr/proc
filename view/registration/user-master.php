<?php
    include "master-data-query.php";
    include "master-data-func.php";
?>

<div class="box-header">
    <h3 class="box-title">User Master</h3>   

    <div class="pull-right box-tools">
        <!-- button with a dropdown -->
        <div class="btn-group">
            <a href="#" data-toggle="dropdown"><i class="fa fa-bars"></i></a>
            <ul class="dropdown-menu pull-right" role="menu">
                <li><a href="#addModal" data-toggle="modal" data-backdrop="static" data-keyboard="false">
                    <i class="fa fa-plus-circle"></i>Create User</a>
                </li>
                <li><a href="#addModalVendor" data-toggle="modal" data-backdrop="static" data-keyboard="false">
                    <i class="fa fa-plus-circle"></i>Create Vendor User</a>
                </li>
                
                <li><a href="home.php?mnu=vdremailupdate"><i class="fa fa-upload"></i>Update Email</a></li>
               
            </ul>
        </div>
    </div><!-- /. tools -->   
</div><!-- /.box-header -->
<hr style="margin-top: 1px;">

<div class="box-body table-responsive">                        
    <table id="example2" class="table table-bordered table-striped table-hover display nowrap"  style="width:100%">

        <thead>
            <tr>
                <th>#</th>
                <th>ID User</th>
                <th>Nama User</th>
                <th>Tipe User</th>
                <th>Login Username</th>
                <th>Role</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
        <?php
                //PHP TAG
                $no =1;
                $query_exec = get_all_user_data();

                while ($row = mysqli_fetch_assoc($query_exec)) {

                    if ($row['status_user']=='A') {
                        $status = "<small class='label label-success'> Active</small>";
                    } elseif ($row['status_user']=='N') {
                        $status = "<small class='label label-danger'> Non-Active</small>";
                    }

                    if ($row['nm_vendor'] == ""){
                        $foreign_user = "Internal user";
                        $foreign_nm   = "Dharma Polimetal";
                    } else {
                        $foreign_user = "External user";
                        $foreign_nm   = $row['nm_vendor'];
                    }

                    $access_name = $row['access_group_name'];

                    echo "    <tr>";
                    echo "        <td>".$no++."</td>";
                    echo "        <td>".$row['id_user']."</td>";
                    echo "        <td><div>".$row['nm_user']."</div><small><i>$foreign_user</i></small></td>";
                    echo "        <td><div>".$row['nm_tipe_user']."</div><small><i>$access_name</i></small></td>";
                    echo "        <td><div>".$row['username']."</div><small><i>$foreign_nm</i></small></td>";
                    echo "        <td>".$row['role']."</td>";
                    echo "        <td align='center'>".$status."</td>"; //label-danger if not active
                    echo "        <td align='center'>";
                    ?>
                    <a href="home.php?mnu=umasteredit&id_user=<?php echo $row['id_user']; ?>" data-toggle='tooltip' title='edit' data-placement = "bottom">
                        <button class='btn-flat bg-blue'><i class='fa fa-pencil-square-o'></i> Edit</button>
                    </a>

                    <a href='registration/act-master-data.php?act=del&mod=umaster&id_user=<?php echo $row['id_user']; ?>' data-toggle='tooltip' title='delete' data-placement = "bottom" onclick="return confirm('Are you sure want delete this data?')">
                        <button class='btn-flat' style="background-color: #db2b2b; color: #fff; "><i class='fa fa-trash-o'></i> Delete</button>
                    </a>

                    <a href='registration/act-master-data.php?act=rst&mod=umaster&id_user=<?php echo $row['id_user']; ?>' data-toggle='tooltip' title='Reset Password' data-placement = "bottom" onclick="return confirm('Reset Password?')">
                        <button class='btn-flat bg-green'><i class='fa fa-refresh'></i> Reset Pwd</button>
                    </a>
                    <?php
                    echo "        </td>";
                    echo "    </tr>";
                }
            ?>
         
        </tbody>

    </table>


</div><!-- /.box-body -->
                        
<!-- MODAL ADD -->
<div class="container">
  
  <div class="modal fade" id="addModal" role="dialog">
    <div class="modal-dialog">
    
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Create Data User</h4>
            </div>
            <div class="modal-body">

            <form role=form name="myForm" id="myForm" onSubmit="return validateForm()" action="" method="post" enctype="multipart/form-data">

                <?php 
                    $id_u = autoNumber("id_user", "user"); // table, id, lebardata, lebar data yang diambil, start point, awalan
                ?>

                <!-- 
                <div class="form-group"> change get updatet user id -->
                    <!--
                    <label>ID User</label>
                    <input type="text" class="form-control" value ="<?php echo $id_u; ?>" disabled="true">
                    -->
                    <input type="hidden" id="id_user" name="id_user" value ="<?php echo $id_u; ?>">
                <!--
                </div> -->

                <div class="form-group">
                    <label>Nama User</label>
                    <input type="text" class="form-control" id="nm_user" name="nm_user" placeholder="ex. Hidrian Oma Suharman" focused required> 
                </div>

                <!-- SELECT OPTION ACTIVE IF IT USER LOGIN-->
                <?php
                    if ($_SESSION['role']=='admin'){
                        $list = "";
                    } else {
                         $list = "disabled='false'";
                    }
                ?>

                <div class="form-group">
                    <label>Tipe User</label>
                    <select class="form-control" id="tipe_user" name="tipe_user" <?php echo $list; ?> >
                        <?php
    
                            $query_exec1 = get_tipe_user();
                            while ($row = mysqli_fetch_assoc($query_exec1)) {
                                if ($row['id_tipe_user'] == "04"){
                                    break;
                                }
                                echo "<option value=".$row['id_tipe_user'].">".$row['nm_tipe_user']."</option>";
                            }
                        ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Username</label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Username for login" focused required> 
                </div>

                <div class="form-group">
                    <label>Access Group</label>
                    <select class="form-control selectpicker" name="id_access" data-live-search="true" required>
                        <?php         
                            $query_exec = get_all_assigned_access_group();
                            while ($row1 = mysqli_fetch_assoc($query_exec)) {
                                echo "<option value=".$row1['id_access_group'].">".$row1['access_group_name']."</option>";
                            }
                        ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" focused required> 
                </div>

                <div class="form-group">
                    <span id='message2'></span>
                </div>

                <div class="form-group">
                    <label>Confirm Password</label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confrim password" focused required>
                </div>

                <div class="form-group">
                    <span id='message'></span>
                </div>

            </div> 

                <div class="modal-footer">
                    <button type="submit" id="submit-add" name="submit-add" class="btn btn-flat btn-primary"><i class="fa fa-check-square-o"></i> Submit</button>
                </div>
            </form>
        </div>
      
    </div>
  </div>
  
</div>
<!-- MODAL ADD -->

<div class="container">
  
  <div class="modal fade" id="addModalVendor" role="dialog">
    <div class="modal-dialog">
    
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Create Data Vendor User</h4>
            </div>
            <div class="modal-body">

            <form role=form name="myForm" id="myForm" onSubmit="return validateForm()" action="" method="post" enctype="multipart/form-data">

                <?php 
                    $id_u = autoNumber("id_user", "user"); // table, id, lebardata, lebar data yang diambil, start point, awalan
                ?>

                <input type="hidden" id="id_user" name="id_user" value ="<?php echo $id_u; ?>">

                <div class="form-group">
                    <label>Select Vendor</label>
                    <select class="form-control selectpicker" name="id_vendor" data-live-search="true" required>
                        <?php         
                            $query_exec = get_all_vendor_active();
                            while ($row1 = mysqli_fetch_assoc($query_exec)) {
                                echo "<option value=".$row1['id_vendor'].">".$row1['id_vendor']." - ".$row1['nm_vendor']."</option>";
                            }
                        ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Username</label>
                    <input type="email" class="form-control" id="username" name="username" placeholder="Username for login" focused required> 
                </div>

                <div class="form-group">
                    <label>Access Group</label>
                    <select class="form-control selectpicker" name="id_access" data-live-search="true" required>
                        <?php         
                            $query_exec = get_all_assigned_access_group();
                            while ($row1 = mysqli_fetch_assoc($query_exec)) {
                                echo "<option value=".$row1['id_access_group'].">".$row1['access_group_name']."</option>";
                            }
                        ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" focused required> 
                </div>

                <div class="form-group">
                    <span id='message2'></span>
                </div>

                <div class="form-group">
                    <label>Confirm Password</label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confrim password" focused required>
                </div>

                <div class="form-group">
                    <span id='message'></span>
                </div>

            </div> 

                <div class="modal-footer">
                    <button type="submit" id="submit-add-vendor" name="submit-add-vendor" class="btn btn-flat btn-primary"><i class="fa fa-check-square-o"></i> Submit</button>
                </div>
            </form>
        </div>
      
    </div>
  </div>
  
</div>


<?php 
    
    if (isset($_POST['submit-add'])){

        $id_user        = $_POST['id_user'];
        $nm_user        = $_POST['nm_user'];
        $id_tipe_user   = $_POST['tipe_user'];
        $username       = $_POST['username'];
        $password       = $_POST['password'];
        $conf_pass      = $_POST['confirm_password'];
        $id_access_group = $_POST['id_access'];

        switch ($id_tipe_user) {
            case '00':
                $role = "proc";
                break;

            case '01':
                $role = "eng";
                break;

            case '02':
                $role = "qa";
                break;
            
            case '03':
                $role = "admin";
                break;

            case '04':
                $role = "vendor";
                break;

            default:
                break;
        }

        if (strlen($conf_pass) >= 5){

            insert_user_data($id_user, $nm_user, $id_tipe_user, $username, $password, $role, $id_access_group);

            //if insert_user_data is ok
                //get data email by user
                //if username is an email address
                    //send mail user activation to user by user id
                    //attach username and password on email body
                //endif
            //endif

            /*
            echo "<script>window.alert('Success create data');
                    window.location=('../view/home.php?mnu=umaster')
                  </script>";
            */

            echo '
                <script>
                swal({
                    title: "Success!",
                    text: "Success create data!",
                    type: "success",
                    customClass: \'swal-wide\',
                    allowOutsideClick: false
                })
                    .then(function() {
                    window.location = (\'../view/home.php?mnu=umaster\');
                });
                
                </script>
            ';

        } elseif (strlen($conf_pass) < 5) {

             //echo "<script> alert('Password minimum 5 character!')</script>";
            echo '
                <script>
                swal({
                    title: "Alert!",
                    text: "Password minimum 5 character!",
                    type: "warning",
                    customClass: \'swal-wide\',
                    allowOutsideClick: false
                });
                
                </script>
            ';
        }//elseif (strlen($conf_pass) < 5)
        
    }//if (isset($_POST['submit-add']))
    
?>

<?php

    
    if (isset($_POST['submit-add-vendor'])){
        
        $id_user        = $_POST['id_user'];
        
        $id_tipe_user   = "04";
        $username       = $_POST['username'];
        $password       = $_POST['password'];
        $conf_pass      = $_POST['confirm_password'];
        $id_access_group = $_POST['id_access'];
        $foreign_id     = $_POST['id_vendor'];
        $role = "vendor";   

        $query_exec = get_vendor_data_by_id($foreign_id);
        $row = mysqli_fetch_assoc($query_exec);
        $nm_user   = $row['allias'];

        if (strlen($conf_pass) >= 5){

            insert_user_vendor_data($id_user, $nm_user, $id_tipe_user, $username, $password, $role, $id_access_group, $foreign_id);

            echo '
                <script>
                swal({
                    title: "Success!",
                    text: "Success create data!",
                    type: "success",
                    customClass: \'swal-wide\',
                    allowOutsideClick: false
                })
                    .then(function() {
                    window.location = (\'../view/home.php?mnu=umaster\');
                });
                
                </script>
            ';

        } elseif (strlen($conf_pass) < 5) {

             //echo "<script> alert('Password minimum 5 character!')</script>";
            echo '
                <script>
                swal({
                    title: "Alert!",
                    text: "Password minimum 5 character!",
                    type: "warning",
                    customClass: \'swal-wide\',
                    allowOutsideClick: false
                });
                
                </script>
            ';
        }//elseif (strlen($conf_pass) < 5)

    }

?>
        
        <!-- jQuery 2.0.2 -->
        <script src="../jquery-2/jquery.min.js"></script>
        <!-- Bootstrap -->
        <script src="../js/bootstrap.min.js" type="text/javascript"></script>
        <!-- DATA TABES SCRIPT -->
        <!--
        <script src="../js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
        <script src="../js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
        -->

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

        <!-- AdminLTE App -->
        <script src="../js/AdminLTE/app.js" type="text/javascript"></script>

         <script>
            $('#password, #confirm_password').on('keyup', function () {
                if ($('#password').val().length < 5 || ($('#password').val() == "") || $('#confirm_password').val().length < 5 || ($('#confirm_password').val() == "")) {

                    $('#message2').html('<i class="fa fa-exclamation-circle"></i> Length: Min 5 char').css('color', 'red');
                     document.getElementById("submit-add").disabled = true;

                } else if ($('#password').val().length >= 5 && ($('#password').val() != "")) {

                    $('#message2').html('<i class="fa fa-check-circle-o"></i> Length: OK').css('color', 'green');
                    document.getElementById("submit-add").disabled = false;

                }
            });
        </script>

        <script>
            $('#password, #confirm_password').on('keyup', function () {
                if ($('#password').val() == $('#confirm_password').val() && ($('#password').val() != "" && $('#confirm_password').val() !== "")) {

                    $('#message').html('<i class="fa fa-check-circle-o"></i> Match').css('color', 'green');
                     document.getElementById("submit-add").disabled = false;

                } else if ($('#password').val() != $('#confirm_password').val() && ($('#password').val() != "" || $('#confirm_password').val() !== "")) {

                    $('#message').html('<i class="fa fa-exclamation-circle"></i> Not Match').css('color', 'red');
                     document.getElementById("submit-add").disabled = true;

                } else {

                    $('#message').html('').css('color', 'red');

                }
            });
        </script>

        <!-- page script -->
<!--
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
        -->

<script type="text/javascript">
    $(function() {
        $("#example2").dataTable( {
            dom: 'Bfrtip',
            buttons: [
                'copy', 'excel'
            ],
            "scrollX": true,
            "filter" : true,
            "lengthChange" : true,
            "sort"         : true,
            "paginate"     : true,
            "autowidth"    : false,
            "pagingType"   : "simple_numbers"
        } );
    });

</script>
       
    </body>
</html>