<?php

include_once "conn/conn.php";
include_once "conn/conn_proc.php";

date_default_timezone_set("Asia/Jakarta");

//USER DATA
function get_all_user_data(){

	$conn = get_connection();
	$query = "SELECT u.id_user, u.nm_user, t.nm_tipe_user, u.username, u.password, 
			u.status_user, u.role, v.nm_vendor, ag.access_group_name
	        FROM user u 
			join tipe_user t ON u.id_tipe_user = t.id_tipe_user 
			left join vendor v ON v.id_vendor = u.foreign_id
			left join access_group_list ag ON u.id_access_group = ag.id_access_group
			ORDER BY u.id_user ASC";
	$result = mysql_query($query) or die(mysql_error());
	mysql_close($conn);
	return $result;
}


function get_user_data_by_id($id_user){

	$conn = get_connection();
	$query = "SELECT u.id_user, u.nm_user, t.nm_tipe_user, u.status_user, u.id_tipe_user, u.username, u.password, u.id_access_group FROM user u join tipe_user t ON u.id_tipe_user = t.id_tipe_user WHERE  u.id_user = '$id_user' ORDER BY u.id_user ASC";
	$result = mysql_query($query) or die(mysql_error());
	mysql_close($conn);
	return $result;
}


function update_user_data($id_user, $nm_user, $id_tipe_user, $status_user){

	$conn = get_connection();
	$query = "UPDATE user SET nm_user='$nm_user', id_tipe_user='$id_tipe_user', status_user='$status_user' WHERE id_user = '$id_user'";
	$result = mysql_query($query) or die(mysql_error());
	mysql_close($conn);
	return $result;
}


function update_password($id_user, $username, $password){

	$conn = get_connection();
	$query = "UPDATE user SET password = md5('$password') WHERE id_user = '$id_user' AND username = '$username' ";
	$result = mysql_query($query) or die(mysql_error());
	mysql_close($conn);
	return $result;
}

function get_tipe_user(){

	$conn = get_connection();
	$query = "SELECT * FROM tipe_user";
	$result = mysql_query($query) or die(mysql_error());
	mysql_close($conn);
	return $result;
}

function insert_user_data($id_user, $nm_user, $id_tipe_user, $username, $password, $role, $id_access_group){

	$conn = get_connection();
	$query = "INSERT INTO user (id_user, nm_user, id_tipe_user, username, password, role, id_access_group)
              VALUES ('$id_user', '$nm_user', '$id_tipe_user', '$username', md5('$password'), '$role', '$id_access_group')
            ";
	$result = mysql_query($query) or die(mysql_error());
	mysql_close($conn);
	return $result;
}

function insert_vendor_user_data($id_user, $nm_user, $id_tipe_user, $username, $password, $role, $stat, $foreign_id){

    $conn = get_connection();
    $query = "INSERT INTO user (id_user, nm_user, id_tipe_user, username, password, role, status_user, foreign_id)
              VALUES ('$id_user', '$nm_user', '$id_tipe_user', '$username', md5('$password'), '$role', '$stat', '$foreign_id')
            ";
    $result = mysql_query($query) or die(mysql_error());
    mysql_close($conn);
    return $result;
}

function update_email_vendor_data($foreign_id, $email, $password, $stat){

    $conn = get_connection();
    $query = "UPDATE user SET 
				username = '$email', password ='$password', status_user='$stat' 
				WHERE foreign_id = '$foreign_id' 
            ";
    $result = mysql_query($query) or die(mysql_error());
    mysql_close($conn);
    return $result;
}

//END OF USER DATA

//VENDOR DATA
function insert_vendor_data($id_vendor, $nm_vendor, $allias, $street){

    $vendor_nm = mysql_real_escape_string($nm_vendor);
    $vdr_st = mysql_real_escape_string($street);
    $alias = mysql_real_escape_string($allias);
	$conn = get_connection();
	$query = "INSERT INTO vendor (id_vendor, nm_vendor, allias, street)
              VALUES ('$id_vendor', '$vendor_nm', '$alias', '$vdr_st')
            ";
	$result = mysql_query($query) or die(mysql_error());
	mysql_close($conn);
	return $result;
}

