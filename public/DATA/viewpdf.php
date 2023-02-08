<?php

$id 		= $_GET['id']; 
$name       = $_GET['nm'];
//$file 		= "440000000001/Stand Assy Main_Plate L, Stand Tread_Re-drawing_ver1.pdf";
//$filename 	= 'Stand Assy Main_Plate L, Stand Tread_Re-drawing_ver1'; //.pdf

$file 		= $id."/".$name.".pdf";
$filename 	= $name;

header('Content-type: application/pdf');
header('Content-Disposition: inline; filename="' . $filename . '"');
header('Content-Transfer-Encoding: binary');
header('Content-Length: ' . filesize($file));
header('Accept-Ranges: bytes');

@readfile($file);
?>
