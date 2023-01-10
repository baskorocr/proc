<?php

require "lib/excel_reader.php";
include "../conn/conn.php";
include "data-model/my-query.php";

set_time_limit (400);

$conn = get_connection();

?>
           
<div class="box-header">
	<h3 class="box-title">Upload User Master Data</h3>
</div>

    <form role=form name="myForm" id="myForm" onSubmit="return validateForm()" action="home.php?mnu=usermstrupld" method="post" enctype="multipart/form-data">
        
        <div class="box-body">                            
            <div class="form-group">
               	<label for="exampleInputFile">Upload User Master Data</label>
               	<input type="file" id="vendordata" name="vendordata" disabled>
               	<p class="help-block">userdata.xls</p>
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
            </br>
                                        
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
                             $truncate ="TRUNCATE TABLE user";
                             mysqli_query($conn,$truncate);
                    };
                    
                //    import data excel mulai baris ke-6 (karena tabel xls hasil export dari SAP)
                    for ($i=6; $i<=$baris; $i++)
                    {
                        
                        //menghitung jumlah real data. Karena kita mulai pada baris ke-2, maka jumlah baris yang sebenarnya adalah 
                        //jumlah baris data dikurangi 1. Demikian juga untuk awal dari pengulangan yaitu i juga dikurangi 1
                        $barisreal = $baris-5;
                        $k = $i-5;
        
                        // menghitung persentase progress
                        $percent = intval($k/$barisreal * 100)."%";
 
                        // mengupdate progress
                        echo '<script language="javascript">
                        document.getElementById("progress").innerHTML="<div style=\"width:'.$percent.'; background-color:blue\">&nbsp;</div>";            
                        document.getElementById("info").innerHTML="'.$k.' data inserted of '.$barisreal.' ('.$percent.')";
                        </script>';

                        $date = date('Ymd');

                //       membaca data (kolom ke-1 sd terakhir)
                        $id_vendor        = $data->val($i, 2);
                        $vendor_nm        = $data->val($i, 3);
                        $allias           = $data->val($i, 4);
                        $street           = $data->val($i, 5);
                        $post_code        = $data->val($i, 6);
                        $city             = $data->val($i, 7);
                        $sales_person_1   = $data->val($i, 8);
                        $sales_person_2   ="";
                        $contact_num      = $data->val($i, 9);
                        $mail             = "";
                        $id_register      = $date.''.$k;
                 
                        $query = "INSERT INTO vendor(id_vendor,vendor_nm,allias,street,city,postcode,sales_person_1,sales_person_2,contact_num,mail,id_register) VALUES('$id_vendor             ','$vendor_nm','$allias','$street','$city','$post_code','$sales_person_1','$sales_person_2','$contact_num','$mail','$id_register')";            
                        $hasil = mysqli_query($conn,$query);               
                
                        if ($percent == '100%'){
                            echo '
                            <script>
                                document.getElementById("info").innerHTML="Please wait opening page data!";
                                window.location=("home.php?mnu=umaster");
                            </script>
                            ';
                        }
                    }
                    
                    //data yang masuk/jumlah all datax100%
                
                 
                if(!$hasil){
                //          jika import gagal
                          die(mysqli_error($conn));
                      }else{
                //          jika impor berhasil
                          echo "<script type='text/javascript'>Data berhasil diimpor.</script>";
                    }
                    
                //    hapus file xls yang udah dibaca
                    unlink($_FILES['vendordata']['name']);
                }
            ?>
    
    	</div><!-- /.box-body -->

        	<div class="box-footer">
        	    <button type="submit" id="submit" name="submit" class="btn btn-primary"><i class="fa fa-upload"></i> Upload</button>
        	</div>
    </form>



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
         
                if(!hasExtension('vendordata', ['.xls'])){
                    alert("Hanya file XLS (Excel 2003) yang diijinkan.");
                    return false;
                }
            }
        </script>

    </body>
</html>