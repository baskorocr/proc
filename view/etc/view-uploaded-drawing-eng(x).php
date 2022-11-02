<?php

//require "lib/excel_reader.php";
//include "../conn/connection.php";
//include "data-model/my-query.php";

include "project-mgt-query.php";
include "project-mgt-func.php";

set_time_limit (400);

?>


<div class="box-header">
    <h3 class="box-title">Check Uploaded Document Vendor</h3>
</div>


<div class="box-body"> 
        <div class="form-group">
        <label>Choose Project</label>
            <select class="form-control selectpicker" name="id_project" data-live-search="true" required>
                <?php      
                    $query_exec1 = get_unassigned_project_data();
                            
                    while ($row1 = mysqli_fetch_assoc($query_exec1)) {
                        echo "<option value=".$row1['id_project'].">".$row1['nm_project']."</option>";
                    }      
                ?>
            </select>

            <div class="form-group">
                <a href =""><button type="submit" id="submit" name="submit" class="btn btn-primary"><i class="fa fa-search"></i> Search</button></a>
            </div>
        </div>
</div>    

<div class="box box-body box-primary">
<label>Project Document List</label>   
        <table id="example2" class="table table-bordered table-striped">
            <thead>
                <th>No.</th>
                <th>Project Name</th>
                <th>Product Name</th>
                <th>Part Name</th>
                <th>Nama Dokumen</th>
                <th>Jenis Dokumen</th>
                <th>Uploaded date</th>
                <th>Uploader</th>
                <th>View</th>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>K81</td>
                    <td>Product A</td>
                    <td>Part 01</td>
                    <td>
                        <label for="exampleInputFile">Standar Packing.pdf</label>  
                    </td>
                    <td>Standar Packing</td>
                    <td>06-08-2017</td>
                    <td>Vendor</td>
                    <td>
                        <a href="data_upload/viewpdf.php?nm=CKP QIS"><i class="fa fa-eye"></i></a>
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>K81</td>
                    <td>Product A</td>
                    <td>Part 01</td>
                    <td>
                        <label for="exampleInputFile">Mill Sheet.pdf</label>
                    </td>
                    <td>Mill Sheet</td>
                    <td>06-08-2017</td>
                    <td>Vendor</td>
                    <td>
                        <a href="data_upload/viewpdf.php?nm=CKP QIS"><i class="fa fa-eye"></i></a>
                    </td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>K81</td>
                    <td>Product A</td>
                    <td>Part 01</td>
                    <td>
                        <label for="exampleInputFile">PQCS.pdf</label>
                    </td>
                    <td>PQCS</td>
                    <td>06-08-2017</td>
                    <td>Vendor</td>
                    <td>
                        <a href="data_upload/viewpdf.php?nm=CKP QIS"><i class="fa fa-eye"></i></a>
                    </td>
                </tr>
            </tbody>
        </table>
        </br>
</div>

