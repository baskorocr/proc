<?php

include_once "conn/conn_proc.php";
include_once "conn/conn.php";

date_default_timezone_set("Asia/Jakarta");

//USER DATA
/*
function get_all_user_data(){

	$conn = get_connection();
	$query = "SELECT u.id_user, u.nm_user, t.nm_tipe_user, u.username, u.password, u.status_user, u.role, v.nm_vendor FROM user u 
			join tipe_user t ON u.id_tipe_user = t.id_tipe_user 
			left join vendor v ON v.id_user = u.id_user
			ORDER BY u.id_user ASC";
	$result = mysql_query($query) or die(mysqli_error($conn));
	mysql_close($conn);
	return $result;
}
*/

function get_all_po_apprv_data(){

    $conn = get_connection_proc();
    $query = "SELECT p.*, v.nm_vendor, u.username, u.status_user from purch_proc.po_list p 
              join dp_eproc.vendor v on p.id_vendor = v.id_vendor
              left join dp_eproc.user u on u.id_user = v.id_user
              order by p.po_num asc";
    //$result = mysql_query($query) or die(mysqli_error($conn));
    //mysql_close($conn);
	$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
    mysqli_close($conn);
    return $result;
}

function get_max_po_apprv_data(){

    $conn = get_connection_proc();

    /*
    $query = "SELECT p.*, v.nm_vendor, v.id_user, u.username, u.status_user from purch_proc_301.po_list p 
              join dp_eproc_301.vendor v on p.id_vendor = v.id_vendor 
              join dp_eproc_301.user u on u.id_user = v.id_user 
              where p.batch = (select max(p.batch) from purch_proc_301.po_list) and p.sent = '0000-00-00 00:00:00'
              group by p.po_num";
    */

    $query = "SELECT p.*, v.nm_vendor, u.id_user, u.username, u.status_user from purch_proc.po_list p 
                join dp_eproc.vendor v on p.id_vendor = v.id_vendor 
                join dp_eproc.user u on u.foreign_id = v.id_vendor 
                where p.batch = (select max(p.batch) from purch_proc.po_list) and p.sent = '0000-00-00 00:00:00'
                group by p.po_num";

    //$result = mysql_query($query) or die(mysqli_error($conn));
    //mysql_close($conn);
	$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
    mysqli_close($conn);
    return $result;
}

function get_max_po_apprv_data_by_idvendor($id_vendor){

    $conn = get_connection_proc();
    /*
    $query = "SELECT p.*, v.nm_vendor, v.id_user, u.username, u.status_user from purch_proc_301.po_list p 
              join dp_eproc_301.vendor v on p.id_vendor = v.id_vendor 
              join dp_eproc_301.user u on u.id_user = v.id_user 
              where p.sent = '0000-00-00 00:00:00'
              and p.id_vendor = '".$id_vendor."'
              group by p.po_num
              order by p.doc_date asc"; //p.file_nm <> '-'
              */
    
    $query = "SELECT p.*, v.nm_vendor, u.id_user, u.username, u.status_user from purch_proc.po_list p 
                join dp_eproc.vendor v on p.id_vendor = v.id_vendor 
                join dp_eproc.user u on u.foreign_id = v.id_vendor 
                where p.sent = '0000-00-00 00:00:00'
                and p.id_vendor = '".$id_vendor."'
                group by p.po_num
                order by p.doc_date asc";          

    //$result = mysql_query($query) or die(mysqli_error($conn));
    //mysql_close($conn);
	$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
    mysqli_close($conn);
    return $result;
}

function get_max_po_apprv_data_group_idvendor(){

    $conn = get_connection_proc();

    /*
        $query = "SELECT p.*, v.nm_vendor, u.id_user, u.username, u.status_user from purch_proc.po_list p 
                    join dp_eproc.vendor v on p.id_vendor = v.id_vendor 
                    join dp_eproc.user u on u.foreign_id = v.id_vendor 
                    where p.sent = '0000-00-00 00:00:00'
                    group by p.id_vendor";
                    */
    $query = "SELECT p.*, v.nm_vendor, u.id_user, u.username, u.status_user from purch_proc.po_list p 
                join dp_eproc.vendor v on p.id_vendor = v.id_vendor 
                join dp_eproc.user u on u.foreign_id = v.id_vendor 
                join dp_eproc.access_group_list agl on agl.id_access_group = u.id_access_group
                join dp_eproc.menu_access_group mag on mag.id_access_group = u.id_access_group
                join dp_eproc.menu_group mg on mg.id_menu = mag.id_menu
                join dp_eproc.menu_group_list mgl on mgl.id_menu_group = mg.id_menu_group
                where p.sent = '0000-00-00 00:00:00' AND mgl.menu_group_object = 'purchproc'
				AND u.status_user = 'A'
                group by p.id_vendor";                

    //and u.username REGEXP '^[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,63}$'
    //$result = mysql_query($query) or die(mysqli_error($conn));
    //mysql_close($conn);
	$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
    mysqli_close($conn);
    return $result;
}

