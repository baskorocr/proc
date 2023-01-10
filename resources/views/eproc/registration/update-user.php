<?php
include "../conn/conn.php";
//include "master-data-query.php";

function get_all_vendor_active(){

	$conn = get_connection();
	$query = "SELECT a.*, b.id_user, b.nm_user, b.username FROM vendor a
			LEFT JOIN user b on a.id_user = b.id_user
			ORDER BY id_vendor ASC";
	//$result = mysql_query($query) or die(mysqli_error($conn));
	//mysql_close($conn);
	$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
	mysqli_close($conn);
	return $result;
}

function update_user_foreign_id($data){

	$conn = get_connection();
	$query = "UPDATE user SET foreign_id = '".$data['id_vendor']."' WHERE id_user = '".$data['id_user']."' ";
	//$result = mysql_query($query) or die(mysqli_error($conn));
	//mysql_close($conn);
	$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
	mysqli_close($conn);
	return $result;
}

$query_exec1 = get_all_vendor_active();
while ($row = mysql_fetch_assoc($query_exec1)) {
    $data['id_user'] = $row['id_user'];
    $data['id_vendor'] = $row['id_vendor'];
    update_user_foreign_id($data);
}

?>