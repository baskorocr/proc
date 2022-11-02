<?php
    include "master-data-query.php";
    include "master-data-func.php";
    //include "lib/function.php";

?>

<div class="box-header">
    <h3 class="box-title">Vendor Master</h3>   

    <div class="pull-right box-tools">
        <!-- button with a dropdown -->
        <div class="btn-group">
            <a href="#" data-toggle="dropdown"><i class="fa fa-bars"></i></a>
            <ul class="dropdown-menu pull-right" role="menu">
                <li><a href="#addModal" data-toggle="modal" data-backdrop="static" data-keyboard="false">
                    <i class="fa fa-plus-circle"></i>Create</a>
                </li>
                <li><a href="home.php?<?php echo token(); ?>mnu=vdrmstdtupld<?php echo token2(); ?>">
                    <i class="fa fa-upload"></i>Upload</a>
                </li>
            </ul>
            <?php
                //$r = autonum("vendor","id_vendor",4,4,0,"");
                //echo '21'.$r;
            ?>
        </div>
    </div><!-- /. tools -->   

</div><!-- /.box-header -->
<hr style="margin-top: 1px;">

<div class="box-body table-responsive">                        
    <table id="example2" class="table table-bordered table-striped table-hover display nowrap">
                                
        <thead>
            <tr>
                <th>No</th>
                <th>ID Vendor</th>
				<th>Purch Org</th>
                <th>Vendor Name</th>
                <th>Email</th>
                <th>Allias</th>
                <th>Street</th>
                <th>District</th>
                <th>Post Code</th>
                <th>City</th>
                <th>Country</th>
                <th>Region</th>
                <th>Phone 1</th>
                <th>VAT Reg.</th>
                <th>Order Curr</th>
                <th>Pay Term</th>
                <th>Sales Person</th>
                <th>Phone 2</th>  
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>

       
        <tbody>   
            <?php
                //PHP TAG
				
                $no =1;
                $query_exec = get_all_vendor_data_by_acscode(); //get_all_vendor_data();

                while ($row = mysqli_fetch_assoc($query_exec)) {

                    if ($row['status_vendor']=='A') {
                        $status = "<small class='label label-success'> Active</small>";
                    } elseif ($row['status_vendor']=='N') {
                        $status = "<small class='label label-danger'> Non-Active</small>";
                    } else {
						$status = "<small class='label label-default'> Unknown</small>";
					}


                    if ( $_SESSION['role']== "admin") {
                        //$btn_act = "";
                        $btn_act1 = "";
                        $btn_act2 = "";
                    } else {
                        //$btn_act = "disabled";
                        $btn_act1 = "<!--";
                        $btn_act2 = "-->";
                    }

                    if (filter_var($row['vend_email'], FILTER_VALIDATE_EMAIL))
                    {
                        $user_email = $row['vend_email'];
                    } else
                    {
                        $user_email = "-";
                    }

                    if ($user_email == "-"){
                        if (filter_var($row['username'], FILTER_VALIDATE_EMAIL))
                        {
                            $user_email = $row['username'];
                        } else
                        {
                            $user_email = "-";
                        }
                    }

                    echo "    <tr>";
                    echo "        <td>".$no++."</td>";
                    echo "        <td>".$row['id_vendor']."</td>";
					echo "        <td>".$row['purch_org']."</td>";
                    echo "        <td>".$row['nm_vendor']."</td>";
                    echo "        <td>".$user_email."</td>";
                    echo "        <td>".$row['allias']."</td>";
                    echo "        <td>".$row['street']."</td>";
                    echo "        <td>".$row['district']."</td>";
                    echo "        <td>".$row['postal_code']."</td>";
                    echo "        <td>".$row['city']."</td>";
                    echo "        <td>".$row['country']."</td>";
                    echo "        <td>".$row['region']."</td>";
                    echo "        <td>".$row['phone_1']."</td>";
                    echo "        <td>".$row['vat_reg']."</td>";
                    echo "        <td>".$row['order_curr']."</td>";
                    echo "        <td>".$row['pay_term']."</td>";
                    echo "        <td>".$row['sales_person']."</td>";
                    echo "        <td>".$row['phone_2']."</td>";
                    echo "        <td align='center'>".$status."</td>"; //label-danger if not active
                    echo "        <td align='center'>";
            ?>
                                    <a href="home.php?mnu=vmasteredit&id_vendor=<?php echo $row['id_vendor']; ?>" data-toggle='tooltip' title='edit'>
                                        <button class='btn-flat bg-blue'><i class='fa fa-pencil-square-o'></i> </button>
                                    </a>
                                    
                                <?php echo $btn_act1; ?>
                                    <a href='registration/act-master-data.php?act=del&mod=vmaster&id_vendor=<?php echo $row['id_vendor']; ?>&id_user=<?php echo $row['id_user']; ?>' data-toggle='tooltip' title='delete' onclick="return confirm('Apakah anda yakin akan menghapus data ini?')">
                                        <button class='btn-flat' style="background-color: #db2b2b; color: #fff; "><i class='fa fa-trash-o'></i></button>
                                    </a>
                                <?php echo $btn_act2; ?>
                <?php
                    echo          "</td>";
                    echo "</tr>";
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
                <h4 class="modal-title">Create Data Vendor</h4>
            </div>
            <div class="modal-body">

            <form role=form name="myForm" id="myForm" onSubmit="return validateForm()" action="" method="post" enctype="multipart/form-data">

                <?php 
                    //$id_vendor = "21".autonum("vendor","id_vendor",4,4,0,"");
                    $id_user = autoNumber("id_user", "user");
					
					$id_vendor = "";
                    $id_user = "";
					
                ?>

                <div class="form-group"> <!-- change get updated user id -->
                    <!--
                    <label>ID Vendor</label>
                    <input type="text" class="form-control" value ="<?php echo $id_vendor; ?>" disabled="true">
                    -->
                    <input type="hidden" id="id_vendor" name="id_vendor" value ="<?php echo $id_vendor; ?>">
                </div>

                <div class="form-group">
                    <label>Nama Vendor</label>
                    <input type="text" class="form-control" id="nm_vendor" name="nm_vendor" placeholder="Vendor Name, PT" maxlength="100" focused required> 
                </div>

                <div class="form-group">
                    <label>Allias</label>
                    <input type="text" class="form-control" id="allias" name="allias" placeholder="(ex: AMPJKT)" maxlength="10" required> 
                </div>

                <div class="form-group">
                    <label>Street</label>
                    <input type="text" class="form-control" id="street" name="street" placeholder="Jakarta 89" maxlength="100" required> 
                </div>

                <!-- SELECT OPTION ACTIVE IF IT USER LOGIN-->
                <?php
                    if ($_SESSION['role']=='admin'){
                        $list = "";
                    } else {
                         $list = "disabled='false'";
                    }
                ?>

                <!--
                <div class="form-group">
                    <label>Status User</label>
                    <select class="form-control" id="status_vendor" name="status_vendor" <?php echo $list; ?> >
                        <option value="A">Active</option>
                        <option value="N">Not-active</option>
                    </select>
                </div>
                -->

                <input type="hidden" id="status_vendor" name="status_vendor" value ="A">

                <div class="form-group">
                <!--
                    <label>ID User</label>
                    <input type="text" class="form-control" value="<?php echo $id_user; ?>" disabled>
                -->
                    <input type="hidden" id="id_user" name="id_user" value ="<?php echo $id_user; ?>">
                </div> 

            </div> 

                <div class="modal-footer">
                    <button type="submit" name="submit-add" class="btn btn-primary"><i class="fa fa-check-square-o"></i> Submit</button>
                </div>
            </form>
        </div>
      
    </div>
  </div>
  
</div>                   

<?php 
    if (isset($_POST['submit-add'])){

        $id_vendor      = $_POST['id_vendor'];
        $nm_vendor      = strtoupper($_POST['nm_vendor']);
        $allias         = strtoupper($_POST['allias']);
        $street         = $_POST['street'];

        $id_user        = $_POST['id_user'];
        $nm_user        = strtoupper($_POST['allias']);
        $pass           = "admin".strtolower($_POST['allias']);
        $id_tipe_user   = "04"; //vendor user

        insert_vendor_data($id_vendor, $nm_vendor, $allias, $street, $id_user);
        insert_user_data($id_user, $nm_user, $id_tipe_user, $allias, $pass, "vendor");
        //echo "<script>window.location=('../view/home.php?mnu=vmaster')</script>";

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
                    window.location = (\'../view/home.php?mnu=vmaster\');
                });
                
                </script>
            ';
    }
?>
       
    <!-- ============ SCRIPT ================= --> 
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
				 dom: 'Bfrtip',
            buttons: [
                'excel'
            ],
            "scrollX": true,
                "bPaginate": true,
                "bLengthChange": false,
                "bFilter": true,
                "bSort": true,
                "bInfo": true,
                "bAutoWidth": false,
                "bProcessing": true
            });
        });
    </script>

    <script>
        $(document).ready( function() {
            $('#example3').dataTable( {
                "bPaginate": true,
                "bLengthChange": true,
                "bFilter": true,
                "bSort": true,
                "bInfo": true,
                "bAutoWidth": false,
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": "../lib/dt_vendor_server_processing.php"
            } );
        } );
    </script>

    <!-- ============ SCRIPT ================= --> 