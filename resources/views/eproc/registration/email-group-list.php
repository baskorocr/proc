<?php
    include "master-data-query.php";
    include "master-data-func.php";
?>

<div class="box-header">
    <h3 class="box-title">Email List Group</h3>   

    <div class="pull-right box-tools">
        <!-- button with a dropdown -->
        <div class="btn-group">
            <a href="#" data-toggle="dropdown"><i class="fa fa-bars"></i></a>
            <ul class="dropdown-menu pull-right" role="menu">
                <li><a href="#addModal" data-toggle="modal" data-backdrop="static" data-keyboard="false">
                    <i class="fa fa-plus-circle"></i>Add Email List Group</a>
                </li>
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
                <th>Email</th>
                <th>Departement</th>
                <th>Name</th>
                <th>Last Changed by</th>
                <th>Last Changed</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
           <?php
                //PHP TAG
                $no =1;
                $query_exec = get_all_email_list_group();

                while ($row = mysqli_fetch_assoc($query_exec)) {

                    if ($row['active']=='A') {
                        $status = "<small class='label label-success'> Active</small>";
                    } elseif ($row['active']=='N') {
                        $status = "<small class='label label-danger'> Non-Active</small>";
                    }

                    if ($row['abrev'] == "") {
                        $abrev = "";
                    } else {
                        $abrev = "[".$row['dept_code']."] [".$row['abrev']."]";
                    }

                    $dateformat_chg = strtotime($row['last_changed']);
                    $last_changed = date("d.m.Y H:i", $dateformat_chg);

                    echo "    <tr>";
                    echo "        <td>".$no++."</td>";
                    echo "        <td>".$row['mail']."</td>";
                    echo "        <td><div>".$row['dept_desc']."</div><small>".$abrev."</small></td>";
                    echo "        <td>".$row['name']."</td>";
                    echo "        <td>".$row['nm_user']."</td>";
                    echo "        <td>".$last_changed."</td>";
                    echo "        <td align='left'>".$status."</td>";
                    echo "        <td align='center'>";
                    ?>
                    <a href="home.php?mnu=emailgrlistedit&mail=<?php echo $row['mail']; ?> &dept_code=<?php echo $row['dept_code']; ?>" data-toggle='tooltip' title='edit' data-placement = "bottom">
                        <button class='btn-flat bg-blue'><i class='fa fa-pencil-square-o'></i> Edit</button>
                    </a>

                    <a href='registration/act-master-data.php?act=del&mod=emailgrlist&mail=<?php echo $row['mail']; ?> &dept_code=<?php echo $row['dept_code']; ?>' data-toggle='tooltip' title='delete' data-placement = "bottom" onclick="return confirm('Are you sure want delete this data?')">
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
                <h4 class="modal-title">Create Email List Group</h4>
            </div>
            <div class="modal-body">

            <form role=form name="myForm" id="myForm" onSubmit="return validateForm()" action="" method="post" enctype="multipart/form-data">
                
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" class="form-control" id="mail" name="mail" placeholder="ex. osa.maliki@dp.dharmap.com" focused required> 
                </div>

                <div class="form-group">
                    <label>Departement</label>
                    <select class="form-control selectpicker" name="dept_code" data-live-search="true" required>
                        <option ></option>

                        <?php
                                    
                            $query_exec = get_all_email_group();

                            while ($row1 = mysqli_fetch_assoc($query_exec)) {
                                echo "<option value=".$row1['dept_code'].">[".$row1['dept_code']."] ".$row1['dept_desc']."</option>"; 
                            }
       
                        ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Email Holder Name</label>
                    <input type="text" class="form-control" id="email_name" name="email_name" placeholder="ex. Osa Maliki" required> 
                </div>

                <input type="hidden" class="form-control" id="id_user" name="id_user" placeholder="user" value="<?php echo $_SESSION['id_user'] ; ?>"> 

                <div class="modal-footer">
                    <button type="submit" id="submit-add" name="submit-add" class="btn btn-flat btn-primary"><i class="fa fa-check-square-o"></i> Create</button>
                </div>
            </form>
        </div>
      
    </div>
  </div>
  
</div>

<?php 
    
    if (isset($_POST['submit-add'])){

        $id_user    = $_POST['id_user'];
        $mail       = $_POST['mail'];
        $dept_code  = $_POST['dept_code'];
        $email_name = $_POST['email_name'];
        $active     = 'A';

        if ($id_user != "" ){

            insert_email_list_group($mail, $dept_code, $email_name, $active, $id_user);

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
                    window.location = (\'../view/home.php?mnu=emailgrlist\');
                });
                
                </script>
            ';

        } else {

            echo '
                <script>
                swal({
                    title: "Error!",
                    text: "You don/\'t have access to modify!",
                    type: "error",
                    customClass: \'swal-wide\',
                    allowOutsideClick: false
                });
                
                </script>
            ';
        }
        
    }//if (isset($_POST['submit-add']))
    
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

<script type="text/javascript">
    $(function() {
        $("#example2").dataTable( {
            /*
            dom: 'Bfrtip',
            buttons: [
                'copy', 'excel'
            ],
            */
            "scrollX": true,
            "filter" : true,
            "lengthChange" : false,
            "sort"         : true,
            "paginate"     : true,
            "autowidth"    : false,
            "pagingType"   : "simple_numbers"
        } );
    });

</script>
       
    </body>
</html>