<?php
    //include "data-model/my-query.php";
	include_once "conn/conn_proc.php";
	include_once "conn/conn.php";

    date_default_timezone_set("Asia/Jakarta");

	//MASTER CERTIFICED
    function insert_mstcert_data($cert_name, $id_user){

		$conn = get_connection_proc();
		$query = "INSERT INTO mst_cert_type (cert_name, cr_by, cr_date) VALUES ( UPPER('".$cert_name."'), '".$id_user."', '".date("Y-m-d H:i:s")."' ) ";
		//$result = mysql_query($query) or die(mysqli_error($conn));
		//mysql_close($conn);
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}

	function get_mstcert_data_by_name($cert_name){

		$conn = get_connection_proc();
		$query = "SELECT * from mst_cert_type where cert_name = UPPER('".$cert_name."') ";
		//$result = mysql_query($query) or die(mysqli_error($conn));
		//mysql_close($conn);
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}

	function get_mstcert_data_by_id($cert_id){

		$conn = get_connection_proc();
		$query = "SELECT * from mst_cert_type where cert_id = ".$cert_id." ";
		//$result = mysql_query($query) or die(mysqli_error($conn));
		//mysql_close($conn);
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}

	function get_all_mstcert_data(){

		$conn = get_connection_proc();
		$query = "SELECT a.cert_id, a.cert_name, u.nm_user as created_by,  date_format(a.cr_date, '%d/%m/%Y') as created_on FROM mst_cert_type a 
					left join dp_eproc.user u ON a.cr_by = u.id_user ORDER BY a.cr_by DESC";
		//$result = mysql_query($query) or die(mysqli_error($conn));
		//mysql_close($conn);
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}


	//MASTER CERTIFICATE TYPE
    function insert_mstiso_data($cert_type_name, $id_user){

		$conn = get_connection_proc();
		$query = "INSERT INTO mst_iso_type (iso_type_name, cr_by, cr_date) VALUES ( UPPER('".$cert_type_name."'), '".$id_user."', '".date("Y-m-d H:i:s")."' ) ";
		//$result = mysql_query($query) or die(mysqli_error($conn));
		//mysql_close($conn);
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}

	function get_mstiso_data_by_name($cert_type_name){

		$conn = get_connection_proc();
		$query = "SELECT * from mst_iso_type where iso_type_name = UPPER('".$cert_type_name."') ";
		//$result = mysql_query($query) or die(mysqli_error($conn));
		//mysql_close($conn);
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}

	function get_mstiso_data_by_id($iso_type_id){

		$conn = get_connection_proc();
		$query = "SELECT * from mst_iso_type where iso_type_id = ".$iso_type_id." ";
		//$result = mysql_query($query) or die(mysqli_error($conn));
		//mysql_close($conn);
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}

	function get_all_mstiso_data(){

		$conn = get_connection_proc();
		$query = "SELECT a.iso_type_id, a.iso_type_name, u.nm_user as created_by,  date_format(a.cr_date, '%d/%m/%Y') as created_on FROM mst_iso_type a 
					left join dp_eproc.user u ON a.cr_by = u.id_user ORDER BY a.cr_by DESC";
		//$result = mysql_query($query) or die(mysqli_error($conn));
		//mysql_close($conn);
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}

	//MASTER NOTIFY
	function insert_mstnotif_data($notif_before, $uom, $id_user){

		$conn = get_connection_proc();
		$query = "INSERT INTO mst_iso_notify (notif_before, uom, cr_by, cr_date) VALUES ( '".$notif_before."', '".$uom."', '".$id_user."', '".date("Y-m-d H:i:s")."' ) ";
		//$result = mysql_query($query) or die(mysqli_error($conn));
		//mysql_close($conn);
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}

	function get_mstnotif_data_by_notif_measure($notif_before, $uom){

		$conn = get_connection_proc();
		$query = "SELECT * from mst_iso_notify where notif_before = ".$notif_before." AND uom = UPPER('".$uom."') ";
		//$result = mysql_query($query) or die(mysqli_error($conn));
		//mysql_close($conn);
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}

	function get_mstnotif_data_by_id($notif_id){

		$conn = get_connection_proc();
		$query = "SELECT * from mst_iso_notify where notif_id = '".$notif_id."' ";
		//$result = mysql_query($query) or die(mysqli_error($conn));
		//mysql_close($conn);
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}

	function get_all_mstnotif_data(){

		$conn = get_connection_proc();
		$query = "SELECT a.notif_id, a.notif_seq, a.notif_before, a.uom, u.nm_user as created_by,  date_format(a.cr_date, '%d/%m/%Y') as created_on FROM mst_iso_notify a 
					left join dp_eproc.user u ON a.cr_by = u.id_user ORDER BY a.cr_by DESC";
		//$result = mysql_query($query) or die(mysqli_error($conn));
		//mysql_close($conn);
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}

	//REGISTER ISO
	function insert_regiso_data($trn_id,
								$doc_year,
								$id_vendor, 
								$mat_supply,
								$simply,
								$cert_num,
								$cert_date,
								//$cert_id,
								$cert_name,
								//$iso_type_id,
								$iso_type_name,
								$exp_date,
								$stat,
								$doc_path,
								$remark,
								$trn_type,
								$ref_doc,
								$ref_doc_year,
								//$notif_id,
								//$notify_date, 
								$id_user)
	{
		$conn = get_connection_proc();
		$query = "INSERT INTO trn_iso_doc (
		trn_id,
		doc_year,
		id_vendor,
		mat_supply,
		simply,
		cert_num,
		cert_date,
		#cert_id,
		cert_name,
		#iso_type_id,
		iso_type_name,
		exp_date,
		stat,
		doc_path,
		remark,
		trn_type,
		ref_doc,
		ref_doc_year,
		cr_by,
		cr_date) VALUES
		( 
			'".$trn_id."',
			'".$doc_year."',
			'".$id_vendor."', 
			'".$mat_supply."',
			'".$simply."',
			'".$cert_num."',
			'".$cert_date."',
			'".$cert_name."',
			'".$iso_type_name."',
			'".$exp_date."',
			'".$stat."',
			'".$doc_path."',
			'".$remark."',
			'".$trn_type."',
			'".$ref_doc."',
			'".$ref_doc_year."',
			'".$id_user."',
			'".date("Y-m-d H:i:s")."'
		)";

		//$result = mysql_query($query) or die(mysqli_error($conn));
		//mysql_close($conn);
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}
	
	function get_regiso_data_by_certification($id_vendor, $iso_type_name, $cert_date, $cert_name){

		$conn = get_connection_proc();
		//$query = "SELECT * from trn_iso_doc where id_vendor = '".$id_vendor."' AND iso_type_id = ".$iso_type_id." 
				//	AND cert_date = '".$cert_date."' AND cert_id = ".$cert_id." ";

		$query = "SELECT * from trn_iso_doc where id_vendor = '".$id_vendor."' AND iso_type_name = ".$iso_type_name." 
					AND cert_date = '".$cert_date."' AND cert_name = ".$cert_name." ";
		//$result = mysql_query($query) or die(mysqli_error($conn));
		//mysql_close($conn);
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}

	function get_regiso_data_by_certf_num($id_vendor, $cert_num){

		$conn = get_connection_proc();
		$query = "SELECT * from trn_iso_doc where id_vendor = '".$id_vendor."' AND
					cert_num = '".$cert_num."' ";
		//$result = mysql_query($query) or die(mysqli_error($conn));
		//mysql_close($conn);
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}

	function get_user_iso_mail($key, $mnu_obj){

		/*
		if ($key == "") {
			$id_user  = $_SESSION['id_user'];
			$conditon = " AND U.id_user = '".$id_user."' ";
		} else{
			$conditon = " AND v.id_vendor = '".$key."' ";
		}
		*/
		$conn = get_connection_proc();
		$query = "SELECT u.id_user, v.id_vendor, v.nm_vendor, u.nm_user, u.username, u.id_access_group,  u.role,
					ag.access_group_name, ma.id_menu, mg.id_menu_group, gl.menu_group_name, gl.menu_group_object
					from dp_eproc.user u
					left join dp_eproc.vendor v on u.foreign_id = v.id_vendor
					left join dp_eproc.access_group_list ag on ag.id_access_group = u.id_access_group
					left join dp_eproc.menu_access_group ma on ma.id_access_group = u.id_access_group
					left join dp_eproc.menu_group mg on mg.id_menu = ma.id_menu
					left join dp_eproc.menu_group_list gl on gl.id_menu_group = mg.id_menu_group
					where ( u.status_user = 'A' )
					#AND v.id_vendor = '100085'
					#AND u.id_user = '00001'
					
					AND v.id_vendor = '".$key."'
					AND gl.menu_group_object = '".$mnu_obj."'
					group by u.id_user ";
		//$result = mysql_query($query) or die(mysqli_error($conn));
		//mysql_close($conn);
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}

	function get_all_user_iso_mail($key, $mnu_obj){

		$conn = get_connection_proc();
		$query = "SELECT u.id_user, v.id_vendor, v.nm_vendor, u.nm_user, u.username, u.id_access_group, u.role,
					ag.access_group_name, ma.id_menu, mg.id_menu_group, gl.menu_group_name, gl.menu_group_object
					from dp_eproc.user u
					left join dp_eproc.vendor v on u.foreign_id = v.id_vendor
					left join dp_eproc.access_group_list ag on ag.id_access_group = u.id_access_group
					left join dp_eproc.menu_access_group ma on ma.id_access_group = u.id_access_group
					left join dp_eproc.menu_group mg on mg.id_menu = ma.id_menu
					left join dp_eproc.menu_group_list gl on gl.id_menu_group = mg.id_menu_group
					where 
					( u.status_user = 'A' AND ( u.role = 'admin' or u.role = 'proc')
					AND gl.menu_group_object = '".$mnu_obj."' ) 
					AND u.nm_user like 'Osa%' OR u.nm_user like 'Hidrian%'
					group by u.id_user";
					//( u.status_user = 'A')
					//AND ( v.id_vendor = '".$key."' AND gl.menu_group_object = '".$mnu_obj."') OR
		//$result = mysql_query($query) or die(mysqli_error($conn));
		//mysql_close($conn);
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}

	function update_regiso_data($trn_id,
								$doc_year,
								$id_vendor, 
								$mat_supply,
								$simply,
								$cert_num,
								$cert_date,
								//$cert_id,
								$cert_name,
								//$iso_type_id,
								$iso_type_name,
								$exp_date,
								$stat,
								$doc_path,
								$remark,
								$trn_type,
								$id_user)
	{
		$conn = get_connection_proc();
		$query = "UPDATE trn_iso_doc SET 
		id_vendor 		= '".$id_vendor."',
		mat_supply 		= '".$mat_supply."',
		simply			= '".$simply."',
		cert_num		= '".$cert_num."',
		cert_date		= '".$cert_date."',
		cert_name		= '".$cert_name."',
		iso_type_name	= '".$iso_type_name."',
		exp_date		= '".$exp_date."',
		stat			= '".$stat."',
		doc_path		= '".$doc_path."',
		remark			= '".$remark."',
		trn_type		= '".$trn_type."',
		ch_by			= '".$id_user."',
		ch_date			= '".date("Y-m-d H:i:s")."'
		WHERE trn_id = '".$trn_id."' AND doc_year = '".$doc_year."' ";

		//$result = mysql_query($query) or die(mysqli_error($conn));
		//mysql_close($conn);
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}

	//ISO Dashboard
	function get_all_iso_data(){

		$conn = get_connection_proc();
		$query = "SELECT reg.trn_id, reg.doc_year, reg.id_vendor, v.nm_vendor, reg.mat_supply, reg.simply, reg.cert_num,
					date_format(reg.cert_date, '%d/%m/%Y') as cert_date, 
					#crt.cert_name, iso.iso_type_name, 
					date_format(reg.exp_date, '%d/%m/%Y') as exp_date, reg.stat,
					reg.doc_path, date_format(reg.ch_date, '%d/%m/%Y %H:%i:%s') as ch_date, 
					date_format(reg.cr_date, '%d/%m/%Y %H:%i:%s') as cr_date, reg.remark, reg.trn_type,
					u.nm_user as created_by, uc.nm_user as changed_by,
					reg.cert_name, reg.iso_type_name,  
					#reg.notif_id, ntf.notif_before, ntf.uom,
					date_format(reg.cr_date, '%d/%m/%Y') as created_on,
					ref_doc, ref_doc_year
					FROM trn_iso_doc as reg
					left join dp_eproc.user u ON reg.cr_by = u.id_user 
					left join dp_eproc.user uc ON reg.ch_by = uc.id_user 
					left join dp_eproc.vendor v ON reg.id_vendor = v.id_vendor 
					#left join mst_cert_type as crt ON reg.cert_id = crt.cert_id
					#left join mst_iso_notify as ntf ON reg.notif_id = ntf.notif_id
					#left join mst_iso_type as iso On reg.iso_type_id = iso.iso_type_id 
					WHERE reg.del_indicator <> 'X' AND reg.stat <> 'N'
					ORDER BY reg.cr_date DESC";
		//$result = mysql_query($query) or die(mysqli_error($conn));
		//mysql_close($conn);
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}

	function get_all_iso_data_by_trn_type($trn_type){

		$conn = get_connection_proc();
		$query = "SELECT reg.trn_id, reg.doc_year, reg.id_vendor, v.nm_vendor, reg.mat_supply, reg.simply, reg.cert_num,
					date_format(reg.cert_date, '%d/%m/%Y') as cert_date, 
					#crt.cert_name, iso.iso_type_name, 
					date_format(reg.exp_date, '%d/%m/%Y') as exp_date, reg.stat,
					reg.doc_path, date_format(reg.ch_date, '%d/%m/%Y %H:%i:%s') as ch_date, 
					date_format(reg.cr_date, '%d/%m/%Y %H:%i:%s') as cr_date, reg.remark, reg.trn_type,
					u.nm_user as created_by, uc.nm_user as changed_by,
					reg.cert_name, reg.iso_type_name,  
					#reg.notif_id, ntf.notif_before, ntf.uom,
					date_format(reg.cr_date, '%d/%m/%Y') as created_on,
					ref_doc, ref_doc_year
					FROM trn_iso_doc as reg
					left join dp_eproc.user u ON reg.cr_by = u.id_user 
					left join dp_eproc.user uc ON reg.ch_by = uc.id_user 
					left join dp_eproc.vendor v ON reg.id_vendor = v.id_vendor 
					#left join mst_cert_type as crt ON reg.cert_id = crt.cert_id
					#left join mst_iso_notify as ntf ON reg.notif_id = ntf.notif_id
					#left join mst_iso_type as iso On reg.iso_type_id = iso.iso_type_id 
					WHERE reg.del_indicator <> 'X' AND
					reg.trn_type = '".$trn_type."'
					ORDER BY reg.cr_by DESC";
		//$result = mysql_query($query) or die(mysqli_error($conn));
		//mysql_close($conn);
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}

	function get_all_iso_data_by_stat($stat){

		$conn = get_connection_proc();
		$query = "SELECT reg.trn_id, reg.doc_year, reg.id_vendor, v.nm_vendor, reg.mat_supply, reg.simply, reg.cert_num,
					date_format(reg.cert_date, '%d/%m/%Y') as cert_date, 
					#crt.cert_name, iso.iso_type_name, 
					date_format(reg.exp_date, '%d/%m/%Y') as exp_date, reg.stat,
					reg.doc_path, date_format(reg.ch_date, '%d/%m/%Y %H:%i:%s') as ch_date, 
					date_format(reg.cr_date, '%d/%m/%Y %H:%i:%s') as cr_date, reg.remark, reg.trn_type,
					u.nm_user as created_by, uc.nm_user as changed_by,
					reg.cert_name, reg.iso_type_name,  
					#reg.notif_id, ntf.notif_before, ntf.uom,
					date_format(reg.cr_date, '%d/%m/%Y') as created_on,
					ref_doc, ref_doc_year
					FROM trn_iso_doc as reg
					left join dp_eproc.user u ON reg.cr_by = u.id_user 
					left join dp_eproc.user uc ON reg.ch_by = uc.id_user 
					left join dp_eproc.vendor v ON reg.id_vendor = v.id_vendor 
					#left join mst_cert_type as crt ON reg.cert_id = crt.cert_id
					#left join mst_iso_notify as ntf ON reg.notif_id = ntf.notif_id
					#left join mst_iso_type as iso On reg.iso_type_id = iso.iso_type_id 
					WHERE reg.del_indicator <> 'X' AND
					reg.stat = '".$stat."'
					ORDER BY reg.cr_date DESC";
		//$result = mysql_query($query) or die(mysqli_error($conn));
		//mysql_close($conn);
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}

	function get_all_iso_data_by_trn_id($trn_id, $doc_year){

		$conn = get_connection_proc();
		$query = "SELECT reg.trn_id, reg.doc_year, reg.id_vendor, v.nm_vendor, reg.mat_supply, reg.simply, reg.cert_num,
					date_format(reg.cert_date, '%d/%m/%Y') as cert_date, 
					reg.cert_date as cert_date_us,
					#crt.cert_name, iso.iso_type_name, 
					date_format(reg.exp_date, '%d/%m/%Y') as exp_date, 
					reg.exp_date as exp_date_us,
					reg.stat, reg.doc_path, date_format(reg.ch_date, '%d/%m/%Y %H:%i:%s') as ch_date, 
					date_format(reg.cr_date, '%d/%m/%Y %H:%i:%s') as cr_date, reg.remark, reg.trn_type,
					u.nm_user as created_by, uc.nm_user as changed_by,
					reg.cert_name, reg.iso_type_name, 
					#reg.notif_id, ntf.notif_before, ntf.uom,
					date_format(reg.cr_date, '%d/%m/%Y') as created_on,
					ref_doc, ref_doc_year 
					FROM trn_iso_doc as reg
					left join dp_eproc.user u ON reg.cr_by = u.id_user 
					left join dp_eproc.user uc ON reg.ch_by = uc.id_user 
					left join dp_eproc.vendor v ON reg.id_vendor = v.id_vendor 
					#left join mst_cert_type as crt ON reg.cert_id = crt.cert_id
					#left join mst_iso_notify as ntf ON reg.notif_id = ntf.notif_id
					#left join mst_iso_type as iso On reg.iso_type_id = iso.iso_type_id 
					where trn_id = '".$trn_id."' AND doc_year = '".$doc_year."' AND reg.del_indicator <> 'X'
					ORDER BY reg.cr_by DESC";
		//$result = mysql_query($query) or die(mysqli_error($conn));
		//mysql_close($conn);
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}

	function get_all_iso_data_by_vendor($id_vendor){

		$conn = get_connection_proc();
		$query = "SELECT reg.trn_id, reg.doc_year, reg.id_vendor, v.nm_vendor, reg.mat_supply, reg.simply, reg.cert_num,
					date_format(reg.cert_date, '%d/%m/%Y') as cert_date, 
					#crt.cert_name, iso.iso_type_name, 
					date_format(reg.exp_date, '%d/%m/%Y') as exp_date, reg.stat,
					reg.doc_path, date_format(reg.ch_date, '%d/%m/%Y %H:%i:%s') as ch_date, 
					date_format(reg.cr_date, '%d/%m/%Y %H:%i:%s') as cr_date, reg.remark, reg.trn_type,
					u.nm_user as created_by, uc.nm_user as changed_by,
					reg.cert_name, reg.iso_type_name, 
					#reg.notif_id, ntf.notif_before, ntf.uom,
					date_format(reg.cr_date, '%d/%m/%Y') as created_on,
					ref_doc, ref_doc_year 
					FROM trn_iso_doc as reg
					left join dp_eproc.user u ON reg.cr_by = u.id_user 
					left join dp_eproc.user uc ON reg.ch_by = uc.id_user 
					left join dp_eproc.vendor v ON reg.id_vendor = v.id_vendor 
					#left join mst_cert_type as crt ON reg.cert_id = crt.cert_id
					#left join mst_iso_notify as ntf ON reg.notif_id = ntf.notif_id
					#left join mst_iso_type as iso On reg.iso_type_id = iso.iso_type_id 
					where reg.id_vendor = '".$id_vendor."' AND reg.del_indicator <> 'X'
					AND reg.stat <> 'N'
					ORDER BY reg.cr_date DESC";
		//$result = mysql_query($query) or die(mysqli_error($conn));
		//mysql_close($conn);
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}

	function get_all_iso_data_by_vendor_trn_type($id_vendor, $trn_type){

		$conn = get_connection_proc();
		$query = "SELECT reg.trn_id, reg.doc_year, reg.id_vendor, v.nm_vendor, reg.mat_supply, reg.simply, reg.cert_num,
					date_format(reg.cert_date, '%d/%m/%Y') as cert_date, 
					#crt.cert_name, iso.iso_type_name, 
					date_format(reg.exp_date, '%d/%m/%Y') as exp_date, reg.stat,
					reg.doc_path, date_format(reg.ch_date, '%d/%m/%Y %H:%i:%s') as ch_date, 
					date_format(reg.cr_date, '%d/%m/%Y %H:%i:%s') as cr_date, reg.remark, reg.trn_type,
					u.nm_user as created_by, uc.nm_user as changed_by,
					reg.cert_name, reg.iso_type_name, 
					#reg.notif_id, ntf.notif_before, ntf.uom,
					date_format(reg.cr_date, '%d/%m/%Y') as created_on,
					ref_doc, ref_doc_year 
					FROM trn_iso_doc as reg
					left join dp_eproc.user u ON reg.cr_by = u.id_user 
					left join dp_eproc.user uc ON reg.ch_by = uc.id_user 
					left join dp_eproc.vendor v ON reg.id_vendor = v.id_vendor 
					#left join mst_cert_type as crt ON reg.cert_id = crt.cert_id
					#left join mst_iso_notify as ntf ON reg.notif_id = ntf.notif_id
					#left join mst_iso_type as iso On reg.iso_type_id = iso.iso_type_id 
					where reg.id_vendor = '".$id_vendor."' AND reg.del_indicator <> 'X' AND
						reg.trn_type = '".$trn_type."'
					ORDER BY reg.cr_date DESC";
		//$result = mysql_query($query) or die(mysqli_error($conn));
		//mysql_close($conn);
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}

	function get_all_iso_data_by_vendor_stat($id_vendor, $stat){

		$conn = get_connection_proc();
		$query = "SELECT reg.trn_id, reg.doc_year, reg.id_vendor, v.nm_vendor, reg.mat_supply, reg.simply, reg.cert_num,
					date_format(reg.cert_date, '%d/%m/%Y') as cert_date, 
					#crt.cert_name, iso.iso_type_name, 
					date_format(reg.exp_date, '%d/%m/%Y') as exp_date, reg.stat,
					reg.doc_path, date_format(reg.ch_date, '%d/%m/%Y %H:%i:%s') as ch_date, 
					date_format(reg.cr_date, '%d/%m/%Y %H:%i:%s') as cr_date, reg.remark, reg.trn_type,
					u.nm_user as created_by, uc.nm_user as changed_by,
					reg.cert_name, reg.iso_type_name, 
					#reg.notif_id, ntf.notif_before, ntf.uom,
					date_format(reg.cr_date, '%d/%m/%Y') as created_on,
					ref_doc, ref_doc_year 
					FROM trn_iso_doc as reg
					left join dp_eproc.user u ON reg.cr_by = u.id_user 
					left join dp_eproc.user uc ON reg.ch_by = uc.id_user 
					left join dp_eproc.vendor v ON reg.id_vendor = v.id_vendor 
					#left join mst_cert_type as crt ON reg.cert_id = crt.cert_id
					#left join mst_iso_notify as ntf ON reg.notif_id = ntf.notif_id
					#left join mst_iso_type as iso On reg.iso_type_id = iso.iso_type_id 
					where reg.id_vendor = '".$id_vendor."' AND reg.del_indicator <> 'X' AND
						reg.stat = '".$stat."'
					ORDER BY reg.cr_date DESC";
		//$result = mysql_query($query) or die(mysqli_error($conn));
		//mysql_close($conn);
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}

	function get_all_iso_data_by_vendor_trn_id($id_vendor, $trn_id, $doc_year){

		$conn = get_connection_proc();
		$query = "SELECT reg.trn_id, reg.doc_year, reg.id_vendor, v.nm_vendor, reg.mat_supply, reg.simply, reg.cert_num,
					date_format(reg.cert_date, '%d/%m/%Y') as cert_date, 
					reg.cert_date as cert_date_us, 
					#crt.cert_name, iso.iso_type_name, 
					date_format(reg.exp_date, '%d/%m/%Y') as exp_date, 
					reg.exp_date as exp_date_us, 
					reg.stat, reg.doc_path, date_format(reg.ch_date, '%d/%m/%Y %H:%i:%s') as ch_date, 
					date_format(reg.cr_date, '%d/%m/%Y %H:%i:%s') as cr_date, reg.remark, reg.trn_type,
					u.nm_user as created_by, uc.nm_user as changed_by,
					reg.cert_name, reg.iso_type_name, 
					#reg.notif_id, ntf.notif_before, ntf.uom,
					date_format(reg.cr_date, '%d/%m/%Y') as created_on,
					ref_doc, ref_doc_year 
					FROM trn_iso_doc as reg
					left join dp_eproc.user u ON reg.cr_by = u.id_user 
					left join dp_eproc.user uc ON reg.ch_by = uc.id_user 
					left join dp_eproc.vendor v ON reg.id_vendor = v.id_vendor 
					#left join mst_cert_type as crt ON reg.cert_id = crt.cert_id
					#left join mst_iso_notify as ntf ON reg.notif_id = ntf.notif_id
					#left join mst_iso_type as iso On reg.iso_type_id = iso.iso_type_id 
					where reg.id_vendor = '".$id_vendor."' AND trn_id = '".$trn_id."' AND doc_year = '".$doc_year."' AND reg.del_indicator <> 'X'
					ORDER BY reg.cr_by DESC";
		//$result = mysql_query($query) or die(mysqli_error($conn));
		//mysql_close($conn);
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}

	function get_all_iso_data_by_ref_trn_id($ref_trn_id, $ref_doc_year){

		$conn = get_connection_proc();
		$query = "SELECT reg.trn_id, reg.doc_year, reg.id_vendor, v.nm_vendor, reg.mat_supply, reg.simply, reg.cert_num,
					date_format(reg.cert_date, '%d/%m/%Y') as cert_date, 
					#crt.cert_name, iso.iso_type_name, 
					date_format(reg.exp_date, '%d/%m/%Y') as exp_date, reg.stat,
					reg.doc_path, date_format(reg.ch_date, '%d/%m/%Y %H:%i:%s') as ch_date, 
					date_format(reg.cr_date, '%d/%m/%Y %H:%i:%s') as cr_date, reg.remark, reg.trn_type,
					u.nm_user as created_by, uc.nm_user as changed_by,
					reg.cert_name, reg.iso_type_name, 
					#reg.notif_id, ntf.notif_before, ntf.uom,
					date_format(reg.cr_date, '%d/%m/%Y') as created_on,
					ref_doc, ref_doc_year 
					FROM trn_iso_doc as reg
					left join dp_eproc.user u ON reg.cr_by = u.id_user 
					left join dp_eproc.user uc ON reg.ch_by = uc.id_user 
					left join dp_eproc.vendor v ON reg.id_vendor = v.id_vendor 
					#left join mst_cert_type as crt ON reg.cert_id = crt.cert_id
					#left join mst_iso_notify as ntf ON reg.notif_id = ntf.notif_id
					#left join mst_iso_type as iso On reg.iso_type_id = iso.iso_type_id 
					where ref_doc = '".$ref_trn_id."' AND ref_doc_year = '".$ref_doc_year."' AND reg.del_indicator <> 'X'
					ORDER BY reg.cr_by DESC";
		//$result = mysql_query($query) or die(mysqli_error($conn));
		//mysql_close($conn);
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}

	//Doc Status
	function get_transaction_type_id($trn_id){

		$conn = get_connection_proc();
		$query = "SELECT * from transaction_type where trn_id = '".$trn_id."' ";
		//$result = mysql_query($query) or die(mysqli_error($conn));
		//mysql_close($conn);
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}

	function get_reg_iso_by_stat($stat, $key){

		if ($key != "" ) { 
			$conditon = "AND id_vendor = '".$key."' "; 
		} 
		else {
			$conditon = "";
		}
		$conn = get_connection_proc();
		$query = "SELECT trn_id, id_vendor FROM trn_iso_doc WHERE stat = '".$stat."' $conditon ";
		//$result = mysql_query($query) or die(mysqli_error($conn));
		//mysql_close($conn);
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}


	function get_reg_iso_all_stat($key){

		if ($key != "" ) { 
			$conditon = "AND id_vendor = '".$key."' "; 
		} 
		else {
			$conditon = "";
		}
		$conn = get_connection_proc();
		$query = "SELECT trn_id, id_vendor FROM trn_iso_doc WHERE del_indicator <> 'X' $conditon ";
		//$result = mysql_query($query) or die(mysqli_error($conn));
		//mysql_close($conn);
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}

	function get_reg_iso_by_trn_type($trn_type, $key){

		if ($key != "" ) { 
			$conditon = "AND id_vendor = '".$key."' "; 
		} 
		else {
			$conditon = "";
		}
		$conn = get_connection_proc();
		$query = "SELECT trn_id, id_vendor FROM trn_iso_doc WHERE trn_type = '".$trn_type."' AND del_indicator <> 'X' $conditon ";
		//$result = mysql_query($query) or die(mysqli_error($conn));
		//mysql_close($conn);
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}

	function update_trn_reg_iso($trn_id, $doc_year, $trn_type){

		$conn = get_connection_proc();
		$query = "UPDATE trn_iso_doc set trn_type = '".$trn_type."' where trn_id = '".$trn_id."' AND doc_year = '".$doc_year."' AND del_indicator <> 'X' ";
		//$result = mysql_query($query) or die(mysqli_error($conn));
		//mysql_close($conn);
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}

	function approval_trn_reg_iso($trn_id, $doc_year, $simply, $mat_supply, $trn_type){

		$conn = get_connection_proc();
		$query = "UPDATE trn_iso_doc set trn_type = '".$trn_type."', simply = '".$simply."', mat_supply = '".$mat_supply."'
				 where trn_id = '".$trn_id."' AND doc_year = '".$doc_year."' AND del_indicator <> 'X' ";
		//$result = mysql_query($query) or die(mysqli_error($conn));
		//mysql_close($conn);
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}

	function approval_stat_reg_iso($trn_id, $doc_year, $simply, $stat){

		$conn = get_connection_proc();
		$query = "UPDATE trn_iso_doc set stat = '".$stat."', simply = '".$simply."'
				 where trn_id = '".$trn_id."' AND doc_year = '".$doc_year."' AND del_indicator <> 'X' ";
		//$result = mysql_query($query) or die(mysqli_error($conn));
		//mysql_close($conn);
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}

	//DOC LOG
	function insert_iso_log($trn_id, $doc_year, $id_user, $trn_type, $trn_date, $trn_time, $ip_addr, $trn_detail){

		$conn = get_connection_proc();
		$query = "INSERT into trn_iso_log (trn_id, doc_year, id_user, trn_type, trn_date, trn_time, ip_address, trn_detail) VALUES 
					('".$trn_id."', '".$doc_year."', '".$id_user."', '".$trn_type."', '".$trn_date."', '".$trn_time."', 
					'".$ip_addr."', '".$trn_detail."' ) ";
		//$result = mysql_query($query) or die(mysqli_error($conn));
		//mysql_close($conn);
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}

	//NOTIFY 
	function get_all_notif_iso($trn_id, $doc_year){

		$conn = get_connection_proc();
		$query = "SELECT * FROM trn_iso_notif ntf where trn_id = '".$trn_id."' AND doc_year = '".$doc_year."' 
					order by notify_date asc";
		//$result = mysql_query($query) or die(mysqli_error($conn));
		//mysql_close($conn);
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}

	function insert_notif_iso($trn_id, $doc_year, $notif_id, $notif_before, $uom, $notify_date){

		$conn = get_connection_proc();
		$query = "INSERT into trn_iso_notif (trn_id, doc_year, notif_id, notif_before, uom, notify_date) VALUES 
					('".$trn_id."', '".$doc_year."', '".$notif_id."', '".$notif_before."', '".$uom."', '".$notify_date."' ) ";
		//$result = mysql_query($query) or die(mysqli_error($conn));
		//mysql_close($conn);
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}

	function update_notif_iso($trn_id, $doc_year, $notif_id, $notif_before, $uom, $notify_date){

		$conn = get_connection_proc();
		$query = "UPDATE trn_iso_notif SET
					notif_before= '".$notif_before."',	 
					uom			= '".$uom."',
					notify_date	= '".$notify_date."'
					WHERE
					trn_id	 	= '".$trn_id."'	AND
					doc_year 	= '".$doc_year."' AND
					notif_id	= '".$notif_id."'
				";
		//$result = mysql_query($query) or die(mysqli_error($conn));
		//mysql_close($conn);
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}

	//NUMBER RANGE
	function get_number_range($doc_type, $doc_year){

		$conn = get_connection_proc();
		$query = "SELECT *, (a.current_num + 1) as trn_num FROM doc_number as a WHERE a.doc_type = '".$doc_type."' AND a.doc_year = '".$doc_year."'  ";
		//$result = mysql_query($query) or die(mysqli_error($conn));
		//mysql_close($conn);
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}

	function update_number_range($doc_type, $doc_year){

		$conn = get_connection_proc();
		$query = "UPDATE doc_number as a set a.current_num  = (a.current_num + 1) where a.doc_type = '".$doc_type."' and a.doc_year = '".$doc_year."'  ";
		//$result = mysql_query($query) or die(mysqli_error($conn));
		//mysql_close($conn);
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}
	

?>