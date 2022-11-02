<?php
	include "../../conn/connection.php";
	include "../data-model/my-query.php";

	$vendor_nm = $_POST['vendor_nm'];
	$sales_person = $_POST['sales_person'];
	$contact_num = $_POST['contact_num'];
	$mail = $_POST['mail'];

	$register = add_vendor_reg($vendor_nm,$sales_person,$contact_num,$mail);

	if($register){
		header("location:../vendor-registration-list.php");	
	}

?>