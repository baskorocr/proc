<?php

//require "lib/excel_reader.php";
include "../conn/connection.php";
//include "data-model/my-query.php";

set_time_limit (400);

?>


<div class="box-header">
    <h3 class="box-title">View Uploaded Drawing & QIS</h3>
</div>
 
<div class="input-group">
    <input type="text" name="table_search" class="form-control input-sm pull-right" style="width: 150px; margin-top: 20px;" placeholder="Search"/>
        <div class="input-group-btn">
            <button class="btn btn-sm btn-default" style="margin-top: 20px; margin-right: 10px;"><i class="fa fa-search"></i></button>
        </div>
</div>        

<form role=form name="myForm" id="myForm" onSubmit="return validateForm()" action="" method="post" enctype="multipart/form-data">
    <div class="box-body">
                                        

            <table class="table table-striped">
                <th>Nama Project</th>
                <th>Nama Dokumen</th>
                <th>Jenis Dokumen</th>
                <th>Revisi</th>
                <th>Tanggal</th>
                <th>Uploader</th>
                <th>View</th>
                <th>Check </th>

                <tr>
                    <td>ADM 01</td>
                    <td>
                        <label for="exampleInputFile">Drawing 08129 ADM.pdf</label>  
                    </td>
                    <td>Drawing</td>
                    <td>Rev 0</td>
                    <td>06-08-2017</td>
                    <td>ENG01 - Riao</td>
                    <td>
                        <a href="data_upload/viewpdf.php?nm=CKP QIS"><i class="fa fa-eye"></i></a>
                    </td>
                    <td><input type="checkbox" required></td>
                </tr>
                <tr>
                    <td>ADM 02</td>
                    <td>
                        <label for="exampleInputFile">QIS 08129 ADM.pdf</label>
                    </td>
                    <td>QIS</td>
                    <td>Rev A</td>
                    <td>06-08-2017</td>
                    <td>ENG03 - Elvi</td>
                    <td>
                        <a href="data_upload/viewpdf.php?nm=CKP QIS"><i class="fa fa-eye"></i></a>
                    </td>
                    <td><input type="checkbox" required></td>
                </tr>
            </table>
                                    
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

    </body>
</html>