<?php

    //include_once "../conn/conn.php";
    include "schedule_delivery/function.php";
    include "lib/function.php";
    include "schedule_delivery/schedule-delivery-query.php";

    //$filepo = array('1265005808-20180725-105355.pdf', '1265005653-20180726-081545.pdf', '1225007939-20180726-153130.pdf');

    function get_mfnum($filenm){
        $pdfstring  = explode(".", $filenm);
        if(count($pdfstring) > 1) {
            $pdfnamemf = $pdfstring[0];

            $mfstring = explode("-", $pdfnamemf);
            if(count($mfstring) > 1) {
                $manifest = $mfstring[0];
            }
        }
        return $manifest;
    }

    function get_mftype($filenm){
        $pdfstring  = explode("_", $filenm);
        if(count($pdfstring) > 1) {
            $mf_type = $pdfstring[1];
        }
        return $mf_type;
    }

if(isset($_POST['selectmf'])) {
        $filemf = $_POST['selectmf'];
        $mf_type = $_POST['mftype'];
        $id_vendor = $_POST['idvendor'];

        $mf_arr = array();
        $kanban_arr = array();
        $countmf = count($filemf);

        for ($i = 0; $i < $countmf; $i++) {
            $mf = $filemf[$i];
            $pdfstring  = explode("#", $filemf[$i]);
            $mnf_file = $pdfstring[0];
            $kbn_file = $pdfstring[1];

            array_push($mf_arr, $mnf_file);
            array_push($kanban_arr, $kbn_file);
        }

        if (count($filemf) >= 1) {

            $filename_zip = "DHARMA_POLIMETAL_MFPDF_".date("m-Y").".zip";
            
            /******  START GET MANIFEST FILE *******/

            //$rootPath = realpath('DATA');
            //$rootPath = "\\\\sysdata2\\MANIFEST\\".$mf_type."\\";   
			$rootPath = "D:\\\\MANIFEST\\".$mf_type."\\";  

            // Initialize archive object
            $zip = new ZipArchive();
            $zip->open($filename_zip, ZipArchive::CREATE | ZipArchive::OVERWRITE); //ZipArchive::CREATE | ZipArchive::OVERWRITE

            // Create recursive directory iterator
            /** @var SplFileInfo[] $files */
            $files = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($rootPath),
                RecursiveIteratorIterator::LEAVES_ONLY
            );

            //count filemf
            //$ct_filemf = count($filemf);
            $ct_filemf = count($mf_arr);

            /*** KANBAN DEFINITION ***/
            $kanban_folder = $mf_type."-KANBAN";
            //$filekanban = $filemf;
            $filekanban = $kanban_arr;

            //$rootPath2 = "\\\\sysdata2\\MANIFEST\\".$kanban_folder."\\";  
			$rootPath2 = "D:\\\\MANIFEST\\".$kanban_folder."\\";  

            $files2 = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($rootPath2),
                RecursiveIteratorIterator::LEAVES_ONLY
            );

            //count filemf
            $ct_filekanban = count($filekanban);
            /*** KANBAN DEFINITION ***/

            /** add manifest **/
            foreach ($files as $name => $file) {
                // Skip directories (they would be added automatically)
                if (!$file->isDir()) {
                    // Get real and relative path for current file
                    $filePath = $file->getRealPath();
                    $relativePath = substr($filePath, strlen($rootPath) ); //+ 1

                    for ($i = 0; $i < $ct_filemf; $i++) {

                        if ($file->getFilename() == $mf_arr[$i] ) { //$filemf[$i]

                            //update status download
                            $data['manifest'] = get_mfnum($mf_arr[$i]); //$filemf[$i]
                            $data['file_nm'] = $mf_arr[$i]; //$filemf[$i]
                            $data['id_vendor'] = $id_vendor;

                            //if(update_mf_download_mail($data)) {

                                // Add current mf file to archive
                                $zip->addFile($filePath, "01 Manifest/".$relativePath);
                                //$zip->addFile($realpath, $relativePath);
                            //}

                        }

                    }   
                    
                    /**** add kanban *****/
                    foreach ($files2 as $name2 => $file2) {
                        // Skip directories (they would be added automatically)
                        if (!$file2->isDir()) {
                            // Get real and relative path for current file
                            $filePath2 = $file2->getRealPath();
                            $relativePath2 = substr($filePath2, strlen($rootPath2) ); //+ 1
        
                            for ($i = 0; $i < $ct_filekanban; $i++) {
        
                                if ($file2->getFilename() == $filekanban[$i]) {
        
                                    //update status download
                                    $data['manifest'] = get_mfnum($filekanban[$i]);
                                    $data['file_nm'] = $filekanban[$i];
                                    $data['id_vendor'] = $id_vendor;
        
                                    if(update_mf_download_mail($data)) {
       
                                        // Add current mf file to archive
                                        $zip->addFile($filePath2, "02 Kanban/".$relativePath2);
       
                                        //rename file
                                        //$zip->renameName(basename($filePath2), $data['manifest']."-kanban.pdf");
                                        //$zip->addFile($realpath, $relativePath);
                                    }
        
                                }
        
                            }
        
                        }
                    }
                     /**** end of add kanban *****/

                }
            }

            $zip->close();
            /******  END GET MANIFEST FILE *******/

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
    else {

        if ($mf_type == "MI") {

            $uri = "dwldmfo";
        } else {
            $uri = "dwldspc";
        }

        header('Location: home.php?'.token().'mnu=$uri'.token2().'&msg=400');

    }

?>