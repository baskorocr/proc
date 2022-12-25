<?php
    include "purchasing_process/purch-proc-query.php";
    //include "master-data-func.php";
?>

<div class="box-header">
    <h3 class="box-title">PDA User Master</h3>   

    <div class="pull-right box-tools">
        <!-- button with a dropdown -->
        <div class="btn-group">
            <a href="#" data-toggle="dropdown"><i class="fa fa-bars"></i></a>
            <ul class="dropdown-menu pull-right" role="menu">
                <li><a href="#addModal" data-toggle="modal" data-backdrop="static" data-keyboard="false">
                    <i class="fa fa-plus-circle"></i>Create PDA User</a>
                </li>
                <!--
                <li><a href="home.php?mnu=usermstrupld"><i class="fa fa-upload"></i>Upload</a></li>
                -->
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
                <th>User Login</th>
                <th>Full Name</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
           <?php
                //PHP TAG
                $no =1;
                $query_exec = get_all_user_pda_data();

                while ($row = mysqli_fetch_assoc($query_exec)) {

                    if ($row['user_stat']=='A') {
                        $status = "<small class='label label-success'> Active</small>";
                    } elseif ($row['user_stat']=='N') {
                        $status = "<small class='label label-danger'> Non-Active</small>";
                    }

                    echo "    <tr>";
                    echo "        <td>".$no++."</td>";
                    echo "        <td>".$row['id']."</td>";
                    echo "        <td><div>".$row['username']."</div></td>";
                    echo "        <td>".$row['full_name']."</td>";
                    echo "        <td align='center'>".$status."</td>"; //label-danger if not active
                    echo "        <td align='center'>";
                    ?>
                    <a href="home.php?mnu=pdamasteredit&id=<?php echo $row['id']; ?>" data-toggle='tooltip' title='edit' data-placement = "bottom">
                        <button class='btn-flat bg-blue'><i class='fa fa-pencil-square-o'></i> Edit</button>
                    </a>

                    <a href='home.php?mnu=pdaccs&act=del&mod=pdamaster&id=<?php echo $row['id']; ?>' data-toggle='tooltip' title='delete' data-placement = "bottom" onclick="return confirm('Are you sure want delete this data?')">
                        <button class='btn-flat' style="background-color: #db2b2b; color: #fff; "><i class='fa fa-trash-o'></i> Delete</button>
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
                <h4 class="modal-title">Create PDA User</h4>
            </div>
            <div class="modal-body">

            <form role=form name="myForm" id="myForm" onSubmit="return validateForm()" action="" method="post" enctype="multipart/form-data">

                <div class="form-group">
                    <label>ID / NPK</label>
                    <input type="text" class="form-control" id="id_pda_user" name="id_pda_user" placeholder="11174576"  focused required> 
                </div>

                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" class="form-control" id="full_name" name="full_name" placeholder="ex. Hidrian Oma Suharman" required> 
                </div>

                <div class="form-group">
                    <label>User Login</label>
                    <input type="text" class="form-control" id="user_login" name="user_login" placeholder="User for PDA login" required> 
                </div>

                <div class="form-group">
                    <label>PIN</label>
                    <input type="password" class="form-control" id="pin" name="pin" placeholder="ex. 123456" maxlength="6" required> 
                </div>

                <div class="form-group">
                    <span id='message2'></span>
                </div>

                <div class="form-group">
                    <label>Confirm PIN</label>
                    <input type="password" class="form-control" id="confirm_pin" name="confirm_pin" placeholder="Confrim pin" maxlength="6" required>
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

<?php  
    
    if (isset($_POST['submit-add'])){

        $id_pda_user    = $_POST['id_pda_user'];
        $username       = $_POST['user_login'];
        $full_name      = $_POST['full_name'];
        $pin            = $_POST['pin'];
        $conf_pin       = $_POST['confirm_pin'];

        if (strlen($conf_pin) == 6){

            insert_user_pda_data($id_pda_user, $username, $pin, $full_name);

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
                    window.location = (\'../view/home.php?mnu=pdaccs\');
                });
                
                </script>
            ';

        } elseif (strlen($conf_pin) < 6) {

             //echo "<script> alert('Password minimum 5 character!')</script>";
            echo '
                <script>
                swal({
                    title: "Alert!",
                    text: "PIN has to have 6 digit of numbers!",
                    type: "warning",
                    customClass: \'swal-wide\',
                    allowOutsideClick: false
                });
                
                </script>
            ';
        }//elseif (strlen($conf_pass) < 5)
        
    }//if (isset($_POST['submit-add']))


    if(isset($_GET['mnu']) && isset($_GET['act'])){

          if($_GET['mnu'] == "pdaccs" && $_GET['act']== "del"){

            $id = $_GET['id'];

            delete_pda_user_access($id);

            echo '
                <script>
                swal({
                    title: "Success!",
                    text: "Success delete data!",
                    type: "success",
                    customClass: \'swal-wide\',
                    allowOutsideClick: false
                })
                    .then(function() {
                    window.location = (\'../view/home.php?mnu=pdaccs\');
                });
                
                </script>
            ';

          }

    }
    
?>
        
        <!-- jQuery 2.0.2 -->
        <script src="../jquery-2/jquery.min.js"></script>
        <!-- Bootstrap -->
        <script src="../js/bootstrap.min.js" type="text/javascript"></script>
        <!-- DATA TABES SCRIPT -->

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
            $('#pin, #confirm_pin').on('keyup', function () {
                if ($('#pin').val().length < 6 || ($('#pin').val() == "") || $('#confirm_pin').val().length < 6 || ($('#confirm_pin').val() == "")) {

                    $('#message2').html('<i class="fa fa-exclamation-circle"></i> Length: Min 6 digit number').css('color', 'red');
                     document.getElementById("submit-add").disabled = true;

                } else if ($('#pin').val().length == 6 && ($('#pin').val() != "")) {

                    $('#message2').html('<i class="fa fa-check-circle-o"></i> Length: OK').css('color', 'green');
                    document.getElementById("submit-add").disabled = false;

                }
            });
        </script>

        <script>
            $('#pin, #confirm_pin').on('keyup', function () {
                if ($('#pin').val() == $('#confirm_pin').val() && ($('#pin').val() != "" && $('#confirm_pin').val() !== "")) {

                    $('#message').html('<i class="fa fa-check-circle-o"></i> Match').css('color', 'green');
                     document.getElementById("submit-add").disabled = false;

                } else if ($('#pin').val() != $('#confirm_pin').val() && ($('#pin').val() != "" || $('#confirm_pin').val() !== "")) {

                    $('#message').html('<i class="fa fa-exclamation-circle"></i> Not Match').css('color', 'red');
                     document.getElementById("submit-add").disabled = true;

                } else {

                    $('#message').html('').css('color', 'red');
                }
            });
        </script>


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