function get_all_vendor_data(){

	$conn = get_connection();
	$query = "SELECT a.*, b.id_user, b.nm_user, b.username
				FROM vendor a
			LEFT JOIN user b on a.id_vendor = b.foreign_id
			GROUP BY a.id_vendor
			ORDER BY id_vendor ASC";
	$result = mysql_query($query) or die(mysql_error());
	mysql_close($conn);
	return $result;
}

function get_all_vendor_data_by_acscode(){

	$conn = get_connection();
	$query = "SELECT a.*, b.id_user, b.nm_user, b.username,
				acg.id_access_group, acg.access_code
				FROM vendor a
			LEFT JOIN user b on a.id_vendor = b.foreign_id
			LEFT JOIN access_group_list acg on b.id_access_group = acg.id_access_group 
				  AND acg.access_code = 'POL'
			GROUP BY a.id_vendor
			ORDER BY id_vendor ASC";
	$result = mysql_query($query) or die(mysql_error());
	mysql_close($conn);
	return $result;
}


function get_vendor_data_by_id($id_vendor){

	$conn = get_connection();
	$query = "SELECT * FROM vendor WHERE  id_vendor = '$id_vendor' ORDER BY id_vendor ASC";
	$result = mysql_query($query) or die(mysql_error());
	mysql_close($conn);
	return $result;
}
//END OF VENDOR DATA

function get_vendor_login($username, $pass){

    $conn = get_connection();
    $query = "SELECT * FROM user u
              JOIN vendor v ON u.foreign_id=v.id_vendor
              JOIN tipe_user t on u.id_tipe_user = t.id_tipe_user WHERE username='$username' AND password='$pass' AND status_user = 'A' AND status_vendor = 'A'";
    $result = mysql_query($query) or die(mysql_error());
    mysql_close($conn);
    return $result;
}

function get_user_login($username, $pass){
    $conn = get_connection();
    $query = "SELECT * FROM user u JOIN tipe_user t on u.id_tipe_user = t.id_tipe_user WHERE username='$username' AND password='$pass' AND status_user = 'A'";
    $result = mysql_query($query) or die(mysql_error());
    mysql_close($conn);
    return $result;
}

function set_login($session_id, $username, $id_user){
    $conn = get_connection();
    $query = "UPDATE user SET id_session='$session_id' WHERE username='$username' AND id_user='$id_user'";
    $result = mysql_query($query) or die(mysql_error());
    mysql_close($conn);
    return $result;
}

//LOG USER
function insert_user_log($id_user, $ip_address, $attempt, $activity, $info){

    $conn = get_connection();
    $query = "INSERT INTO user_log (id_user, ip_address, datetime_log, attempt, activity, info)
              VALUES ('$id_user', '$ip_address', '".date("Y-m-d H:i:s")."', '$attempt', '$activity', '$info')";
    $result = mysql_query($query) or die(mysql_error());
    mysql_close($conn);
    return $result;
}

function block_active_user($id_user){

    $conn = get_connection();
    $query = "UPDATE user SET status_user='N' WHERE id_user = '$id_user'";
    $result = mysql_query($query) or die(mysql_error());
    mysql_close($conn);
    return $result;
}

function get_all_user_log_data(){

    $conn = get_connection();
    $query = "SELECT a.*, b.status_user, b.id_tipe_user, c.nm_tipe_user, b.nm_user, b.username, b.role, v.id_vendor, v.nm_vendor 
				from user_log a left join user b on a.id_user = b.id_user 
				left join tipe_user c on b.id_tipe_user = c.id_tipe_user 
				left join vendor v ON v.id_vendor = b.foreign_id
				order by datetime_log desc";
    $result = mysql_query($query) or die(mysql_error());
    mysql_close($conn);
    return $result;
}