function get_max_batch(){

    $conn = get_connection_proc();
    $query = "SELECT max(batch) as batch from po_list";
    //$result = mysql_query($query) or die(mysqli_error($conn));
    //mysql_close($conn);
	$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
    mysqli_close($conn);
    return $result;
}

function insert_approved_po($data){

    $conn = get_connection_proc();
    $doc_date = $data['doc_date'];
    $query = "INSERT INTO po_list (po_num,	plant,	doc_date, id_vendor, pgr, porg,	relind,	creator, file_nm, id_user, last_change, batch)
              VALUES ('".$data['po_num']."', '".$data['plant']."', '$doc_date', '".$data['id_vendor']."', '".$data['pgr']."', 
                      '".$data['porg']."', '".$data['relind']."', '".$data['creator']."', '".$data['file_nm']."', 
                      '".$data['id_user']."', '".$data['last_change']."','".$data['batch']."') ";
    //$result = mysql_query($query) or die(mysqli_error($conn));
    //mysql_close($conn);
	$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
    mysqli_close($conn);
    return $result;
}

function update_po_sent_mail($data){

    $conn = get_connection_proc();
    $query = "UPDATE po_list p set p.sent = '".date("Y-m-d H:i:s")."' WHERE 
              p.id_vendor = '".$data['id_vendor']."' and p.sent = '0000-00-00 00:00:00' "; //p.batch = '".$data['batch']."' 
    //$result = mysql_query($query) or die(mysqli_error($conn));
    //mysql_close($conn);
	$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
    mysqli_close($conn);
    return $result;
}

/*update*/
function get_po_by_vendor($data){

    $conn = get_connection_proc();
    $query = "SELECT p.*, d.nm_vendor, d.status_vendor, u.status_user, u.role from po_list p 
			  join dp_eproc.vendor d on p.id_vendor = d.id_vendor
			  join dp_eproc.user u on u.foreign_id = d.id_vendor
              where p.id_vendor = '".$data['id_vendor']."' and p.sent <> '00-00-0000 00:00:00' 
              and d.status_vendor = 'A' and u.status_user = 'A'
			  and ( p.doc_date >= ( curdate() - INTERVAL 3 MONTH ) ) #add by HOS 10.11.2021
			  #add by HOS 10.11.2021
			  #AND 
			  #( p.downloaded = '00-00-0000 00:00:00'
				#OR ( p.doc_date >= ( curdate() - INTERVAL 3 MONTH ) ) 
			  #)
			  #add by HOS 10.11.2021
              group by p.po_num, p.batch
              order by p.sent desc";
              //add query where sent <> null
              //and batch = (select max(batch) from po_list where po_num = p.po_num)
              //group by p.po_num

    //$result = mysql_query($query) or die(mysqli_error($conn));
    //mysql_close($conn);
	$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
    mysqli_close($conn);
    return $result;
}

