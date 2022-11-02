<?php

    include "conn/conn.php";

    date_default_timezone_set("Asia/Jakarta");

    function get_vendor_user2($id_user){

		$conn = get_connection(); 
		$query = "SELECT * FROM vendor v JOIN user u ON v.id_vendor = u.foreign_id WHERE id_user = '$id_user' ";
		/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);

	return $result;
	}

    function get_assigned_project_data_all(){

        $conn = get_connection();
        $query = "SELECT b.id_project, b.nm_project, d.id_vendor, a.id_product, a.id_part, a.id_doc_part, d.nm_vendor, d.allias from proj_vendor_assign a
                right join project b on a.id_project = b.id_project
                left join proj_doc_assign c on b.id_project = c.id_project
                left join vendor d on a.id_vendor = d.id_vendor
                group by b.id_project";
        /* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
        return $result;
    }

    function get_assigned_project_data_all2(){

        $conn = get_connection();
        $query = "SELECT b.id_project, b.nm_project, d.id_vendor, a.id_product, a.id_part, a.id_doc_part, d.nm_vendor, d.allias from proj_vendor_assign a
                right join project b on a.id_project = b.id_project
                left join proj_doc_assign c on b.id_project = c.id_Project
                left join vendor d on a.id_vendor = d.id_vendor
                group by b.id_project, a.id_vendor";
        /* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
        return $result;
    }


    function get_proj_doc_assign_data_menu($id_project){

        $conn = get_connection(); 
        $query = "SELECT a.*, b.doc_type, b.doc_required FROM proj_doc_assign a left join doc_part b on a.id_doc_part = b.id_doc_part WHERE id_project= '$id_project' AND doc_type ='P' AND (doc_required ='Y' OR doc_required = 'M') group by id_project, id_product, id_part, id_doc_part, check_params";
        /* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);

    return $result;
    }

    function get_proj_doc_assign_data_status_menu($id_project){

        $conn = get_connection(); 
        $query = "SELECT sum(check_status) as check_status FROM proj_doc_assign
            WHERE id_project= '$id_project'";
        /* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);

    return $result;
    }


    function get_proj_doc_assign_data_menu2($id_project, $id_vendor){

        $conn = get_connection(); 
        $query = "SELECT a.*, b.doc_type, b.doc_required FROM proj_vendor_assign a left join doc_part b on a.id_doc_part = b.id_doc_part WHERE id_project= '$id_project' AND doc_type ='V' AND (b.doc_required ='Y' OR b.doc_required = 'M') AND id_vendor = '$id_vendor' group by id_project, id_product, id_part, id_doc_part, check_params";
        /* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);

    return $result;
    }

    function get_proj_doc_assign_data_status_menu2($id_project, $id_vendor){

        $conn = get_connection(); 
        $query = "SELECT sum(check_status_a) as check_status FROM proj_vendor_assign
            WHERE id_project= '$id_project' AND id_vendor = '$id_vendor'";
        /* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);

    return $result;
    }

    function get_proj_doc_assign_data_status_menu3($id_project, $id_vendor){

        $conn = get_connection();
        $query = "SELECT sum(check_status_b) as check_status_b FROM proj_vendor_assign
            WHERE id_project= '$id_project' AND id_vendor = '$id_vendor'";
        /* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);

    return $result;
    }

    function get_proj_doc_assign_data_menu3($id_project, $id_vendor){

		$conn = get_connection(); 
		$query = "SELECT a.*, b.doc_type, b.doc_required FROM proj_vendor_assign a left join doc_part b on a.id_doc_part = b.id_doc_part WHERE id_project= '$id_project' AND doc_type ='V' AND (doc_required ='Y' OR doc_required = 'M') AND id_vendor = '$id_vendor' group by id_project, id_product, id_part, id_doc_part";
		/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);

	return $result;
	}

	function get_proj_doc_upload_data_status_menu3($id_project, $id_vendor){

		$conn = get_connection(); 
		$query = "SELECT a.*, b.doc_type, b.doc_required FROM proj_vendor_upload a left join doc_part b on a.id_doc_part = b.id_doc_part WHERE id_project= '$id_project' AND doc_type ='V' AND (b.doc_required ='Y' OR b.doc_required = 'M') AND upload_path <> '' AND id_vendor = '$id_vendor' group by id_project, id_product, id_part, id_doc_part";
		/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);

	return $result;
	}


	function get_assigned_project_data_all_vendor($id_vendor){

        $conn = get_connection();
        $query = "SELECT b.id_project, b.nm_project, d.id_vendor, a.id_product, a.id_part, a.id_doc_part, d.nm_vendor, d.allias from proj_vendor_assign a
                right join project b on a.id_project = b.id_project
                left join proj_doc_assign c on b.id_project = c.id_project
                left join vendor d on a.id_vendor = d.id_vendor
                WHERE a.id_vendor = '$id_vendor'
                group by b.id_project";
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