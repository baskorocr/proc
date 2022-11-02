<?php
    include "master-data-query.php";
    include "master-data-func.php";
?>

<div class="box-header">
    <h3 class="box-title">Number Range</h3>   

    <div class="pull-right box-tools">
        <!-- button with a dropdown -->
        <div class="btn-group">
            <a href="#" data-toggle="dropdown"><i class="fa fa-bars"></i></a>
            <ul class="dropdown-menu pull-right" role="menu">
                <li><a href="#addModal" data-toggle="modal" data-backdrop="static" data-keyboard="false">
                    <i class="fa fa-plus-circle"></i>Add Number Range</a>
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
                <th>Doc Type</th>
                <th>Doc Year</th>
                <th>Number Low</th>
                <th>Number High</th>
                <th>Current Number</th>
                <th>Last Changed by</th>
                <th>Last Changed</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
           <?php
                //PHP TAG
                $no =1;
                $query_exec =get_all_number_range();

                while ($row = mysqli_fetch_assoc($query_exec)) {

                    $dateformat_chg = strtotime($row['last_changed']);
                    $last_changed = date("d.m.Y H:i", $dateformat_chg);

                    echo "    <tr>";
                    echo "        <td>".$no++."</td>";
                    echo "        <td>".$row['doc_type']."</td>";
                    echo "        <td>".$row['doc_year']."</td>";
                    echo "        <td>".$row['num_low']."</td>";
                    echo "        <td>".$row['num_high']."</td>";
                    echo "        <td>".$row['current_num']."</td>";
                    echo "        <td>".$row['nm_user']."</td>";
                    echo "        <td>".$last_changed."</td>";
                    echo "        <td align='center'>";
                    ?>
                    <a href="home.php?mnu=numrangeedit&doc_type=<?php echo $row['doc_type']; ?> &doc_year=<?php echo $row['doc_year']; ?>" data-toggle='tooltip' title='edit' data-placement = "bottom">
                        <button class='btn-flat bg-blue'><i class='fa fa-pencil-square-o'></i> Edit</button>
                    </a>

                    <a href='registration/act-master-data.php?act=del&mod=numrange&doc_type=<?php echo $row['doc_type']; ?> &doc_year=<?php echo $row['doc_year']; ?>' data-toggle='tooltip' title='delete' data-placement = "bottom" onclick="return confirm('Are you sure want delete this data?')">
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
                <h4 class="modal-title">Create Number Range</h4>
            </div>
            <div class="modal-body">

            <form role=form name="myForm" id="myForm" onSubmit="return validateForm()" action="" method="post" enctype="multipart/form-data">
                
                <input type="hidden" class="form-control" id="id_user" name="id_user" placeholder="user" value="<?php echo $_SESSION['id_user'] ; ?>"> 

                <div class="form-group">
                    <label>Document Type</label>
                    <select class="form-control selectpicker" name="doc_type" data-live-search="true" focused required>
                        <option value="iso">iso</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Document Year</label>
                    <input type="number" class="form-control" id="doc_year" name="doc_year" placeholder="ex. 2022" maxlength="4" focused required> 
                </div>

                <div class="form-group">
                    <label>Low Number</label>
                    <input type="number" class="form-control" id="num_low" name="num_low" placeholder="ex. 00000" maxlength="5" focused required> 
                </div>

                <div class="form-group">
                    <label>High Number</label>
                    <input type="number" class="form-control" id="num_high" name="num_high" placeholder="ex. 99999" maxlength="5" focused required> 
                </div>

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

        $id_user      = $_POST['id_user'];
        $doc_type     = $_POST['doc_type'];
        $doc_year     = $_POST['doc_year'];
        $num_low     = $_POST['num_low'];
        $num_high     = $_POST['num_high'];

        if ($id_user != "" ){

            insert_number_range($doc_type, $doc_year, $num_low, $num_high, $id_user);

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
                    window.location = (\'../view/home.php?mnu=numrange\');
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
        }//elseif (strlen($conf_pass) < 5)
        
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