<?php

require "lib/excel_reader.php";
//require_once "lib/PHPExcel/PHPExcel.php";
include "conn/conn_proc.php";
include "purch-proc-query.php";
include "function.php";
//include "lib/function-menu.php";
//include "master-data-func.php";

set_time_limit (400);
date_default_timezone_set("Asia/Jakarta");

?>

<div class="box-header">
    <h3 class="box-title">Upload Approved PO</h3>
</div>

<?php //echo getfileponame("1215010928"); //$id_data = date("Y"); echo autonum( "po_list", "batch", "3", "4", "1", $id_data); ?>

<form role=form name="myForm" id="myForm" onSubmit="return validateForm()" action="home.php?mnu=uplaprvpo" method="post" enctype="multipart/form-data">

    <div class="box-body">
        <div class="form-group">
			
            <label for="exampleInputFile">Upload Data PO</label>
            <input type="file" id="podata" name="podata" accept=".xls,.xlsx">
			<p class="help-block">po-approved-list.xls</p>
			<!--
            <p class="help-block">this function disabled as of PO Interfaced with SAP</p>
			-->
        </div>

        <?php
        if(isset($_POST['submit'])){
            //return;
        ?>

            <div id="progress" style="width:100%;border:1px solid #ccc;"></div>
            <div id="info"></div>
            <br>

            <?php
            $target = basename($_FILES['podata']['name']) ;
            move_uploaded_file($_FILES['podata']['tmp_name'], $target);

            // tambahkan baris berikut untuk mencegah error is not readable
            chmod($_FILES['podata']['name'],0777);
			//chmod($_FILES['podata']['name'],0666);
			
			$data = new Spreadsheet_Excel_Reader($_FILES['podata']['name'],false);
			//$excelreader = new PHPExcel_Reader_Excel2007();
			//$loadexcel = $excelreader->load('tmp/'.$nama_file_baru); // Load file excel yang tadi diupload ke folder tmp  
			//$data = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);
            

            //    menghitung jumlah baris file xls
            $baris = $data->rowcount($sheet_index=0);
			//$baris = $data->setActiveSheetIndex(0)->getHighestRow();

            //    jika kosongkan data dicentang jalankan kode berikut
            $drop = isset( $_POST["drop"] ) ? $_POST["drop"] : 0 ;
            if($drop == 1){
                //             kosongkan tabel
				$conn = get_connection();
                $truncate ="TRUNCATE TABLE xxx";
                mysqli_query($conn,$truncate);
				mysqli_close($conn);
            };

            $id_user    = $_SESSION['id_user'];
            $date       = date("Y-m-d H:i:s");
            $id_data    = date("Y");
            $batch      = autonum( "po_list", "batch", "3", "4", "1", $id_data);
			$x   = 1;
            //    import data excel mulai baris ke-6 (karena tabel xls hasil export dari SAP)
            for ($i=2; $i<=$baris; $i++)
			//foreach($data as $rowdt)
            {
				
                //menghitung jumlah real data.
                $barisreal = $baris-1;
                $k = $i-1;

                // menghitung persentase progress
                $percent = intval($k/$barisreal * 100)."%";

                // mengupdate progress
                echo '<script language="javascript">
                        document.getElementById("progress").innerHTML="<div style=\"width:'.$percent.'; background-color:#0080ff\">&nbsp;</div>";
                        document.getElementById("info").innerHTML="'.$k.' data inserted of '.$barisreal.' ('.$percent.')";
                        </script>';


                //membaca data (kolom ke-1 sd terakhir)
                /*
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
                */

                $docdate = $data->val($i, 3);
                //$data_date = explode(".", $docdate);
                //$doc_date  = $data_date[2]."-".$data_date[1]."-".$data_date[0];
				$data_date = explode("/", $docdate);
                $doc_date  = $data_date[2]."-".$data_date[0]."-".$data_date[1];

                $row['po_num']      = $data->val($i, 1);
                $row['plant']       = $data->val($i, 2);
                $row['doc_date']    = $doc_date;
                $row['id_vendor']   = $data->val($i, 4);
                $row['pgr']         = $data->val($i, 6);
                /*
                $row['mat']         = $data->val($i, 8);
                $row['mat_desc']    = $data->val($i, 9);
                $row['doc_date']    = $doc_date;
                $row['typ']         = $data->val($i, 10);
                $row['qty']         = $data->val($i, 13);
                */
                $row['porg']        = $data->val($i, 7);
                //$row['matgr']       = $data->val($i, 12);
				if ( $data->val($i, 8)  == 'R' ){ //add by HOS 10.10.2019 $data->val($i, 8)
					$relind = '1';
				}
                $row['relind']      = $relind; //$data->val($i, 8);
                $row['creator']     = $data->val($i, 9);
                $row['id_user']     = $id_user;
                $row['last_change'] = $date;
                $row['batch']       = $batch;

                //$query_exec = get_vendor_data_by_id($id_vendor);
                //$row = mysql_fetch_assoc($query_exec);

                //if ($id_vendor != $row['id_vendor']){
                //insert_vendor_data($id_vendor, $nm_vendor, $allias, $street, $id_user);
                //insert_vendor_user_data($id_user, $nm_user, $id_tipe_user, $allias, $pass, "vendor", 'N');
                //}

                if($data->val($i, 1) != '') { //$data->val($i, 1)

                    $filenm = getfileponame($data->val($i, 1)); //.".pdf" $data->val($i, 1)
					//$filenm = getdatapo();

                    //check file
                    if ($filenm != "") {
                        $filepdf = $filenm . ".pdf";
                    } else {
                        $filepdf = "-";
						
                    }

                    $row['file_nm'] = $filepdf;

                    insert_approved_po($row);
                } 
				

                $token = token();
				
                if ($percent == '100%'){
                    echo '
                            <script>
                                document.getElementById("info").innerHTML="Please wait opening page data!";
                                window.location= "home.php?mnu=batchpo";
                            </script>
                            ';
                }
				
            }

            //hapus file xls yang sudah dibaca
            unlink($_FILES['podata']['name']);
        }

        ?>

    </div><!-- /.box-body -->
    
    <div class="box-footer">
        <button type="submit" id="submit" name="submit" class="btn btn-success"><i class="fa fa-upload"></i> Upload</button>
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
		
		/*
        if(!hasExtension('podata', ['.xls'])){
            alert("Only XLS (Excel 2003) allowed!");
            return false;
        }
		*/

        swal({
            title: 'Uploading your data',
            text: 'It may take a little longer, depends on your data...',
            allowOutsideClick: false,
            onOpen: function () {
                swal.showLoading()
            }
        })
    }

    document.addEventListener('contextmenu', function(e) {
        e.preventDefault();
    });
</script>

<!--
    </body>
</html>
-->