<?php
    include "../view/conn/conn_proc.php";
    include "../view/conn/conn.php";

    function get_all_iso_data(){

        $conn = get_connection_proc();
        $query = "SELECT reg.trn_id, reg.doc_year, reg.id_vendor, v.nm_vendor, reg.mat_supply, reg.simply, reg.cert_num,
                    date_format(reg.cert_date, '%d.%m.%Y') as cert_date, 
                    #crt.cert_name, iso.iso_type_name, reg.exp_date as expire_date,
                    date_format(reg.exp_date, '%d.%m.%Y') as exp_date, reg.stat,
                    reg.doc_path, date_format(reg.ch_date, '%d/%m/%Y %H:%i:%s') as ch_date, date_format(reg.cr_date, '%d/%m/%Y %H:%i:%s') as cr_date, reg.remark, reg.trn_type,
                    u.nm_user as created_by, uc.nm_user as changed_by,
                    reg.cert_name, reg.iso_type_name, 
                    #date_format(date_format(reg.cr_date, '%d/%m/%Y %H:%i:%s') as cr_date, '%d.%m.%Y') as created_on,
					date_format(reg.cr_date, '%d/%m/%Y %H:%i:%s') as created_on,
                    ntf.notif_id, ntf.notify_date
                    FROM trn_iso_doc as reg
                    left join dp_eproc.user u ON reg.cr_by = u.id_user 
                    left join dp_eproc.user uc ON reg.ch_by = uc.id_user 
                    left join dp_eproc.vendor v ON reg.id_vendor = v.id_vendor 
                    #left join mst_cert_type as crt ON reg.cert_id = crt.cert_id
                    #left join mst_iso_type as iso On reg.iso_type_id = iso.iso_type_id 
                    left join trn_iso_notif as ntf ON ntf.trn_id = reg.trn_id AND 
                                                    ntf.doc_year = reg.doc_year 
                    WHERE reg.del_indicator <> 'X' AND
                        reg.stat = 'V' 
                    ORDER BY reg.cr_by DESC";
        //$result = mysql_query($query) or die(mysql_error());
        //mysql_close($conn);
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
        mysqli_close($conn);
    return $result;
    }

    function update_stat_reg_iso($trn_id, $doc_year, $stat){

        $conn = get_connection_proc();
        $query = "UPDATE trn_iso_doc set stat = '".$stat."' where trn_id = '".$trn_id."' AND doc_year = '".$doc_year."' AND del_indicator <> 'X' ";
        //$result = mysql_query($query) or die(mysql_error());
        //mysql_close($conn);
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
        mysqli_close($conn);
    return $result;
    }

    function update_trn_reg_iso($trn_id, $doc_year, $trn_type){

        $conn = get_connection_proc();
        $query = "UPDATE trn_iso_doc set trn_type = '".$trn_type."' where trn_id = '".$trn_id."' AND doc_year = '".$doc_year."' AND del_indicator <> 'X' ";
        //$result = mysql_query($query) or die(mysql_error());
        //mysql_close($conn);
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
        mysqli_close($conn);
    return $result;
    }

    function insert_iso_log($trn_id, $doc_year, $id_user, $trn_type, $trn_date, $trn_time, $ip_addr, $trn_detail){

        $conn = get_connection_proc();
        $query = "INSERT into trn_iso_log (trn_id, doc_year, id_user, trn_type, trn_date, trn_time, ip_address, trn_detail) VALUES 
                    ('".$trn_id."', '".$doc_year."', '".$id_user."', '".$trn_type."', '".$trn_date."', '".$trn_time."', 
                    '".$ip_addr."', '".$trn_detail."' ) ";
        //$result = mysql_query($query) or die(mysql_error());
        //mysql_close($conn);
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
        mysqli_close($conn);
    return $result;
    }

    function get_transaction_type_id($trn_id){

		$conn = get_connection_proc();
		$query = "SELECT * from transaction_type where trn_id = '".$trn_id."' ";
		//$result = mysql_query($query) or die(mysql_error());
        //mysql_close($conn);
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
        mysqli_close($conn);
	return $result;
	}

    function get_mails(){

        $conn = get_connection_proc();
        $query = "SELECT * FROM mail_mgt where active = 'A' ";
        //$result = mysql_query($query) or die(mysql_error());
        //mysql_close($conn);
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
        mysqli_close($conn);
        return $result;
    }

    function get_all_iso_data_by_vendor_trn_id($id_vendor, $trn_id, $doc_year){

		$conn = get_connection_proc();
		$query = "SELECT reg.trn_id, reg.doc_year, reg.id_vendor, v.nm_vendor, reg.mat_supply, reg.simply, reg.cert_num,
					date_format(reg.cert_date, '%d.%m.%Y') as cert_date, 
					#crt.cert_name, iso.iso_type_name, 
					date_format(reg.exp_date, '%d.%m.%Y') as exp_date, reg.stat,
					reg.doc_path, date_format(reg.ch_date, '%d/%m/%Y %H:%i:%s') as ch_date, date_format(reg.cr_date, '%d/%m/%Y %H:%i:%s') as cr_date, reg.remark, reg.trn_type,
					u.nm_user as created_by, uc.nm_user as changed_by,
					reg.cert_name, reg.iso_type_name, 
					#reg.notif_id, ntf.notif_before, ntf.uom,
					#date_format(date_format(reg.cr_date, '%d/%m/%Y %H:%i:%s') as cr_date, '%d.%m.%Y') as created_on 
					date_format(reg.cr_date, '%d/%m/%Y %H:%i:%s') as created_on 
					FROM trn_iso_doc as reg
					left join dp_eproc.user u ON reg.cr_by = u.id_user 
					left join dp_eproc.user uc ON reg.ch_by = uc.id_user 
					left join dp_eproc.vendor v ON reg.id_vendor = v.id_vendor 
					#left join mst_cert_type as crt ON reg.cert_id = crt.cert_id
					#left join mst_iso_notify as ntf ON reg.notif_id = ntf.notif_id
					#left join mst_iso_type as iso On reg.iso_type_id = iso.iso_type_id 
					where reg.id_vendor = '".$id_vendor."' AND trn_id = '".$trn_id."' AND doc_year = '".$doc_year."' AND reg.del_indicator <> 'X'
					ORDER BY reg.cr_by DESC";
		//$result = mysql_query($query) or die(mysql_error());
        //mysql_close($conn);
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
        mysqli_close($conn);
	return $result;
    }
    
    function update_trn_iso_notif($trn_id, $doc_year, $notif_id, $notified_at, $notified_to, $remark){

        $conn = get_connection_proc();
        $query = "UPDATE trn_iso_notif set notified_at = '".$notified_at."', notified_to = '".$notified_to."', remark = '".$remark."'
                where trn_id = '".$trn_id."' 
                AND doc_year = '".$doc_year."' 
                AND notif_id = '".$notif_id."'  ";
        //$result = mysql_query($query) or die(mysql_error());
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
		//$result = mysql_query($query) or die(mysql_error());
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
		//$result = mysql_query($query) or die(mysql_error());
        //mysql_close($conn);
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
        mysqli_close($conn);
	return $result;
	}
?>