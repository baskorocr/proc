<?php
/**
 * Copyright (c) 2017. Don't copy or use the source code without author permission for comercial purpose(s)
 */

include_once "../conn/conn.php";

function get_vendor_login($username, $pass){

    $conn = get_connection();
    $query = "SELECT * FROM user u
              JOIN vendor v ON u.foreign_id=v.id_vendor
              JOIN tipe_user t on u.id_tipe_user = t.id_tipe_user WHERE username='$username' AND password='$pass' AND status_user = 'A' AND status_vendor = 'A'";
    /* $result = mysql_query($query) or die(mysqli_error($conn));
    mysql_close($conn); */
	$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
    mysqli_close($conn);
    return $result;
}

function get_user_login($username, $pass){
    $conn = get_connection();
    $query = "SELECT * FROM user u JOIN tipe_user t on u.id_tipe_user = t.id_tipe_user WHERE username='$username' AND password='$pass' AND status_user = 'A'";
    /* $result = mysql_query($query) or die(mysqli_error($conn));
    mysql_close($conn); */
	$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
    mysqli_close($conn);
    return $result;
}

function set_login($session_id, $username, $id_user){
    $conn = get_connection();
    $query = "UPDATE user SET id_session='$session_id' WHERE username='$username' AND id_user='$id_user'";
    /* $result = mysql_query($query) or die(mysqli_error($conn));
    mysql_close($conn); */
	$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
    mysqli_close($conn);
    return $result;
}

function insert_user_log_menu($id_user, $ip_address, $attempt, $activity, $info){

    $conn = get_connection();
    $query = "INSERT INTO user_log (id_user, ip_address, datetime_log, attempt, activity, info)
              VALUES ('$id_user', '$ip_address', '".date("Y-m-d H:i:s")."', '$attempt', '$activity', '$info')";
    /* $result = mysql_query($query) or die(mysqli_error($conn));
    mysql_close($conn); */
	$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
    mysqli_close($conn);
    return $result;
}
?>