function get_menu_group_by_id_user($id_user){

    $conn = get_connection();
    $query = "SELECT u.id_user, u.nm_user, u.username, u.id_tipe_user, u.role, u.status_user, 
				ag.id_access_group, ag.access_group_name, mg.id_menu_group, mgl.menu_group_name, mgl.menu_group_object
				FROM user u JOIN access_group_list ag ON ag.id_access_group = u.id_access_group 
				JOIN menu_access_group mag ON ag.id_access_group = mag.id_access_group 
				JOIN menu_list m ON mag.id_menu = m.id_menu 
				JOIN menu_group mg ON mg.id_menu = m.id_menu 
				JOIN menu_group_list mgl ON mgl.id_menu_group = mg.id_menu_group
				WHERE u.id_user = '$id_user' AND u.status_user = 'A'
				GROUP BY mg.id_menu_group
				ORDER by mg.id_menu_group ASC";
    $result = mysql_query($query) or die(mysql_error());
    mysql_close($conn);
    return $result;
}

function get_menu_all_by_access_group($id_access_group){

    $conn = get_connection();
    $query = "SELECT #mag.id_access_group, 
				m.id_menu, m.menu_name, m.menu_object, m.object_path,
				u.nm_user, u.username, u.role, m.last_changed, m.mn_status, m.assigned
				from menu_list m 
				#LEFT JOIN menu_access_group mag on mag.id_menu = m.id_menu
				LEFT JOIN user u on m.last_changed_by = u.id_user
				where (m.mn_status = 'A' AND m.assigned = 'Y') #OR mag.id_access_group = '$id_access_group'
				#GROUP BY mag.id_menu
				#ORDER BY mag.id_menu DESC ";
    $result = mysql_query($query) or die(mysql_error());
    mysql_close($conn);
    return $result;
}

function get_access_group_by_id_user($id_user){

    $conn = get_connection();
    $query = "SELECT u.id_user, u.nm_user, u.username, u.id_tipe_user, u.role, u.status_user, 
				ag.id_access_group, ag.access_group_name, mg.id_menu_group, 
				mgl.menu_group_name, m.id_menu, m.menu_name, m.menu_object, m.object_path
				FROM user u 
					JOIN access_group_list ag ON ag.id_access_group = u.id_access_group 
					JOIN menu_access_group mag ON ag.id_access_group = mag.id_access_group 
					JOIN menu_list m ON mag.id_menu = m.id_menu 
					JOIN menu_group mg ON mg.id_menu = m.id_menu 
					JOIN menu_group_list mgl ON mgl.id_menu_group = mg.id_menu_group
				WHERE u.id_user = '$id_user' AND u.status_user = 'A'
				ORDER by mg.id_menu_group ASC";
    $result = mysql_query($query) or die(mysql_error());
    mysql_close($conn);
    return $result;
}

function get_menu_group_all(){

    $conn = get_connection();
    $query = "SELECT mgl.*, u.nm_user, u.username, u.status_user, u.role FROM menu_group_list mgl 
				JOIN user u on u.id_user = mgl.last_changed_by";
    $result = mysql_query($query) or die(mysql_error());
    mysql_close($conn);
    return $result;
}

function insert_menu_group_data($menu_group, $menu_group_obj, $id_user, $status){

	$conn = get_connection();
	$query = "INSERT INTO menu_group_list (menu_group_name, menu_group_object, last_changed_by, mg_status)
              VALUES ('$menu_group', '$menu_group_obj', '$id_user', '$status')
            ";
	$result = mysql_query($query) or die(mysql_error());
	mysql_close($conn);
	return $result;
}


function get_menu_list_all(){

    $conn = get_connection();
    $query = "SELECT m.*, mgl.id_menu_group, mgl.menu_group_name, mgl.mg_status,
				u.nm_user, u.username, u.status_user, u.role 
				FROM menu_list m 
				LEFT JOIN menu_group mg ON m.id_menu = mg.id_menu 
				LEFT JOIN menu_group_list mgl ON mgl.id_menu_group = mg.id_menu_group
				JOIN user u on u.id_user = m.last_changed_by
				WHERE m.mn_status = 'A'
				ORDER BY mgl.id_menu_group ASC ";
    $result = mysql_query($query) or die(mysql_error());
    mysql_close($conn);
    return $result;
}

