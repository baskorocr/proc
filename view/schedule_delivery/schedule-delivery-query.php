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

function get_all_manifest_group_1(){

    $conn = get_connection_proc();
    $query = "SELECT h.manifest, h.delivery_date, h.po_num, h.id_vendor, h.stat, v.nm_vendor, d.material, d.material_desc, sum(d.qty_pack) as qty_tot, 
              count(d.kanban) as tot_kanban, SUM(d.qty_in) as tot_qty_in 
              from manifest_detail d 
              join manifest_header h on h.manifest = d.manifest 
              join dp_eproc.vendor v on v.id_vendor = h.id_vendor
              group by d.manifest, d.material ";
    //$result = mysql_query($query) or die(mysqli_error($conn));
    //mysql_close($conn);
	$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
    mysqli_close($conn);
    return $result;
}

function get_all_manifest_group_2_mfo(){

    $conn = get_connection_proc();
    $query = "SELECT h.manifest, h.mf_type, h.delivery_date, h.po_num, h.id_vendor, h.stat, h.active, v.nm_vendor, d.material, d.material_desc, sum(d.qty_pack) as qty_tot, 
              count(d.kanban) as tot_kanban, SUM(d.qty_in) as tot_qty_in, h.file_nm, u.username, u.status_user, u.username, u.status_user, 
              (select count(dd.scan_date) from manifest_detail dd where dd.scan_date <> '0000-00-00' AND dd.manifest = h.manifest) as in_kanban, h.sent, h.downloaded
              from manifest_detail d 
              join manifest_header h on h.manifest = d.manifest 
              join dp_eproc.vendor v on v.id_vendor = h.id_vendor
              join dp_eproc.user u on u.foreign_id = v.id_vendor
              where h.mf_type = 'MI' AND u.status_user = 'A'
              group by d.manifest";
			  //group by dd.manifest
    //$result = mysql_query($query) or die(mysqli_error($conn));
    //mysql_close($conn);
	$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
    mysqli_close($conn);
    return $result;
}

function get_all_manifest_group_2_by_vendor_mfo($id_vendor){

    $conn = get_connection_proc();
    $query = "SELECT h.manifest, h.mf_type, h.delivery_date, h.po_num, h.id_vendor, h.stat, h.active, v.nm_vendor, d.material, d.material_desc, sum(d.qty_pack) as qty_tot, 
              count(d.kanban) as tot_kanban, SUM(d.qty_in) as tot_qty_in, h.file_nm, u.username, u.status_user, 
              (select count(dd.scan_date) from manifest_detail dd where dd.scan_date <> '0000-00-00' AND dd.manifest = h.manifest) as in_kanban, h.sent, h.downloaded,
              u.username, u.status_user
              from manifest_detail d 
              join manifest_header h on h.manifest = d.manifest 
              join dp_eproc.vendor v on v.id_vendor = h.id_vendor
              join dp_eproc.user u on u.foreign_id = v.id_vendor
              where h.id_vendor = '".$id_vendor."' AND  h.mf_type = 'MI' AND u.status_user = 'A'
              group by d.manifest";
			  //group by dd.manifest
    //$result = mysql_query($query) or die(mysqli_error($conn));
    //mysql_close($conn);
	$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
    mysqli_close($conn);
    return $result;
}


function get_all_manifest_group_2_spo(){

    $conn = get_connection_proc();
    $query = "SELECT h.manifest, h.mf_type, h.delivery_date, h.po_num, h.id_vendor, h.stat, h.active, v.nm_vendor, d.material, d.material_desc, sum(d.qty_pack) as qty_tot, 
              count(d.kanban) as tot_kanban, SUM(d.qty_in) as tot_qty_in, h.file_nm, u.username, u.status_user, 
              (select count(dd.scan_date) from manifest_detail dd where dd.scan_date <> '0000-00-00' AND dd.manifest = h.manifest) as in_kanban, h.sent, h.downloaded
              from manifest_detail d 
              join manifest_header h on h.manifest = d.manifest 
              join dp_eproc.vendor v on v.id_vendor = h.id_vendor
              join dp_eproc.user u on u.foreign_id = v.id_vendor
              where h.mf_type = 'SO' AND u.status_user = 'A'
              group by d.manifest";
    //$result = mysql_query($query) or die(mysqli_error($conn));
    //mysql_close($conn);
	$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
    mysqli_close($conn);
    return $result;
}

