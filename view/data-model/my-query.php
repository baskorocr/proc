<?php

include_once "conn/connection.php";

//VENDOR REGISTER DATA
function get_vendor_reg(){

	$conn = get_connection();
	$query = "SELECT * FROM vendor_register where stat=0";
	//$result = mysql_query($query) or die(mysqli_error($conn));
	//mysql_close($conn);
	$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
	mysqli_close($conn);
	return $result;
}

function add_vendor_reg($vendor_nm,$sales_person,$contact_num,$mail){

	$conn = get_connection();
	$date = date('Y-m-d H:i:s');
	$query = "INSERT INTO vendor_register(vendor_nm,sales_person,contact_num,mail,reg_date,stat) VALUES('$vendor_nm','$sales_person','$contact_num','$mail', '$date',0)";
	//$result = mysql_query($query) or die(mysqli_error($conn));
	//mysql_close($conn);
	$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
	mysqli_close($conn);
	return $result;
}

function update_stat_reg($id_reg){

	$conn = get_connection();
	$query = "UPDATE vendor_register SET stat=1 WHERE id_register='".$id_reg."'";
	//$result = mysql_query($query) or die(mysqli_error($conn));
	//mysql_close($conn);
	$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
	mysqli_close($conn);
	return $result;
}


function get_vendor_register_by_id($id_register){
	$conn = get_connection();
	$query = "SELECT * FROM vendor_register WHERE id_register=".$id_register."";
    //$result = mysql_query($query) or die(mysqli_error($conn));
	//mysql_close($conn);
	$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
	mysqli_close($conn);
	return $result;
}

//END VENDOR REGISTER DATA

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

function login($username, $password)
{
	
	//koneksi ke database
	$conn=get_connection();
	
	//cek username dan password dari database
	$query= "SELECT * FROM user WHERE username= '$username' AND password= PASSWORD('".$password."') LIMIT 1";
		
	$result=mysqli_query($conn,$query) or die(mysqli_error($conn));
	//Cek adanya username dan password di database dilanjutkan dengan membuat session
	
	if (mysqli_num_rows($result) > 0)
	{
		$user= mysqli_fetch_assoc($result);
		
			if ($user['role'] == 'admin')
			{
				$_SESSION['role']='admin';				
			}
			else
			{
				$gabung= "SELECT jabatan_pegawai from pegawai p JOIN jabatan j ON p.jabatan_pegawai=j.id_jabatan WHERE p.nip = ".$user['username'];
				$result2=mysqli_query($conn,$gabung) or die(mysqli_error($conn));
				$hasil = mysqli_fetch_assoc($result2);
				$_SESSION['role']=$hasil['jabatan_pegawai'];

			}
				$_SESSION['is_logged'] = TRUE;
				$_SESSION['user'] = $username;
				
				
				$function_result=TRUE;
		
		mysqli_close($conn);
		return $function_result;
	}
	else
	{
		return(false);
	}
}

//END OF USER DATA


?>