<form role=form name="myForm" id="myForm" onSubmit="return validateForm()" action="" method="post" enctype="multipart/form-data">
    <div class="box box-body box-primary">  

    <div class="box-header">
        <h4 class="box-title">Document for Project [Project Name]</h3>
    </div>

    <?php 
        if($_SESSION['role'] == "proc") { 
            $active_proc    = "required";
            $active_qa      = "disabled";
        } elseif($_SESSION['role'] == "qa"){
            $active_proc    = "disabled";
            $active_qa      = "required";
        } elseif($_SESSION['role'] == "vendor"){
            $active_proc    = "disabled";
            $active_qa      = "disabled";
        } elseif($_SESSION['role'] == "vendor") {
            $active_proc    = "required";
            $active_qa      = "required";
        }  

    ?>

    <div class="form-group">
        
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="pull-right header"><i class="fa fa-th"></i></li>
                <li class="active"><a href="#tab_1-1" data-toggle="tab">Prod A - Part 01</a></li>
                <li><a href="#tab_2-2" data-toggle="tab">Prod A - Part 02</a></li>
            </ul>

        <div class="tab-content">
            <div class="tab-pane active" id="tab_1-1">
                                       
                <label>1. Check list for Document Standar Packing [Part 01]</label>   
                <table class="table table-bordered table-striped">
                    <thead>
                        <th>Check Params</th>
                        <th>Check by Proc</th>
                        <th>Check by QA</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td><label for="exampleInputFile">Signature</label></td>
                            <td><input type="checkbox" <?php echo  $active_proc; ?> ></td>
                            <td><input type="checkbox" <?php echo  $active_qa; ?> ></td>
                        </tr>
                        <tr>
                            <td><label for="exampleInputFile">Signature</label></td>
                            <td><input type="checkbox" <?php echo  $active_proc; ?> ></td>
                            <td><input type="checkbox" <?php echo  $active_qa; ?> ></td>
                        </tr>
                        <tr>
                            <td><label for="exampleInputFile">Signature</label></td>
                            <td><input type="checkbox" <?php echo  $active_proc; ?> ></td>
                            <td><input type="checkbox" <?php echo  $active_qa; ?> ></td>
                        </tr>
                    </tbody>
                </table>
                </br>

                <label>2. Check list for Document Mill sheet [Part 01]</label>   
                <table class="table table-bordered table-striped">
                    <thead>
                        <th>Check Params</th>
                        <th>Check by Proc</th>
                        <th>Check by QA</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td><label for="exampleInputFile">Signature</label></td>
                            <td><input type="checkbox" <?php echo  $active_proc; ?> ></td>
                            <td><input type="checkbox" <?php echo  $active_qa; ?> ></td>
                        </tr>
                        <tr>
                            <td><label for="exampleInputFile">Signature</label></td>
                            <td><input type="checkbox" <?php echo  $active_proc; ?> ></td>
                            <td><input type="checkbox" <?php echo  $active_qa; ?> ></td>
                        </tr>
                        <tr>
                            <td><label for="exampleInputFile">Signature</label></td>
                            <td><input type="checkbox" <?php echo  $active_proc; ?> ></td>
                            <td><input type="checkbox" <?php echo  $active_qa; ?> ></td>
                        </tr>
                    </tbody>
                </table>
                </br>

                <label>3. Check list for Document PQCS [Part 01]</label>   
                <table class="table table-bordered table-striped">
                    <thead>
                        <th>Check Params</th>
                        <th>Check by Proc</th>
                        <th>Check by QA</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td><label for="exampleInputFile">Signature</label></td>
                            <td><input type="checkbox" <?php echo  $active_proc; ?> ></td>
                            <td><input type="checkbox" <?php echo  $active_qa; ?> ></td>
                        </tr>
                        <tr>
                            <td><label for="exampleInputFile">Signature</label></td>
                            <td><input type="checkbox" <?php echo  $active_proc; ?> ></td>
                            <td><input type="checkbox" <?php echo  $active_qa; ?> ></td>
                        </tr>
                        <tr>
                            <td><label for="exampleInputFile">Signature</label></td>
                            <td><input type="checkbox" <?php echo  $active_proc; ?> ></td>
                            <td><input type="checkbox" <?php echo  $active_qa; ?> ></td>
                        </tr>
                    </tbody>
                </table>
                </br>
        </div>


        <div class="tab-pane" id="tab_2-2">
           
           <label>1. Check list for Document Standar Packing [Part 02]</label>   
                <table class="table table-bordered table-striped">
                    <thead>
                        <th>Check Params</th>
                        <th>Check by Proc</th>
                        <th>Check by QA</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td><label for="exampleInputFile">Signature</label></td>
                            <td><input type="checkbox" <?php echo  $active_proc; ?> ></td>
                            <td><input type="checkbox" <?php echo  $active_qa; ?> ></td>
                        </tr>
                        <tr>
                            <td><label for="exampleInputFile">Signature</label></td>
                            <td><input type="checkbox" <?php echo  $active_proc; ?> ></td>
                            <td><input type="checkbox" <?php echo  $active_qa; ?> ></td>
                        </tr>
                        <tr>
                            <td><label for="exampleInputFile">Signature</label></td>
                            <td><input type="checkbox" <?php echo  $active_proc; ?> ></td>
                            <td><input type="checkbox" <?php echo  $active_qa; ?> ></td>
                        </tr>
                    </tbody>
                </table>
                </br>

        </div><!-- /.tab-pane -->
        
        </div><!-- /.tab-content -->
    </div><!-- nav-tabs-custom -->

    </div>
                                    
    </div><!-- /.box-body -->

    <div class="box-footer">
        <button type="submit" id="submit" name="submit" class="btn btn-primary"><i class="fa fa-check"></i> Confirm</button>
    </div>
</form>
     
        <!-- jQuery 2.0.2 
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
        -->
         <script src="../jquery/jquery.min.js"></script>
        <!-- Bootstrap -->
        <script src="../js/bootstrap.min.js" type="text/javascript"></script>
        <!-- AdminLTE App -->
        <script src="../js/AdminLTE/app.js" type="text/javascript"></script>

        <script type="text/javascript">
        //    validasi form (hanya file .xls yang diijinkan)
            function validateForm()
            {
                function hasExtension(inputID, exts) {
                    var fileName = document.getElementById(inputID).value;
                    return (new RegExp('(' + exts.join('|').replace(/\./g, '\\.') + ')$')).test(fileName);
                }
         
                if(!hasExtension('vendordata', ['.pdf'])){
                    alert("Hanya file PDF yang diijinkan.");
                    return false;
                }
            }
        </script>

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

    </body>
</html>