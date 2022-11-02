<?php

require "lib/excel_reader.php";
include "../conn/connection.php";
include "data-model/my-query.php";

set_time_limit (400);

$conn = get_connection();

?>


                                <div class="box-header">
                                    <h3 class="box-title">Upload Document Engineering</h3>
                                </div><!-- /.box-header -->
                                <!-- form start -->
                                <form role=form name="myForm" id="myForm" onSubmit="return validateForm()" action="" method="post" enctype="multipart/form-data">
                                    <div class="box-body">
                                        
                                        <table class="table table-bordered table-striped table-hover">
                                            <th>Document name</th>
                                            <th>Upload File</th>
                                            <th>Status</th>
                                             <tr>
                                                <td><label for="exampleInputFile">Standar Packing</label></td>
                                                <td><input type="file" id="vendordata" name="vendordata" required>
                                                    <p class="help-block">standarpacking.pdf</p>
                                                </td>
                                                <td align="center"><i class="fa fa-fw fa-check-square-o"></i></td>
                                             </tr>
                                             <tr>
                                                <td><label for="exampleInputFile">Tensile Test</label></td>
                                                <td><input type="file" id="vendordata" name="vendordata" required>
                                                     <p class="help-block">Tensile.pdf</p>
                                                </td>
                                                <td align="center"><i class="fa fa-warning"></i></td>
                                             </tr>
                                             <tr>
                                                <td><label for="exampleInputFile">Spectro Test</label></td>
                                                <td><input type="file" id="vendordata" name="vendordata" required>
                                                     <p class="help-block">spectrotest.pdf</p>
                                                </td>
                                                <td align="center"><i class="fa fa-warning"</i></td>
                                             </tr>
                                             <tr>
                                                <td><label for="exampleInputFile">Millsheet</label></td>
                                                <td><input type="file" id="vendordata" name="vendordata" required>
                                                    <p class="help-block">millsheet.pdf</p>
                                                </td>
                                                <td align="center"><i class="fa fa-warning"</i></td>
                                             </tr>
                                             <tr>
                                                <td><label for="exampleInputFile">Flatenning</label></td>
                                                <td><input type="file" id="vendordata" name="vendordata" required>
                                                    <p class="help-block">flatenning.pdf</p>
                                                </td>
                                                <td align="center"><i class="fa fa-warning"</i></td>
                                             </tr>
                                             <tr>
                                                <td><label for="exampleInputFile">PQCS</label></td>
                                                <td><input type="file" id="vendordata" name="vendordata" required>
                                                <p class="help-block">pqcs.pdf</p>
                                                </td>
                                                <td align="center"><i class="fa fa-warning"</i></td>
                                             </tr>
                                        </table>                                        

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
                             $truncate ="TRUNCATE TABLE vendor";
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
                        document.getElementById("progress").innerHTML="<div style=\"width:'.$percent.'; background-color:lightblue\">&nbsp;</div>";            
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
                 
                //      setelah data dibaca, masukkan ke tabel pegawai sql
                      //$query = "INSERT into pegawai (nama,tempat_lahir,tanggal_lahir)values('$nama','$tempat_lahir','$tanggal_lahir')";
                      //$hasil = mysql_query($query);
                        
                        $query = "INSERT INTO vendor(id_vendor,vendor_nm,allias,street,city,postcode,sales_person_1,sales_person_2,contact_num,mail,id_register) VALUES('$id_vendor             ','$vendor_nm','$allias','$street','$city','$post_code','$sales_person_1','$sales_person_2','$contact_num','$mail','$id_register')";            
                        $hasil = mysqli_query($conn,$query);               
                
                        if ($percent == '100%'){
                            echo '
                            <script>
                                document.getElementById("info").innerHTML="Please wait opening page data!";
                                window.location.replace("http://localhost/eprocurement/view/data.php");
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