<?php
/**
 * Copyright (c) 2017. Don't copy or use the source code without author permission for comercial purpose(s)
 */

/**
 * Created by PhpStorm.
 * User: Hidrian
 * Date: 10-Oct-17
 * Time: 08:27 AM
 */
$file = $_GET['p'];

if (file_exists($file)) {

    header('Content-type: application/pdf');
    header('Content-Disposition: inline; filename="' . basename($file) . '"');
    header('Content-Transfer-Encoding: binary');
    header('Content-Length: ' . filesize($file));
    header('Accept-Ranges: bytes');

    @readfile($file);

} else{
    echo "NO-EXIST";
}

?>