function get_all_manifest_group_2_by_vendor_spo($id_vendor){

    $conn = get_connection_proc();
    $query = "SELECT h.manifest, h.mf_type, h.delivery_date, h.po_num, h.id_vendor, h.stat, h.active, v.nm_vendor, d.material, d.material_desc, sum(d.qty_pack) as qty_tot, 
              count(d.kanban) as tot_kanban, SUM(d.qty_in) as tot_qty_in, h.file_nm, u.username, u.status_user, 
              (select count(dd.scan_date) from manifest_detail dd where dd.scan_date <> '0000-00-00' AND dd.manifest = h.manifest) as in_kanban, h.sent, h.downloaded
              from manifest_detail d 
              join manifest_header h on h.manifest = d.manifest 
              join dp_eproc.vendor v on v.id_vendor = h.id_vendor
              join dp_eproc.user u on u.foreign_id = v.id_vendor
              where h.id_vendor = '".$id_vendor."' AND  h.mf_type = 'SO' AND u.status_user = 'A'
              group by d.manifest";
    //$result = mysql_query($query) or die(mysqli_error($conn));
    //mysql_close($conn);
	$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
    mysqli_close($conn);
    return $result;
}

function get_all_manifest_group_3(){

    $conn = get_connection_proc();
    $query = "SELECT h.manifest, d.kanban, h.delivery_date, h.po_num, h.id_vendor, h.stat, v.nm_vendor, d.material, d.material_desc, sum(d.qty_pack) as qty_tot, 
              count(d.kanban) as tot_kanban, SUM(d.qty_in) as tot_qty_in 
              from manifest_detail d 
              join manifest_header h on h.manifest = d.manifest 
              join dp_eproc.vendor v on v.id_vendor = h.id_vendor
              group by d.kanban";
    //$result = mysql_query($query) or die(mysqli_error($conn));
    //mysql_close($conn);
	$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
    mysqli_close($conn);
    return $result;
}


function get_all_manifest_group_4(){

    $conn = get_connection_proc();
    $query = "SELECT h.manifest, h.delivery_date, h.po_num, h.id_vendor, h.stat, h.active, v.nm_vendor, 
          d.material, d.material_desc, sum(d.qty_pack) as qty_tot, d.scan_date, count(d.kanban) as tot_kanban, 
          SUM(d.qty_in) as tot_qty_in, 
          (select count(dd.scan_date)from manifest_detail dd where dd.material = d.material and dd.scan_date <> '0000-00-00') as in_kanban, 
          h.sent, h.downloaded 
          from manifest_detail d 
          join manifest_header h on h.manifest = d.manifest 
          join dp_eproc.vendor v on v.id_vendor = h.id_vendor 
          group by d.manifest, d.material ";
    //$result = mysql_query($query) or die(mysqli_error($conn));
    //mysql_close($conn);
	$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
    mysqli_close($conn);
    return $result;
}

function update_mf_download_mail($data){

    $conn = get_connection_proc();
    $query = "UPDATE manifest_header mfh set mfh.downloaded = '".date("Y-m-d H:i:s")."' WHERE mfh.manifest = '".$data['manifest']."'  ";
    //$result = mysql_query($query) or die(mysqli_error($conn));
    //mysql_close($conn);
	$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
    mysqli_close($conn);
    return $result;
}

function get_vendor_user($id_user){

    $conn = get_connection();
    $query = "SELECT * from user u JOIN vendor v ON u.foreign_id = v.id_vendor WHERE u.id_user = '$id_user' ";
    //$result = mysql_query($query) or die(mysqli_error($conn));
    //mysql_close($conn);
	$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
    mysqli_close($conn);
    return $result;
}

?>