
<?php

    //include_once "../conn/conn.php";
    include "purchasing_process/function.php";
    include "lib/function.php";
    include "purchasing_process/purch-proc-query.php";

    //$filepo = array('1265005808-20180725-105355.pdf', '1265005653-20180726-081545.pdf', '1225007939-20180726-153130.pdf');

    function get_ponum($filenm){
        $pdfstring  = explode("-", $filenm);
        if(count($pdfstring) > 1) {
            $pdfnamepo = $pdfstring[0];
        }
        return $pdfnamepo;
    }

//if(isset($_POST['selectpo'])) {
if(isset($_GET['listpo'])) {
		
	$filepo = explode(",",$_GET['listpo']);	
    //$filepo = $_POST['selectpo'];

    if (count($filepo) >= 1) {

        //$filename_zip = "DHARMA_POLIMETAL_POPDF_".date("m-Y").".zip";
		$filename_zip = "DHARMA_POLIMETAL_PO_".date("d-m-Y").".zip";
		
		//count filepo
        $ct_filepo = count($filepo);
		
		// Initialize archive object
        $zip = new ZipArchive();
        $zip->open($filename_zip, ZipArchive::CREATE | ZipArchive::OVERWRITE);
		
		for ($i = 0; $i < $ct_filepo; $i++) {
			
			$itempo = explode("|",$filepo[$i]);
			if(count($itempo) > 1) {
				$creator = $itempo[1];
				$ponumber = $itempo[0];
			}
			else 
			{
				$creator = "";
			}
			
			if (strpos($creator, 'PRO') !== false ) { //OR $creator == 'DP-MM' OR $creator == 'WCS-ABAP') { 
				// Get real path for our folder
				$rootPath =	"D:\\\\POPDF\\PRD-PROC\\";
			}
			
			if (strpos($creator, 'PUR') !== false) { //OR $creator == 'DP-MM' OR $creator == 'WCS-ABAP') { 
				// Get real path for our folder
				$rootPath =	"D:\\\\POPDF\\PRD-PURC\\";
			}
			
			if ($rootPath == "") {
				$rootPath =	"D:\\\\POPDF\\PRD-PROC\\";
			}
			
            // Get real path for our folder
            //$rootPath = realpath('DATA');
            //$rootPath = "\\\\sysdata2\\POPDF\\PROC\\";
			//$rootPath = "\\\\sysdata2\\POPDF\\PRD-PROC\\";
			//$rootPath = "D:\\\\POPDF\\PRD-PROC\\";

            // Create recursive directory iterator
            /** @var SplFileInfo[] $files */
            $files = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($rootPath),
                RecursiveIteratorIterator::LEAVES_ONLY
            );

            foreach ($files as $name => $file) {
                // Skip directories (they would be added automatically)
                if (!$file->isDir()) {
                    // Get real and relative path for current file
                    $filePath = $file->getRealPath();
                    $relativePath = substr($filePath, strlen($rootPath) - 1 ); //+ 1

                    //for ($i = 0; $i < $ct_filepo; $i++) {

						//if ($file->getFilename() == $filepo[$i]) {
						if ($file->getFilename() == $ponumber) {

							//$data['po_num'] = get_ponum($filepo[$i]); 
							//$data['file_nm'] = $filepo[$i];
							$data['po_num'] = get_ponum($ponumber); 
							$data['file_nm'] = $ponumber;
							
							//update status download
                            if(update_po_download_mail($data)) {

                                // Add current file to archive
                                $zip->addFile($filePath, $relativePath);
                                //$zip->addFile($realpath, $relativePath);
                            }

                        }

                    //}

                }
            }
                
        }   
        
		$zip->close();

        # send the file to the browser as a download
		//header("Pragma: public");//
        header('Content-disposition: attachment; filename='.$filename_zip.'');
        header('Content-type: application/zip');
		header("Content-Length: " . filesize($filename_zip));//
		header("Content-Transfer-Encoding: binary");//
        //readfile('DHARMA_POLIMETAL_POPDF.zip');

        chmod($filename_zip, 0777); //666

        ob_end_clean();
        @readfile($filename_zip);

        #delete temp file
        unlink($filename_zip);
    }
}
else 
{
    header('Location: home.php?'.token().'mnu=dwldpo'.token2().'&msg=400');
}

?>