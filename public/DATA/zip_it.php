<?php
    
    include "../project_mgt/project-mgt-query.php";
    include "../project_mgt/project-mgt-func.php";

    //$files = array('Dear GP.docx','ecommerce.doc');
$files = $_POST['files'];
$nm_file = $_POST['nm_file'];

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