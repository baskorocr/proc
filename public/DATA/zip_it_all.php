<?php
    
    include_once "../conn/conn.php";

    //$files = array('Dear GP.docx','ecommerce.doc');

    function get_vendor_has_assigned_detailed($id_project, $id_vendor, $doc_type){

        $conn = get_connection(); 
        $query = "SELECT a.id_project, d.nm_project, a.id_product, e.nm_product, a.id_part, f.nm_part, a.id_doc_part, b.nm_doc_part, b.doc_required, b.doc_type, c.file_nm, c.upload_path, c.upload_n, c.version_n, date_format(c.upload_date, '%d.%m.%Y') as upload_date, c.uploader_id, g.nm_user  FROM proj_vendor_assign a 
                join doc_part b on a.id_doc_part = b.id_doc_part 
                join proj_doc_upload c on a.id_project = c.id_project and a.id_product = c.id_product and a.id_part = c.id_part and a.id_doc_part = c.id_doc_part 
                join project d on a.id_project = d.id_project
                join product e on a.id_product = e.id_product
                join part f on a.id_part = f.id_part
                left join user g on g.id_user = c.uploader_id

                WHERE a.id_project='$id_project' AND a.id_vendor = '$id_vendor' AND b.doc_type = '$doc_type'
                GROUP BY a.id_project, a.id_product, a.id_part, a.id_doc_part
                ";
        //$result = mysql_query($query) or die(mysql_error());
        //mysql_close($conn);
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
        mysqli_close($conn);

    return $result;
    }

    function get_vendor_has_assigned_detailed2($id_project, $id_vendor, $doc_type){

        $conn = get_connection(); 
        $query = "SELECT a.id_project, d.nm_project, a.id_product, e.nm_product, a.id_part, f.nm_part, a.id_doc_part, b.nm_doc_part, b.doc_required, b.doc_type, c.file_nm, c.upload_path, c.upload_n, c.version_n, date_format(c.upload_date, '%d.%m.%Y') as upload_date, c.uploader_id, g.nm_user  FROM proj_vendor_assign a 
                join doc_part b on a.id_doc_part = b.id_doc_part 
                join proj_vendor_upload c on a.id_project = c.id_project and a.id_product = c.id_product and a.id_part = c.id_part and a.id_doc_part = c.id_doc_part
                join project d on a.id_project = d.id_project
                join product e on a.id_product = e.id_product
                join part f on a.id_part = f.id_part
                left join user g on g.id_user = c.uploader_id

                WHERE a.id_project='$id_project' AND c.id_vendor = '$id_vendor' AND b.doc_type = '$doc_type'
                GROUP BY a.id_project, a.id_product, a.id_part, a.id_doc_part
                ";
        //$result = mysql_query($query) or die(mysql_error());
        //mysql_close($conn);
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
        mysqli_close($conn);

    return $result;
    }

    $string = $_GET['data'];
    $data = explode(",", $string);
    $id_project = $data[0];
    $id_vendor  = $data[1];

    $files = array();

    $query_exec1 = get_vendor_has_assigned_detailed($id_project, $id_vendor, 'P');
        while ($row1 = mysqli_fetch_assoc($query_exec1)) {
            $id_product = $row1['id_product'];
            $id_part    = $row1['id_part'];
            $id_doc_part= $row1['id_doc_part'];
            $doc_required = $row1['doc_required'];
            $nm_file = $row1['nm_project'];

            $nama_data = $row1['file_nm'];
            $temp = explode(".", $nama_data);
            $filename = $temp[0];

            if ($temp[1] != ""){

                array_push($files, $id_project."/".$nama_data);
            }

    }

    $query_exec2 = get_vendor_has_assigned_detailed2($id_project, $id_vendor, 'V');
        while ($row2 = mysqli_fetch_assoc($query_exec2)) {   
            $id_product = $row2['id_product'];
            $id_part    = $row2['id_part'];
            $id_doc_part= $row2['id_doc_part'];
            $doc_required = $row2['doc_required'];
            $nm_file = $row2['nm_project'];

            $nama_data = $row2['file_nm'];
            $temp = explode(".", $nama_data);
            $filename = $temp[0];

            if ($temp[1] != ""){

                array_push($files, $id_project."/".$id_vendor."/".$nama_data);
            }

    }


    # create new zip opbject
    $zip = new ZipArchive();

    # create a temp file & open it
    $tmp_file = tempnam('.','');
    $zip->open($tmp_file, ZipArchive::CREATE);
    
    # loop through each file
    foreach($files as $file){

        # download file
        $download_file = file_get_contents($file);

        #add it to the zip
        $zip->addFromString(basename($file),$download_file);

    }

    # close zip
    $zip->close();

    # send the file to the browser as a download
    header('Content-disposition: attachment; filename=DHARMA POLIMETAL_'.$nm_file.'.zip');
    header('Content-type: application/zip');
    readfile($tmp_file);

    #delete temp file
    unlink($tmp_file);

    #insert download data
    /*
    $id_project = $_POST['id_project']; 
    $id_vendor  = $_POST['id_vendor'];
    insert_proj_doc_download($id_project, $id_downloader);
    */
 ?>