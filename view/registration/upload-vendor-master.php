<?php

require "lib/excel_reader.php";
//include "../conn/conn.php";
include "master-data-query.php";
include "master-data-func.php";

set_time_limit (400);

$conn = get_connection();

?>
           
<div class="box-header">
	<h3 class="box-title">Upload Vendor Master Data</h3>
</div>

    <form role=form name="myForm" id="myForm" onSubmit="return validateForm()" action="home.php?mnu=vdrmstdtupld" method="post" enctype="multipart/form-data">
        
        <div class="box-body">                            
            <div class="form-group">
               	<label for="exampleInputFile">Upload Data Vendor</label>
               	<input type="file" id="vendordata" name="vendordata" accept=".xls,.xlsx">
               	<p class="help-block">vendordata.xls</p>
               	<!--
                <label><input type="checkbox" name="drop" value="1" /> <u>Empty table in database?</u> </label>
                -->
            </div>                                        

        <?php
        //jika tombol import ditekan
        if(isset($_POST['submit'])){
        ?>
                                        
            <div id="progress" style="width:100%;border:1px solid #ccc;"></div>
            <div id="info"></div>
            <br>
                                        
                <?php
                    $target = basename($_FILES['vendordata']['name']) ;
                    move_uploaded_file($_FILES['vendordata']['tmp_name'], $target);
                 
                // tambahkan baris berikut untuk mencegah error is not readable
                    chmod($_FILES['vendordata']['name'],0777);
                    
                    $data = new Spreadsheet_Excel_Reader($_FILES['vendordata']['name'],false);
                    
                //    menghitung jumlah baris file xls
                    $baris = $data->rowcount($sheet_index=0);
                    
                //    jika kosongkan data dicentang jalankan kode berikut
                    $drop = isset( $_POST["drop"] ) ? $_POST["drop"] : 0 ;
                    if($drop == 1){
                //             kosongkan tabel
                             $truncate ="TRUNCATE TABLE vendor";
                             mysqli_query($conn,$truncate);
                    };
                    
                //    import data excel mulai baris ke-6 (karena tabel xls hasil export dari SAP)
                    for ($i=6; $i<=$baris; $i++)
                    {
                        
                        //menghitung jumlah real data.
                        $barisreal = $baris-5;
                        $k = $i-5;
        
                        // menghitung persentase progress
                        $percent = intval($k/$barisreal * 100)."%";
 
                        // mengupdate progress
                        echo '<script language="javascript">
                        document.getElementById("progress").innerHTML="<div style=\"width:'.$percent.'; background-color:#0080ff\">&nbsp;</div>";
                        document.getElementById("info").innerHTML="'.$k.' data inserted of '.$barisreal.' ('.$percent.')";
                        </script>';

                        $date = date('Ymd');

                        //membaca data (kolom ke-1 sd terakhir)
                        $id_vendor        = $data->val($i, 2);
                        $nm_vendor        = strtoupper($data->val($i, 3));
                        $allias           = strtoupper($data->val($i, 4));
                        $street           = $data->val($i, 5);
                        $post_code        = $data->val($i, 6);
                        $city             = $data->val($i, 7);
                        $sales_person_1   = $data->val($i, 8);
                        $sales_person_2   ="";
                        $contact_num      = $data->val($i, 9);
                        $mail             = "";
                        $id_register      = $date.''.$k;

                        $id_user          = autoNumber("id_user", "user");
                        $nm_user          = strtoupper($allias);
                        $id_tipe_user     = "04";
                        //$pass             = "admin".strtolower($allias);
                        $pass             = "Dharma008";
						$foreign_id		  = $id_vendor;
						
                        //$query_exec = get_vendor_data_by_id($id_vendor);
                        //$row = mysql_fetch_assoc($query_exec);

                        //if ($id_vendor != $row['id_vendor']){
                            insert_vendor_data($id_vendor, $nm_vendor, $allias, $street, $id_user);
                            insert_vendor_user_data($id_user, $nm_user, $id_tipe_user, $allias, $pass, "vendor", 'N', $foreign_id);
                        //}

                        if ($percent == '100%'){
                            echo '
                            <script>
                                document.getElementById("info").innerHTML="Please wait opening page data!";
                                window.location=("home.php?mnu=vmaster");
                            </script>
                            ';
                        }
                    }

                    //hapus file xls yang sudah dibaca
                    unlink($_FILES['vendordata']['name']);
                }
                
            ?>
    
    	</div><!-- /.box-body -->

        	<div class="box-footer">
        	    <button type="submit" id="submit" name="submit" class="btn btn-primary"><i class="fa fa-upload"></i> Upload</button>
        	</div>
    </form>

<script src="../jquery-2/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="../js/bootstrap.min.js" type="text/javascript"></script>
<!-- AdminLTE App -->
<script src="../js/AdminLTE/app.js" type="text/javascript"></script>

        <script type="text/javascript">
            //validasi form (hanya file .xls yang diijinkan)
            function validateForm()
            {
                function hasExtension(inputID, exts) {
                    var fileName = document.getElementById(inputID).value;
                    return (new RegExp('(' + exts.join('|').replace(/\./g, '\\.') + ')$')).test(fileName);
                }
         
                if(!hasExtension('vendordata', ['.xls'])){
                    alert("Only XLS (Excel 2003) allowed!");
                    return false;
                }

                swal({
                    title: 'Uploading your data',
                    text: 'It may take a little longer, depends on your data...',
                    allowOutsideClick: false,
                    onOpen: function () {
                        swal.showLoading()
                    }
                })
            }
        </script>

<!--
    </body>
</html>
-->