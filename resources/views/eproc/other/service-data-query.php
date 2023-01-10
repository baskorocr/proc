<?php

include_once "conn/conn_proc.php";

date_default_timezone_set("Asia/Jakarta");

//USER DATA
function get_all_service_log(){

	$conn = get_connection_proc();
	$query = "SELECT * FROM service_log order by date_log desc";
	$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
	mysqli_close($conn);
	return $result;
}


?>