function get_menu_list_all_unassigned($mnugroup){

    $conn = get_connection();
    $query = "SELECT m.*, mgl.id_menu_group, mgl.menu_group_name, mgl.mg_status,
				u.nm_user, u.username, u.status_user, u.role 
				FROM menu_list m 
				LEFT JOIN menu_group mg ON m.id_menu = mg.id_menu 
				LEFT JOIN menu_group_list mgl ON mgl.id_menu_group = mg.id_menu_group
				JOIN user u on u.id_user = m.last_changed_by
				WHERE (m.mn_status = 'A' and m.assigned <> 'Y') OR mg.id_menu_group = '".$mnugroup."'
				ORDER BY mgl.id_menu_group ASC ";
    $result = mysql_query($query) or die(mysql_error());
    mysql_close($conn);
    return $result;
}

function get_menu_list_all_by_id_menu_group($mnugroup){

    $conn = get_connection();
    $query = "SELECT * from menu_group
				where id_menu_group = '".$mnugroup."'
				ORDER BY id_menu_group ASC ";
    $result = mysql_query($query) or die(mysql_error());
    mysql_close($conn);
    return $result;
}

function get_menu_list_all_by_id_menu_group_negate($mnugroup){

    $conn = get_connection();
    $query = "SELECT * from menu_group
				where id_menu_group <> '".$mnugroup."'
				ORDER BY id_menu_group ASC ";
    $result = mysql_query($query) or die(mysql_error());
    mysql_close($conn);
    return $result;
}

function insert_menu_list_data($menu_name, $menu_object, $object_path, $id_user, $status){

	$conn = get_connection();
	$query = "INSERT INTO menu_list (menu_name, menu_object, object_path, last_changed_by, mn_status)
              VALUES ('$menu_name', '$menu_object', '$object_path', '$id_user', '$status')
            ";
	$result = mysql_query($query) or die(mysql_error());
	mysql_close($conn);
	return $result;
}

function get_menu_data_by_id($id_menu){

	$conn = get_connection();
	$query = "SELECT * FROM menu_list m WHERE m.id_menu = '$id_menu'
				ORDER BY m.id_menu ASC";
	$result = mysql_query($query) or die(mysql_error());
	mysql_close($conn);
	return $result;
}

function get_menu_group_data_by_id($id_menu_group){

	$conn = get_connection();
	$query = "SELECT * FROM menu_group_list m WHERE m.id_menu_group = '$id_menu_group'
				ORDER BY m.id_menu_group ASC";
	$result = mysql_query($query) or die(mysql_error());
	mysql_close($conn);
	return $result;
}

function get_all_unassigned_menu(){

    $conn = get_connection();
    $query = "SELECT m.* 
				FROM menu_list m 
				WHERE m.assigned <> 'Y' AND m.menu_object != '' AND m.object_path != ''
				ORDER BY m.id_menu ASC ";
    $result = mysql_query($query) or die(mysql_error());
    mysql_close($conn);
    return $result;
}

function get_all_assigned_menu(){

    $conn = get_connection();
    $query = "SELECT mg.id_menu_group, mg.id_menu, ml.menu_name, mgl.menu_group_name
				FROM menu_group mg
				JOIN menu_list ml on mg.id_menu = ml.id_menu
				JOIN menu_group_list mgl ON mg.id_menu_group = mgl.id_menu_group";
    $result = mysql_query($query) or die(mysql_error());
    mysql_close($conn);
    return $result;
}

function get_user_group_all(){

    $conn = get_connection();
    $query = "SELECT agl.*, u.nm_user, u.username, u.role 
				FROM access_group_list agl 
				JOIN user u ON agl.last_changed_by = u.id_user ";
    $result = mysql_query($query) or die(mysql_error());
    mysql_close($conn);
    return $result;
}

function get_all_assigned_menu_group(){

    $conn = get_connection();
    $query = "SELECT m.* 
				FROM menu_group_list m 
				WHERE m.assigned = 'Y' 
				ORDER BY m.id_menu_group ASC ";
    $result = mysql_query($query) or die(mysql_error());
    mysql_close($conn);
    return $result;
}

function get_all_assigned_access_group(){

    $conn = get_connection();
    $query = "SELECT a.* 
				FROM access_group_list a 
				WHERE a.ag_status = 'A' AND a.assigned = 'Y'
				ORDER BY a.id_access_group ASC ";
    $result = mysql_query($query) or die(mysql_error());
    mysql_close($conn);
    return $result;
}

