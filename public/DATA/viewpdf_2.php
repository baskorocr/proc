<?php

$id 		= $_GET['id'];
$name       = $_GET['nm'];
$path 		= $_GET['p'];
$file 		= $id."/".$path.'.pdf';
$filename 	= $name.'.pdf';

header('Content-type: application/pdf');
header('Content-Disposition: inline; filename="' . $filename . '"');
header('Content-Transfer-Encoding: binary');
header('Content-Length: ' . filesize($file));
header('Accept-Ranges: bytes');

@readfile($file);
?>
