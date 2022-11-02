<?php

include_once "conn/conn.php";

//VENDOR DATA
function get_all_vendor_data(){

	$conn = get_connection();
	$query = "SELECT * FROM vendor";
	//$result = mysql_query($query) or die(mysqli_error($conn));
	//mysql_close($conn);
	$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
	mysqli_close($conn);
	return $result;
}

function get_vendor_by_id($foreign_id){
	$conn = get_connection();
	$query = "SELECT * FROM vendor WHERE id_vendor=".$foreign_id."";
    //$result = mysql_query($query) or die(mysqli_error($conn));
	//mysql_close($conn);
	$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
	mysqli_close($conn);
	return $result;
}

function add_vendor($id_vendor,$vendor_nm,$allias,$street,$city,$post_code,$sales_person_1,$sales_person_2,$contact_num,$mail,$id_reg){

	$conn = get_connection();
	$query = "INSERT INTO vendor(id_vendor,vendor_nm,allias,street,city,postcode,sales_person_1,sales_person_2,contact_num,mail,id_register) VALUES('$id_vendor','$vendor_nm','$allias','$street','$city','$post_code','$sales_person_1','$sales_person_2','$contact_num','$mail','$id_reg')";
	//$result = mysql_query($query) or die(mysqli_error($conn));
	//mysql_close($conn);
	$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
	mysqli_close($conn);
	return $result;
}

function get_vendor_data_by_id($foreign_id){

	$conn = get_connection();
	$query = "SELECT * FROM user where foreign_id='".$foreign_id."'";
	//$result = mysql_query($query) or die(mysqli_error($conn));
	//mysql_close($conn);
	$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
	mysqli_close($conn);
	return $result;
}
//END OF VENDOR DATA


//USER DATA
function get_all_user_data(){

	$conn = get_connection();
	$query = "SELECT u.id_user, u.nm_user, t.nm_tipe_user, u.status_user FROM user u join tipe_user t ON u.id_tipe_user = t.id_tipe_user";
	//$result = mysql_query($query) or die(mysqli_error($conn));
	//mysql_close($conn);
	$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
	mysqli_close($conn);
	return $result;
}

//END OF USER DATA


?>