function insert_access_group_list_data($access_group_name, $id_user, $ag_status){

	$conn = get_connection();
	$query = "INSERT INTO access_group_list (access_group_name, last_changed_by, ag_status)
              VALUES ('$access_group_name', '$id_user', '$ag_status')
            ";
	$result = mysql_query($query) or die(mysql_error());
	mysql_close($conn);
	return $result;
}

function get_access_group_data_by_id($id_access_group){

	$conn = get_connection();
	$query = "SELECT * FROM access_group_list acg WHERE acg.id_access_group = '$id_access_group'
				ORDER BY acg.id_access_group ASC";
	$result = mysql_query($query) or die(mysql_error());
	mysql_close($conn);
	return $result;
}

function update_menu_group_data($id_menu_group, $menu_group_name, $menu_group_obj, $id_user, $mg_status){

	$conn = get_connection();
	$query = "UPDATE menu_group_list SET menu_group_name='$menu_group_name', menu_group_object= '$menu_group_obj', 
				last_changed_by = '$id_user', last_changed = '".date("Y-m-d H:i:s")."', mg_status='$mg_status'  
			 WHERE id_menu_group = '$id_menu_group' ";
	$result = mysql_query($query) or die(mysql_error());
	mysql_close($conn);
	return $result;
}

function update_menu_group_assigned_stat($id_menu_group, $id_user, $assigned){

	$conn = get_connection();
	$query = "UPDATE menu_group_list SET assigned='$assigned', last_changed = '".date("Y-m-d H:i:s")."'
			 WHERE id_menu_group = '$id_menu_group' ";
	$result = mysql_query($query) or die(mysql_error());
	mysql_close($conn);
	return $result;
}

function delete_menu_group_assigned($id_menu_group){

	$conn = get_connection();
	$query = "DELETE FROM menu_group WHERE id_menu_group = '$id_menu_group' ";
	$result = mysql_query($query) or die(mysql_error());
	mysql_close($conn);
	return $result;
}

function insert_menu_group_assign_data($id_menu_group, $id_menu, $id_user){

	$conn = get_connection();
	$query = "INSERT INTO menu_group (id_menu_group, id_menu, last_changed_by, last_changed)
              VALUES ('$id_menu_group', '$id_menu', '$id_user', '".date("Y-m-d H:i:s")."')
            ";
	$result = mysql_query($query) or die(mysql_error());
	mysql_close($conn);
	return $result;
}

function update_menu_list_assigned_stat($id_menu, $id_user, $assigned){

	$conn = get_connection();
	$query = "UPDATE menu_list SET assigned='$assigned', last_changed = '".date("Y-m-d H:i:s")."'
			 WHERE id_menu = '$id_menu' ";
	$result = mysql_query($query) or die(mysql_error());
	mysql_close($conn);
	return $result;
}

function get_menu_all_by_id_access_group($id_access_group){

    $conn = get_connection();
    $query = "SELECT * from menu_access_group
				where id_access_group = '".$id_access_group."'
				ORDER BY id_menu ASC ";
    $result = mysql_query($query) or die(mysql_error());
    mysql_close($conn);
    return $result;
}

function get_menu_all_by_id_access_group_negate($id_access_group){

    $conn = get_connection();
    $query = "SELECT * from menu_access_group
				where id_access_group <> '".$id_access_group."'
				ORDER BY id_menu ASC ";
    $result = mysql_query($query) or die(mysql_error());
    mysql_close($conn);
    return $result;
}

function insert_access_group_assign_data($id_access_group, $id_menu, $id_user){

	$conn = get_connection();
	$query = "INSERT INTO menu_access_group (id_access_group, id_menu, last_changed_by, last_changed)
              VALUES ('$id_access_group', '$id_menu', '$id_user', '".date("Y-m-d H:i:s")."')
            ";
	$result = mysql_query($query) or die(mysql_error());
	mysql_close($conn);
	return $result;
}

function update_access_group_data($id_access_group, $access_group_name, $id_user, $ag_status){

	$conn = get_connection();
	$query = "UPDATE access_group_list SET access_group_name='$access_group_name', 
				last_changed_by = '$id_user', last_changed = '".date("Y-m-d H:i:s")."', ag_status='$ag_status'  
			 WHERE id_access_group = '$id_access_group' ";
	$result = mysql_query($query) or die(mysql_error());
	mysql_close($conn);
	return $result;
}

