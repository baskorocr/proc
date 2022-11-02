<?php
	include "../../conn/connection.php";
	include "../data-model/my-query.php";

	$id_vendor = $_POST['id_vendor'];
	$vendor_nm = $_POST['vendor_nm'];
	$allias =$_POST['allias'];
	$street ="";
	$city ="";
	$post_code="";
	$sales_person_1 = $_POST['sales_person_1'];
	$sales_person_2 ="";
	$contact_num = $_POST['contact_num'];
	$mail = $_POST['mail'];
	$id_register=$_POST['id_register'];

	$update_stat_reg = update_stat_reg($id_register);
	$add_vendor =  add_vendor($id_vendor,$vendor_nm,$allias,$street,$city,$post_code,$sales_person_1,$sales_person_2,$contact_num,$mail,$id_register);

	if($update_stat_reg){
		header("location:../vendor-data.php");	
	}

?>