/*update*/
function get_po_all_vendor(){

    $conn = get_connection_proc();
    /*
    $query = "SELECT p.*, d.nm_vendor, d.status_vendor, u.status_user, u.role from purch_proc.po_list p 
			  join dp_eproc.vendor d on p.id_vendor = d.id_vendor
			  join dp_eproc.user u on u.id_user = d.id_user
              where  p.sent <> '00-00-0000 00:00:00' 
              and d.status_vendor = 'A' 
              
              order by p.sent desc";
              */
    //add query where sent <> null
    // add query and u.status_user = 'A'
    //group by p.po_num

    $query = "SELECT p.*, d.nm_vendor, d.status_vendor, u.status_user, u.role from purch_proc.po_list p 
            join dp_eproc.vendor d on p.id_vendor = d.id_vendor
            join dp_eproc.user u on u.foreign_id = d.id_vendor
            where  p.sent <> '00-00-0000 00:00:00' 
            and d.status_vendor = 'A' 
			#OR (p.downloaded <> '00-00-0000 00:00:00' AND curdate() < p.downloaded + INTERVAL 30 DAY )
			AND ( p.doc_date >= ( curdate() - INTERVAL 3 MONTH ) )  #add by HOS 10.11.2021
			group by p.po_num, p.batch
            order by p.sent desc";
			//or (p.downloaded <> '00-00-0000 00:00:00'  AND curdate() = p.downloaded + INTERVAL 30 DAY)
			/*join dp_eproc.access_group_list agl on agl.id_access_group = u.id_access_group
            join dp_eproc.menu_access_group mag on mag.id_access_group = u.id_access_group
            join dp_eproc.menu_group mg on mg.id_menu = mag.id_menu
            join dp_eproc.menu_group_list mgl on mgl.id_menu_group = mg.id_menu_group
			*/
			
			//AND mgl.menu_group_object = 'purchproc'
			
    //$result = mysql_query($query) or die(mysqli_error($conn));
    //mysql_close($conn);
	$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
    mysqli_close($conn);
    return $result;
}

/*update*/
function update_po_download_mail($data){

    $conn = get_connection_proc();
    $query = "UPDATE po_list p set p.downloaded = '".date("Y-m-d H:i:s")."' WHERE p.po_num = '".$data['po_num']."' 
            and file_nm = '".$data['file_nm']."' ";
    //$result = mysql_query($query) or die(mysqli_error($conn));
    //mysql_close($conn);
	$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
    mysqli_close($conn);
    return $result;
}

/*update*/
function get_mails(){

    $conn = get_connection_proc();
    $query = "SELECT * FROM mail_mgt where active = 'A' ";
    //$result = mysql_query($query) or die(mysqli_error($conn));
    //mysql_close($conn);
	$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
    mysqli_close($conn);
    return $result;
}

/*update*/
function get_po_version($id_vendor, $po_num, $file_nm){

    $conn = get_connection_proc();
    $query = "SELECT po_num, id_vendor, file_nm from po_list where id_vendor = '".$id_vendor."' 
            AND po_num= '".$po_num."' ";
    //$result = mysql_query($query) or die(mysqli_error($conn));
    //mysql_close($conn);
	$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
    mysqli_close($conn);
    return $result;
}

function get_all_user_pda_data(){

	$conn = get_connection_proc();
	$query = "SELECT * FROM pda_access";
	//$result = mysql_query($query) or die(mysqli_error($conn));
    //mysql_close($conn);
	$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
    mysqli_close($conn);
	return $result;
}

function insert_user_pda_data($id_user, $username, $pin, $full_name){

	$conn = get_connection_proc();
	$query = "INSERT INTO pda_access (id, username, pin, full_name)
              VALUES ('$id_user', '$username', '$pin', '$full_name')
            ";
	//$result = mysql_query($query) or die(mysqli_error($conn));
    //mysql_close($conn);
	$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
    mysqli_close($conn);
	return $result;
}

function get_all_user_pda_data_by_id($id){

	$conn = get_connection_proc();
	$query = "SELECT * FROM pda_access WHERE id = '$id' ";
	//$result = mysql_query($query) or die(mysqli_error($conn));
    //mysql_close($conn);
	$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
    mysqli_close($conn);
	return $result;
}

function update_pda_user_access($data){

	$conn = get_connection_proc();
	$query = "UPDATE pda_access SET full_name = '".$data['full_name']."', 
            username = '".$data['username']."', user_stat = '".$data['user_stat']."',
            pin = '".$data['pin']."'
            WHERE id = '".$data['id']."' ";
	//$result = mysql_query($query) or die(mysqli_error($conn));
    //mysql_close($conn);
	$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
    mysqli_close($conn);
	return $result;
}

function delete_pda_user_access($id){

	$conn = get_connection_proc();
	$query = "DELETE from pda_access WHERE id = '$id' ";
	//$result = mysql_query($query) or die(mysqli_error($conn));
    //mysql_close($conn);
	$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
    mysqli_close($conn);
	return $result;
}

?>