function update_access_group_assigned_stat($id_access_group, $id_user, $assigned){

	$conn = get_connection();
	$query = "UPDATE access_group_list SET assigned='$assigned', last_changed = '".date("Y-m-d H:i:s")."'
			 WHERE id_access_group = '$id_access_group' ";
	$result = mysql_query($query) or die(mysql_error());
	mysql_close($conn);
	return $result;
}

function delete_access_group_assigned($id_access_group){

	$conn = get_connection();
	$query = "DELETE FROM menu_access_group WHERE id_access_group = '$id_access_group' ";
	$result = mysql_query($query) or die(mysql_error());
	mysql_close($conn);
	return $result;
}

function get_all_vendor_active(){

	$conn = get_connection();
	$query = "SELECT a.*, b.id_user, b.nm_user, b.username FROM vendor a
			LEFT JOIN user b on a.id_vendor = b.foreign_id
			GROUP BY id_vendor #add by HOS 06.10.2020
			ORDER BY id_vendor ASC";
	$result = mysql_query($query) or die(mysql_error());
	mysql_close($conn);
	return $result;
}

function update_user_foreign_id($data){

	$conn = get_connection();
	$query = "UPDATE user SET foreign_id = '".$data['id_vendor']."' WHERE id_user = '".$data['id_user']."' ";
	$result = mysql_query($query) or die(mysql_error());
	mysql_close($conn);
	return $result;
}

function insert_user_vendor_data($id_user, $nm_user, $id_tipe_user, $username, $password, $role, $id_access_group, $foreign_id){

	$conn = get_connection();
	$query = "INSERT INTO user (id_user, nm_user, id_tipe_user, username, password, role, id_access_group, foreign_id)
              VALUES ('$id_user', '$nm_user', '$id_tipe_user', '$username', md5('$password'), '$role', '$id_access_group', '$foreign_id')
            ";
	$result = mysql_query($query) or die(mysql_error());
	mysql_close($conn);
	return $result;
}

// ================ EMAIL GROUP =======================
function get_all_email_group(){

    $conn =  get_connection_proc();
    $query = "SELECT d.*, u.nm_user from dept_master d 
				LEFT JOIN dp_eproc.user u on d.last_changed_by = u.id_user 
				ORDER BY dept_code ASC";
    $result = mysql_query($query) or die(mysql_error());
    mysql_close($conn);
    return $result;
}

function get_all_email_group_by_dept_code($dept_code){

    $conn =  get_connection_proc();
    $query = "SELECT d.*, u.nm_user from dept_master d 
				LEFT JOIN dp_eproc.user u on d.last_changed_by = u.id_user 
				WHERE d.dept_code = '$dept_code'
				ORDER BY dept_code ASC";
    $result = mysql_query($query) or die(mysql_error());
    mysql_close($conn);
    return $result;
}

function insert_email_group($dept_code, $abrev, $dept_desc, $id_user){

	$conn =  get_connection_proc();
	$query = "INSERT INTO dept_master (dept_code, abrev, dept_desc, last_changed_by, last_changed )
              VALUES ('$dept_code', '$abrev', '$dept_desc', '$id_user', '".date("Y-m-d H:i:s")."')
            ";
	$result = mysql_query($query) or die(mysql_error());
	mysql_close($conn);
	return $result;
}

function update_email_group($old_deptcode, $dept_code, $abrev, $dept_desc, $id_user){

	$conn =  get_connection_proc();
	$query = "UPDATE dept_master SET abrev = '$abrev', 
									 dept_desc = '$dept_desc', last_changed_by = '$id_user', 
									 last_changed = '".date("Y-m-d H:i:s")."' 
								 WHERE dept_code = '$old_deptcode' ";
	$result = mysql_query($query) or die(mysql_error());
	mysql_close($conn);
	return $result;
}

