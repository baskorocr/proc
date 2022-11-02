

<?php
    include "purchasing_process/function.php";
    /*
     include "../conn/conn_proc.php";
    include "purch-proc-query.php";
    include "function.php";

    $data['po_num'] = $_GET['po'];
    //download status update
    update_po_download_mail($data);
     */
    $filenm = getfileponame($_GET['x']);

    $filepdf = $filenm.".pdf";
	$dir1 = "\\\\sysdata2\\POPDF\\PROC\\";
	$file = $dir1.$filepdf;
	$filename = $filepdf;
	opendir($dir1);
	fopen($file, "rw");


	if(opendir($dir1) and fopen($file, "rw")) {

        header('Content-type: application/pdf');
        header('Content-Disposition: inline; filename="' . $filename . '"');
        header('Content-Transfer-Encoding: binary');
        header('Content-Length: ' . filesize($file));
        header('Accept-Ranges: bytes');
        @readfile($file);

        //header('Location: home.php?mnu=dwldpo&msg=80');
    }

    else {
        header('Location: home.php?mnu=dwldpo&msg=404');
    }


	//@readfile($file);



 ?>