// ================ EMAIL LIST GROUP =======================
function get_all_email_list_group(){
	
    $conn =  get_connection_proc();
    $query = "SELECT m.*, abrev, dept_desc, nm_user from mail_mgt m
				LEFT JOIN dept_master d ON d.dept_code = m.dept_code
				LEFT JOIN dp_eproc.user u on m.last_changed_by = u.id_user
				ORDER BY mail, dept_code ASC ";
    $result = mysql_query($query) or die(mysql_error());
    mysql_close($conn);
    return $result;
}

function get_all_email_list_group_by_mail_dept($mail, $dept_code){

	$conn =  get_connection_proc();
    $query = "SELECT m.*, abrev, dept_desc, nm_user from mail_mgt m
				LEFT JOIN dept_master d ON d.dept_code = m.dept_code
				LEFT JOIN dp_eproc.user u on m.last_changed_by = u.id_user
				WHERE mail = '$mail' AND m.dept_code = '$dept_code'
				ORDER BY mail, dept_code ASC ";
    $result = mysql_query($query) or die(mysql_error());
    mysql_close($conn);
    return $result;
}

function insert_email_list_group($mail, $dept_code, $name, $active, $id_user){

	$conn =  get_connection_proc();
	$query = "INSERT INTO mail_mgt (mail, dept_code, name, active, last_changed_by, last_changed )
              VALUES ('$mail', '$dept_code', '$name', '$active', '$id_user', '".date("Y-m-d H:i:s")."')
            ";
	$result = mysql_query($query) or die(mysql_error());
	mysql_close($conn);
	return $result;
}

function update_email_list_group($old_mail, $old_deptcode, $mail, $dept_code, $name, $active, $id_user){

	$conn =  get_connection_proc();
	$query = "UPDATE mail_mgt SET 	 mail = '$mail', 
									 dept_code = '$dept_code', 
									 name = '$name',
									 active = '$active',
									 last_changed_by = '$id_user', 
									 last_changed = '".date("Y-m-d H:i:s")."' 
								 WHERE mail = '$old_mail' AND 
								 	   dept_code = '$old_deptcode' ";
	$result = mysql_query($query) or die(mysql_error());
	mysql_close($conn);
	return $result;
}


// ================ NUMBER RANGE =======================
function get_all_number_range(){
	
    $conn =  get_connection_proc();
    $query = "SELECT d.*, u.nm_user from doc_number d
				LEFT JOIN dp_eproc.user u on d.last_changed_by = u.id_user
				ORDER BY doc_type, doc_year ASC ";
    $result = mysql_query($query) or die(mysql_error());
    mysql_close($conn);
    return $result;
	
}

function get_all_number_range_by_doc_year($doc_type, $doc_year){

    $conn =  get_connection_proc();
    $query = "SELECT d.*, u.nm_user from doc_number d
				LEFT JOIN dp_eproc.user u on d.last_changed_by = u.id_user
				WHERE doc_type = '$doc_type' AND doc_year = '$doc_year'
				ORDER BY doc_type, doc_year ASC ";
    $result = mysql_query($query) or die(mysql_error());
    mysql_close($conn);
    return $result;
}

function insert_number_range($doc_type, $doc_year, $num_low, $num_high, $id_user){

	$conn =  get_connection_proc();
	$query = "INSERT INTO doc_number (doc_type, doc_year, num_low, num_high, last_changed_by, last_changed )
              VALUES ('$doc_type', '$doc_year', '$num_low', '$num_high', '$id_user', '".date("Y-m-d H:i:s")."')
            ";
	$result = mysql_query($query) or die(mysql_error());
	mysql_close($conn);
	return $result;
}

function update_number_range($old_doctype, $old_docyear, $doc_type, $doc_year, $num_low, $num_high, $id_user){

	$conn =  get_connection_proc();
	$query = "UPDATE doc_number SET  doc_type = '$doc_type',
								     doc_year = '$doc_year',
									 num_low = '$num_low', 
									 num_high = '$num_high', 
									 last_changed_by = '$id_user', 
									 last_changed = '".date("Y-m-d H:i:s")."' 
								 WHERE doc_type = '$old_doctype' AND 
								 	   doc_year = '$old_docyear' ";
	$result = mysql_query($query) or die(mysql_error());
	mysql_close($conn);
	return $result;
}

?>