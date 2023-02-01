<?php
    //include "data-model/my-query.php";
    //include_once "conn/conn.php";

    date_default_timezone_set("Asia/Jakarta");

    //PROJECT
    function insert_project_data($id_project, $proj_num, $nm_project, $id_user){

		$conn = get_connection();
		$query = "INSERT INTO project (id_project, proj_num, nm_project, modify_date, id_user) VALUES ('$id_project', '$proj_num', '$nm_project', '".date("Y-m-d")."', '$id_user')";
		/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}

	function get_all_project_data(){

		$conn = get_connection();
		$query = "SELECT p.id_project, p.proj_num, p.nm_project,  date_format(p.modify_date, '%d.%m.%Y') as modify_date, p.status, p.assigned, u.nm_user FROM project p left join user u ON p.id_user = u.id_user ORDER BY p.id_project ASC";
		/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}

	function get_unassigned_project_data(){

		$conn = get_connection();
		$query = "SELECT * FROM project WHERE status='A' AND assigned='N'";
		/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}

	function get_assigned_project_data(){

		$conn = get_connection();
		$query = "SELECT * FROM project WHERE status='A' AND assigned='Y'";
		/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}

	function get_project_data_by_id($id_project){

	$conn = get_connection();
	$query = "SELECT p.id_project, p.proj_num, p.nm_project,  date_format(p.modify_date, '%d.%m.%Y') as modify_date, u.nm_user FROM project p left join user u ON p.id_user = u.id_user WHERE p.id_project='$id_project' ORDER BY p.id_project ASC";
	/* $result = mysql_query($query) or die(mysqli_error($conn));
	mysql_close($conn); */
	$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
	mysqli_close($conn);
	return $result;
	}


	function get_vendor_project_data(){

		$conn = get_connection();
		$query = "SELECT a.id_project, b.nm_vendor,  date_format(a.modify_date, '%d.%m.%Y') AS date_assign, c.*, d.nm_user FROM project_assign a
					JOIN vendor b ON a.id_vendor = b.id_vendor 
					JOIN project c ON a.id_project = c.id_project 
					JOIN user d ON a.id_user = d.id_user 
					ORDER BY a.id_project ASC ";
		/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}


	//PROJECT ASSIGNMENT
	function get_all_assignment_project_data(){

		$conn = get_connection();
		$query = "SELECT a.id_project, c.nm_project, a.id_product, f.nm_product, b.id_part, d.nm_part, date_format(a.modify_date, '%d.%m.%Y') as modify_date, e.nm_user FROM product_for_project a 
			JOIN part_for_product b ON b.id_product=a.id_product 
			JOIN project c ON c.id_project=a.id_project
			JOIN part d ON d.id_part = b.id_part
			JOIN user e ON e.id_user = a.id_user
			JOIN product f ON f.id_product = a.id_product
			ORDER BY a.id_project, a.id_product ASC";
		/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}

	function insert_product_for_project_data($id_project, $id_product, $id_user){

		$conn = get_connection();
		$query = "INSERT INTO product_for_project (id_project, id_product, modify_date, id_user) VALUES ('$id_project', '$id_product', '".date("Y-m-d")."', '$id_user')";
		/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}

	function update_project_assign($id_project, $id_user){

		$conn = get_connection();
		$query = "UPDATE project SET assigned='Y', modify_date='".date("Y-m-d")."', id_user='$id_user' WHERE id_project='$id_project'";
		/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}	

    //PRODUCT
	function get_all_prod_data(){

		$conn = get_connection();
		$query = "SELECT p.id_product, p.prod_num, p.nm_product, date_format(p.modify_date, '%d.%m.%Y') as modify_date, p.status, p.assigned, u.nm_user FROM product p left join user u ON p.id_user = u.id_user ORDER BY p.id_product ASC";
		/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}

	function get_all_assigned_product_data(){

		$conn = get_connection();
		$query = "SELECT DISTINCT p.id_product, pr.nm_product FROM part_for_product p JOIN product pr ON pr.id_product = p.id_product ORDER BY p.id_product ASC";
		/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}

	function get_prod_data_by_id($id_product){

	$conn = get_connection();
	$query = "SELECT p.id_product, p.prod_num, p.nm_product, date_format(p.modify_date, '%d.%m.%Y') as modify_date, u.nm_user FROM product p left join user u ON p.id_user = u.id_user WHERE p.id_product='$id_product' ORDER BY p.id_product ASC";
	/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
}

function insert_prod_data($id_product, $prod_num, $nm_product, $id_user){

	$conn = get_connection();
	$query = "INSERT INTO product (id_product, prod_num, nm_product, modify_date, id_user) VALUES ('$id_product', '$prod_num','$nm_product', '".date("Y-m-d")."', '$id_user')";
	/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
}

function get_unassigned_prod_data(){

		$conn = get_connection();
		$query = "SELECT * FROM product WHERE status='A' AND assigned='N'";
		/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}

function update_product_assign($id_product, $id_user){

		$conn = get_connection();
		$query = "UPDATE product SET assigned='Y', modify_date='".date("Y-m-d")."', id_user='$id_user' WHERE id_product='$id_product'";
		/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}	

//PART
function get_all_part_data(){

		$conn = get_connection();
		$query = "SELECT * FROM part p left join user u ON p.id_user = u.id_user ORDER BY p.id_part ASC";
		/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}

	function get_part_data_by_id($id_part){

	$conn = get_connection();
	$query = "SELECT * FROM part p left join user u ON p.id_user = u.id_user WHERE p.id_part='$id_part' ORDER BY p.id_part ASC";
	/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
}

function insert_part_data($id_part, $part_num, $nm_part, $id_user){

	$conn = get_connection();
	$query = "INSERT INTO part (id_part, part_num, nm_part, modify_date, id_user) VALUES ('$id_part', '$part_num', '$nm_part', '".date("Y-m-d")."', '$id_user')";
	/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
}

function get_unassigned_part_data(){

		$conn = get_connection();
		$query = "SELECT * FROM part WHERE status='A' AND assigned='N'";
		/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}

	function update_part_assign($id_part, $id_user){

		$conn = get_connection();
		$query = "UPDATE part SET assigned='Y', modify_date='".date("Y-m-d")."', id_user='$id_user' WHERE id_part='$id_part'";
		/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}	

//PART FOR PRODUCT
function get_part_for_prod_data(){

		$conn = get_connection();
		$query = "SELECT pp.id_part, pa.nm_part, date_format(pp.modify_date, '%d.%m.%Y') as modify_date, u.nm_user, pr.nm_product FROM part_for_product pp join user u ON pp.id_user = u.id_user join product pr ON pr.id_product = pp.id_product join part pa ON pa.id_part = pp.id_part ORDER BY pp.id_part ASC ";
		/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}

	function insert_part_for_product($id_product, $id_part, $id_user){

	$conn = get_connection();
	$query = "INSERT INTO part_for_product (id_product, id_part, modify_date, id_user) VALUES ('$id_product', '$id_part', '".date("Y-m-d")."', '$id_user')";
	/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}

function get_part_for_product_by_id($id_assign){

	$conn = get_connection();
	$query = "SELECT * FROM part p join user u ON p.id_user = u.id_user WHERE p.id_part='$id_part' ORDER BY p.id_part ASC";
	/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
}


//DOCUMENT
	function get_all_doc_data(){

		$conn = get_connection();
		$query = "SELECT *, date_format(d.modify_date, '%d.%m.%Y') as modify_date FROM doc_part d join user u ON d.id_user = u.id_user ORDER BY d.id_doc_part ASC";
		/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}

	function get_doc_type_data($doc_type, $assign_status){

		$conn = get_connection();
		$query = "SELECT * FROM doc_part d join user u ON d.id_user = u.id_user WHERE doc_type='$doc_type' AND assigned='$assign_status' ORDER BY d.id_doc_part ASC";
		/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}

	function get_doc_type_data_all($doc_type){

		$conn = get_connection();
		$query = "SELECT * FROM doc_part d join user u ON d.id_user = u.id_user WHERE doc_type='$doc_type'  ORDER BY d.id_doc_part ASC";
		/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}

	function insert_doc_data($id_doc_part, $nm_doc_part, $doc_type, $doc_required, $id_user){

		$conn = get_connection();
		$query = "INSERT INTO doc_part (id_doc_part, nm_doc_part, doc_type, doc_required, modify_date, id_user) VALUES ('$id_doc_part', '$nm_doc_part', '$doc_type', '$doc_required', '".date("Y-m-d")."', '$id_user')";
		/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}

	function get_unassigned_doc_data(){

		$conn = get_connection();
		$query = "SELECT * FROM doc_part WHERE status='A' AND assigned='N'";
		/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}

	function get_all_assigned_doc_data(){

		$conn = get_connection();
		$query = "SELECT * FROM doc_part WHERE status='A' AND assigned='Y' ORDER BY doc_type";
		/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}

	function get_doc_data_by_id($id_doc_part){

	$conn = get_connection();
	$query = "SELECT * FROM doc_part a join user u ON a.id_user = u.id_user WHERE a.id_doc_part='$id_doc_part' ORDER BY a.id_doc_part ASC";
	/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}


//CHECK DOC
	function get_all_check_doc_data(){

		$conn = get_connection();
		$query = "SELECT a.id_doc_part, b.nm_doc_part, a.check_params,  date_format(a.modify_date, '%d.%m.%Y') as modify_date, c.nm_user, a.id_check FROM doc_check_list a
					JOIN doc_part b ON a.id_doc_part = b.id_doc_part
					JOIN user c ON a.id_user = c.id_user
					ORDER BY a.id_doc_part";
		/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}


    function get_all_check_doc_data_by_id($id_doc_part){

        $conn = get_connection();
        $query = "SELECT a.id_check, a.id_doc_part, b.nm_doc_part, a.check_params,  date_format(a.modify_date, '%d.%m.%Y') as modify_date, c.nm_user, a.id_check FROM doc_check_list a
					LEFT JOIN doc_part b ON a.id_doc_part = b.id_doc_part
					LEFT JOIN user c ON a.id_user = c.id_user 
					WHERE a.id_doc_part = '$id_doc_part'
					ORDER BY a.id_doc_part";
        /* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
    return $result;
    }

function get_all_check_doc_data_by_id2($id_doc_part){

    $conn = get_connection();
    $query = "SELECT a.id_doc_part, a.nm_doc_part, b.check_params, date_format(a.modify_date, '%d.%m.%Y') as modify_date, c.nm_user, b.id_check FROM doc_part a 
left JOIN doc_check_list b ON a.id_doc_part = b.id_doc_part 
left JOIN user c ON a.id_user = c.id_user 
WHERE a.id_doc_part = '$id_doc_part' 
ORDER BY a.id_doc_part";
    /* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
    return $result;
}


//DOC_CHECK_LIST
	function insert_doc_check_list($id_doc_part, $check_params, $id_user){

		$conn = get_connection();
		$query = "INSERT INTO doc_check_list (id_doc_part, check_params, modify_date, id_user) VALUES ('$id_doc_part', '$check_params', '".date("Y-m-d")."', '$id_user')";
		/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}

	function get_list_check_data_by_id($id_check){

		$conn = get_connection();
		$query = "SELECT a.*, b.nm_doc_part FROM doc_check_list a left join doc_part b on a.id_doc_part = b.id_doc_part where id_check = '$id_check' ";
		/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}

	function update_doc_checklist_assign($id_doc_part, $id_user){

		$conn = get_connection();
		$query = "UPDATE doc_part SET assigned='Y', modify_date='".date("Y-m-d")."', id_user='$id_user' WHERE id_doc_part='$id_doc_part'";
		/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}	

//DOCUMENT FOR PART
function get_doc_for_part_data(){

		$conn = get_connection();
		$query = "SELECT a.id_part, pr.nm_part, a.id_doc_part, doc.nm_doc_part, date_format(a.modify_date, '%d.%m.%Y') as modify_date, a.id_user, u.nm_user FROM doc_for_part a
		join doc_part doc on doc.id_doc_part = a.id_doc_part 
		join part pr on pr.id_part = a.id_part
		join user u on u.id_user = a.id_user
		ORDER BY a.id_doc_part ASC";
		/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}

function get_all_assgined_part_data(){

		$conn = get_connection();
		$query = "SELECT DISTINCT(a.id_part), b.nm_part FROM `doc_for_part` a JOIN part b ON a.id_part = b.id_part
				ORDER BY a.id_part";
		/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}

function insert_doc_for_part($id_part, $id_doc_part, $id_user){

	$conn = get_connection();
	$query = "INSERT INTO doc_for_part (id_part, id_doc_part, modify_date, id_user) VALUES ('$id_part', '$id_doc_part', '".date("Y-m-d")."', '$id_user')";
	/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}


//VENDOR
if(!function_exists('get_all_vendor_data')) {
	function get_all_vendor_data(){

			$conn = get_connection();
			$query = "SELECT * FROM vendor a ORDER BY a.id_vendor ASC";
			/* $result = mysql_query($query) or die(mysqli_error($conn));
			mysql_close($conn); */
			$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
			mysqli_close($conn);
		return $result;
		}
}

function get_all_active_vendor_data(){

		$conn = get_connection();
		$query = "SELECT * FROM vendor WHERE status_vendor = 'A' ORDER BY id_vendor ASC";
		/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}

//ALL JOINED DATA
function get_all_join_data($id_project, $doc_type){

		$conn = get_connection();
		$query = "SELECT a.id_project, b.nm_project, a.id_product, c.nm_product, d.id_part, e.nm_part, f.id_doc_part, g.nm_doc_part, h.check_params,  g.doc_type from product_for_project a
			join project b on a.id_project = b.id_project
			join product c on c.id_product = a.id_product

			join part_for_product d on d.id_product = a.id_product
			join part e on e.id_part = d.id_part

			left join doc_for_part f on f.id_part = d.id_part
			left join doc_part g on g.id_doc_part = f.id_doc_part

			left join doc_check_list h on f.id_doc_part = h.id_doc_part
			WHERE a.id_project = '$id_project' AND g.doc_type = '$doc_type'
			ORDER BY d.id_part ASC";

		/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}

function get_all_join_spesific_data($id_project, $id_product, $id_part, $id_doc_part){

		$conn = get_connection();
		$query = "SELECT a.id_project, b.nm_project, a.id_product, c.nm_product, d.id_part, e.nm_part, f.id_doc_part, g.nm_doc_part, h.check_params,  g.doc_type from product_for_project a
			join project b on a.id_project = b.id_project
			join product c on c.id_product = a.id_product

			join part_for_product d on d.id_product = a.id_product
			join part e on e.id_part = d.id_part

			left join doc_for_part f on f.id_part = d.id_part
			left join doc_part g on g.id_doc_part = f.id_doc_part

			left join doc_check_list h on f.id_doc_part = h.id_doc_part
			WHERE a.id_project = '$id_project' AND a.id_product ='$id_product'
			AND d.id_part = '$id_part' AND f.id_doc_part = '$id_doc_part'
			ORDER BY d.id_part ASC";

		/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}


function get_group_all_join_prod_part_data($id_project, $doc_type){

		$conn = get_connection();
		$query = "SELECT a.id_project, b.nm_project, a.id_product, c.nm_product, d.id_part, e.nm_part, f.id_doc_part, g.nm_doc_part, h.check_params,  g.doc_type from product_for_project a
			join project b on a.id_project = b.id_project
			join product c on c.id_product = a.id_product

			join part_for_product d on d.id_product = a.id_product
			join part e on e.id_part = d.id_part

			left join doc_for_part f on f.id_part = d.id_part
			left join doc_part g on g.id_doc_part = f.id_doc_part

			left join doc_check_list h on f.id_doc_part = h.id_doc_part
			WHERE a.id_project = '$id_project' AND doc_type = '$doc_type'
            GROUP BY a.id_product, d.id_part
			ORDER BY a.id_product ASC";

		/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}

	function get_group_all_join_prod_part_data2($id_project, $doc_type){

		$conn = get_connection();
		$query = "SELECT a.id_project, b.nm_project, a.id_product, c.nm_product, d.id_part, e.nm_part, f.id_doc_part, g.nm_doc_part, h.check_params,  g.doc_type from product_for_project a
			join project b on a.id_project = b.id_project
			join product c on c.id_product = a.id_product

			join part_for_product d on d.id_product = a.id_product
			join part e on e.id_part = d.id_part

			left join doc_for_part f on f.id_part = d.id_part
			left join doc_part g on g.id_doc_part = f.id_doc_part

			left join doc_check_list h on f.id_doc_part = h.id_doc_part
			WHERE a.id_project = '$id_project' AND doc_type = '$doc_type'
            GROUP BY a.id_product
			ORDER BY a.id_product ASC";

		/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}

	function get_group_all_join_prod_part_data3($id_project, $id_product, $doc_type){

		$conn = get_connection();
		$query = "SELECT a.id_project, b.nm_project, a.id_product, c.nm_product, d.id_part, e.nm_part, f.id_doc_part, g.nm_doc_part, h.check_params,  g.doc_type from product_for_project a
			join project b on a.id_project = b.id_project
			join product c on c.id_product = a.id_product

			join part_for_product d on d.id_product = a.id_product
			join part e on e.id_part = d.id_part

			left join doc_for_part f on f.id_part = d.id_part
			left join doc_part g on g.id_doc_part = f.id_doc_part

			left join doc_check_list h on f.id_doc_part = h.id_doc_part
			WHERE a.id_project = '$id_project' AND c.id_product = '$id_product' AND doc_type = '$doc_type'
            GROUP BY id_product, id_part
			ORDER BY a.id_product ASC";

		/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}


	function get_group_all_join_prod_part_data4($id_project, $doc_type){

		$conn = get_connection();
		if ($doc_type == ""){
			$doc ="";
		} else{
			$doc = "AND doc_type = '$doc_type'";
		}

		$query = "SELECT a.id_project, b.nm_project, a.id_product, c.nm_product, d.id_part, e.nm_part, f.id_doc_part, g.nm_doc_part, h.check_params,  g.doc_type from product_for_project a
			join project b on a.id_project = b.id_project
			join product c on c.id_product = a.id_product

			join part_for_product d on d.id_product = a.id_product
			join part e on e.id_part = d.id_part

			left join doc_for_part f on f.id_part = d.id_part
			left join doc_part g on g.id_doc_part = f.id_doc_part

			left join doc_check_list h on f.id_doc_part = h.id_doc_part
			WHERE a.id_project = '$id_project' $doc
            GROUP BY a.id_product, d.id_part, f.id_doc_part, h.check_params
			ORDER BY a.id_product ASC";

		/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}

	function get_group_all_join_proj_prod_part_doc_data($id_project, $doc_type){

		$conn = get_connection();
		$query = "SELECT a.id_project, b.nm_project, a.id_product, c.nm_product, d.id_part, e.nm_part, f.id_doc_part, g.nm_doc_part, h.check_params,  g.doc_type, g.doc_required from product_for_project a
			join project b on a.id_project = b.id_project
			join product c on c.id_product = a.id_product

			join part_for_product d on d.id_product = a.id_product
			join part e on e.id_part = d.id_part

			left join doc_for_part f on f.id_part = d.id_part
			left join doc_part g on g.id_doc_part = f.id_doc_part

			left join doc_check_list h on f.id_doc_part = h.id_doc_part
			WHERE a.id_project = '$id_project' AND doc_type = '$doc_type'
            GROUP BY a.id_product, d.id_part, f.id_doc_part
			ORDER BY a.id_product ASC";

		/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}

	function get_group_all_join_proj_prod_part_data($id_project, $id_product, $id_part, $doc_type){

		$conn = get_connection();
		$query = "SELECT a.id_project, b.nm_project, a.id_product, c.nm_product, d.id_part, e.nm_part, f.id_doc_part, g.nm_doc_part, h.check_params,  g.doc_type, g.doc_required, i.version_n from product_for_project a
			join project b on a.id_project = b.id_project
			join product c on c.id_product = a.id_product

			join part_for_product d on d.id_product = a.id_product
			join part e on e.id_part = d.id_part

			left join doc_for_part f on f.id_part = d.id_part
			left join doc_part g on g.id_doc_part = f.id_doc_part

			left join doc_check_list h on f.id_doc_part = h.id_doc_part
			left join proj_doc_upload i on i.id_doc_part = f.id_doc_part
			WHERE a.id_project = '$id_project' AND a.id_product= '$id_product' 
            AND d.id_part = '$id_part' AND doc_type = '$doc_type'
            GROUP BY f.id_doc_part
			ORDER BY a.id_product ASC";

		/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}

	/*
	function get_group_all_join_proj_prod_part_data2($id_project, $id_product, $id_part, $id_doc_part, $doc_type){

		$conn = get_connection();
		$query = "SELECT a.id_project, b.nm_project, a.id_product, c.nm_product, d.id_part, e.nm_part, f.id_doc_part, g.nm_doc_part, h.check_params,  g.doc_type, g.doc_required, i.version_n from product_for_project a
			join project b on a.id_project = b.id_project
			join product c on c.id_product = a.id_product

			join part_for_product d on d.id_product = a.id_product
			join part e on e.id_part = d.id_part

			left join doc_for_part f on f.id_part = d.id_part
			left join doc_part g on g.id_doc_part = f.id_doc_part

			left join doc_check_list h on f.id_doc_part = h.id_doc_part
			join proj_doc_upload i on i.id_doc_part = f.id_doc_part
			WHERE a.id_project = '$id_project' AND a.id_product= '$id_product' 
            AND d.id_part = '$id_part' AND f.id_doc_part = '$id_doc_part'
            AND doc_type = '$doc_type'
            GROUP BY f.id_doc_part
			ORDER BY a.id_product ASC";

		$result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn);
	return $result;
	}
	*/

function get_group_all_join_proj_prod_part_data2($id_project, $id_product, $id_part, $id_doc_part, $doc_type){

    $conn = get_connection();
    $query = "SELECT a.id_project, b.nm_project, a.id_product, c.nm_product, d.id_part, e.nm_part, f.id_doc_part, g.nm_doc_part, h.check_params,  g.doc_type, g.doc_required, i.version_n from product_for_project a
			join project b on a.id_project = b.id_project
			join product c on c.id_product = a.id_product

			join part_for_product d on d.id_product = a.id_product
			join part e on e.id_part = d.id_part

			left join doc_for_part f on f.id_part = d.id_part
			left join doc_part g on g.id_doc_part = f.id_doc_part

			left join doc_check_list h on f.id_doc_part = h.id_doc_part
			join proj_doc_upload i on i.id_doc_part = f.id_doc_part
			WHERE i.id_project = '$id_project' AND i.id_product= '$id_product' 
            AND i.id_part = '$id_part' AND i.id_doc_part = '$id_doc_part'
            AND doc_type = '$doc_type'
            GROUP BY f.id_doc_part
			ORDER BY a.id_product ASC";

    /* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
    return $result;
}

	function get_group_all_join_proj_prod_part_data3($id_project, $id_product, $id_part, $doc_type, $id_vendor){

		$conn = get_connection();
		$query = "SELECT a.id_project, b.nm_project, a.id_product, c.nm_product, d.id_part, e.nm_part, f.id_doc_part, g.nm_doc_part, h.check_params, g.doc_type, g.doc_required, i.version_n, i.id_vendor, j.nm_vendor from product_for_project a
			join project b on a.id_project = b.id_project 
			join product c on c.id_product = a.id_product 
			join part_for_product d on d.id_product = a.id_product 
			join part e on e.id_part = d.id_part 
			left join doc_for_part f on f.id_part = d.id_part 
			left join doc_part g on g.id_doc_part = f.id_doc_part 
			left join doc_check_list h on f.id_doc_part = h.id_doc_part 
			left join proj_vendor_upload i on i.id_doc_part = f.id_doc_part 
			left join vendor j on i.id_vendor = j.id_vendor
			WHERE a.id_project = '$id_project' AND a.id_product= '$id_product' AND d.id_part = '$id_part' AND i.id_vendor= '$id_vendor' AND doc_type = '$doc_type' 
			GROUP BY f.id_doc_part 
			ORDER BY a.id_product ASC";

		/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}

	function get_group_all_join_proj_prod_part_data_required($id_project, $id_product, $id_part, $doc_type, $required, $mandatory){

		$conn = get_connection();
		$query = "SELECT a.id_project, b.nm_project, a.id_product, c.nm_product, d.id_part, e.nm_part, f.id_doc_part, g.nm_doc_part, h.check_params,  g.doc_type, g.doc_required from product_for_project a
			join project b on a.id_project = b.id_project
			join product c on c.id_product = a.id_product

			join part_for_product d on d.id_product = a.id_product
			join part e on e.id_part = d.id_part

			left join doc_for_part f on f.id_part = d.id_part
			left join doc_part g on g.id_doc_part = f.id_doc_part

			left join doc_check_list h on f.id_doc_part = h.id_doc_part
			WHERE a.id_project = '$id_project' AND a.id_product= '$id_product' 
            AND d.id_part = '$id_part' AND doc_type = '$doc_type' AND doc_required = '$required' AND doc_required = '$mandatory'
            GROUP BY f.id_doc_part
			ORDER BY a.id_product ASC";

		/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}

	function insert_proj_doc_assign($id_project, $id_product, $id_part, $id_doc_part, $check_params){

		$conn = get_connection(); 
		$query = "INSERT INTO proj_doc_assign (id_project, id_product, id_part, id_doc_part, check_params) VALUES ('$id_project', '$id_product', '$id_part', '$id_doc_part', '$check_params')";
		/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}

	function insert_proj_doc_upload($id_project, $id_product, $id_part, $id_doc_part, $doc_required, $file_nm, $upload_n, $version_n, $uploader_id, $upload_path){
		
		$conn = get_connection(); 
		$query = "INSERT INTO proj_doc_upload (id_project, id_product, id_part, id_doc_part, doc_required, file_nm, upload_n, version_n, upload_date, uploader_id, upload_path) VALUES ('$id_project', '$id_product', '$id_part', '$id_doc_part', '$doc_required','$file_nm','$upload_n', '$version_n', '".date("Y-m-d H:i:s")."', '$uploader_id', '$upload_path')";
		/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}

	function get_proj_doc_upload_by_proj_doc($id_project, $id_doc_part){

		$conn = get_connection(); 
		$query = "SELECT * FROM proj_doc_upload WHERE id_project='$id_project' AND id_doc_part='$id_doc_part'";
		/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}

	//DOC ASSIGNED
	function get_proj_assign_data($id_project){

		$conn = get_connection(); 
		$query = "SELECT * FROM proj_doc_assign WHERE id_project='$id_project'";
		/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}

	function get_proj_assign_data_uploaded(){

		$conn = get_connection(); 
		$query = "SELECT DISTINCT(a.id_project) as id_project, b.nm_project FROM proj_doc_assign a left join project b on a.id_project = b.id_project ";
		/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}

	function get_proj_assign_data_all(){

		$conn = get_connection(); 
		$query = "SELECT a.*, b.doc_required, b.doc_type FROM proj_doc_assign a join doc_part b on a.id_doc_part = b.id_doc_part where b.doc_type = 'P' AND b.doc_required = 'Y' ";
		/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}


	function get_proj_assign_data_all2($id_project){

		$conn = get_connection(); 
		$query = "SELECT a.*, b.doc_required, b.doc_type FROM proj_doc_assign a join doc_part b on a.id_doc_part = b.id_doc_part where a.id_project='$id_project' AND b.doc_type = 'P' AND b.doc_required = 'Y' ";
		/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}

	//ASSIGNED
	function get_all_proj_doc_upload_data($id_project){

		$conn = get_connection(); 
		$query = "SELECT * FROM proj_doc_upload WHERE id_project = '$id_project'";
		/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}

	function update_proj_doc_upload($id_project, $id_product, $id_part, $id_doc_part, $file_nm, $upload_n, $version_n, $uploader_id, $upload_path){

		$conn = get_connection(); 
		$query = "UPDATE proj_doc_upload SET file_nm = '$file_nm', upload_n = '$upload_n', version_n = '$version_n', uploader_id = '$uploader_id', upload_path = '$upload_path', upload_date = '".date("Y-m-d H:i:s")."' WHERE id_project = '$id_project' AND id_product = '$id_product' AND id_part = '$id_part' AND id_doc_part = '$id_doc_part' ";
		/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}

	function get_proj_doc_upload_data(){

		$conn = get_connection(); 
		$query = "SELECT DISTINCT a.id_project, b.nm_project FROM proj_doc_upload a
				JOIN project b ON a.id_project=b.id_project";
		/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}

	function get_proj_doc_has_uploaded_data($id_project){

		$conn = get_connection(); 
		$query = "SELECT a.id_project, b.proj_num, b.c, a.id_product, c.nm_product, a.id_part, d.nm_part, a.id_doc_part, e.nm_doc_part, e.doc_required, a.file_nm, a.upload_path, a.upload_n, a.version_n, a.file_nm, date_format(a.upload_date, '%d.%m.%Y') as upload_date, a.uploader_id, f.nm_user, e.doc_required from proj_doc_upload a
				join project b on b.id_project = a.id_project
				join product c on c.id_product = a.id_product
				join part d on d.id_part = a.id_part
				join doc_part e on e.id_doc_part = a.id_doc_part
				left join user f on f.id_user = a.uploader_id
				where a.id_project ='$id_project'
				order by a.id_product";
		/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);

	return $result;
	}

	function get_checklist_doc_has_uploaded_data($id_project, $id_product, $id_part, $id_doc_part){

		$conn = get_connection(); 
		$query = "SELECT * from proj_doc_assign where id_project= '$id_project' AND id_product ='$id_product' AND id_part='$id_part' AND id_doc_part = '$id_doc_part' order by check_params asc ";
		/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);

	return $result;
	}

	function get_checklist_doc_has_uploaded_data2($id_project, $id_product, $id_part, $id_doc_part){

		$conn = get_connection(); 
		$query = "SELECT * from proj_vendor_assign where id_project= '$id_project' AND id_product ='$id_product' AND id_part='$id_part' AND id_doc_part = '$id_doc_part' order by check_params asc ";
		/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);

	return $result;
	}

	//PROJECT DOCUMENT UPLOAD
	/*
	function get_upload_sequence($id_project, $id_product, $id_part, $id_doc_part){

		$conn = get_connection(); 
		$query = "SELECT upload_n FROM proj_doc_upload
			WHERE id_project= '$id_project' AND id_product ='$id_product' AND id_part='$id_part' AND id_doc_part='$id_doc_part'";
		$result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn);

	return $result;
	}
	*/

	function get_upload_sequence($id_project, $id_product, $id_part){

		$conn = get_connection(); 
		$query = "SELECT MAX(upload_n) as upload_n FROM proj_doc_upload WHERE id_project= '$id_project' AND id_product = '$id_product' AND id_part = '$id_part' ";
		/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);

	return $result;
	}

	function get_doc_ver($id_project, $id_product, $id_part, $id_doc_part){

		$conn = get_connection(); 
		$query = "SELECT version_n FROM proj_doc_upload
			WHERE id_project= '$id_project' AND id_product ='$id_product' AND id_part='$id_part' AND id_doc_part='$id_doc_part'";
		/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);

	return $result;
	}

	function get_permit($id_project, $id_product, $id_part){

		$conn = get_connection(); 
		$query = "SELECT MAX(permit_n) as permit_n FROM proj_doc_upload WHERE id_project= '$id_project' AND id_product = '$id_product' AND id_part = '$id_part' ";
		/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);

	return $result;
	}

	function get_proj_doc_assign_data($id_project, $id_product, $id_part, $id_doc_part){

		$conn = get_connection(); 
		$query = "SELECT * FROM proj_doc_assign
			WHERE id_project= '$id_project' AND id_product ='$id_product' AND id_part='$id_part' AND id_doc_part='$id_doc_part'";
		/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);

	return $result;
	}

	function get_proj_doc_assign_data_status($id_project, $id_product, $id_part, $id_doc_part){

		$conn = get_connection(); 
		$query = "SELECT sum(check_status) as check_status FROM proj_doc_assign
			WHERE id_project= '$id_project' AND id_product ='$id_product' AND id_part='$id_part' AND id_doc_part='$id_doc_part'";
		/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);

	return $result;
	}

	function get_param_doc_has_checked_data($id_project, $id_product, $id_part, $id_doc_part, $check_params){

		$conn = get_connection(); 
		$query = "SELECT *, b.nm_doc_part, c.nm_user from proj_doc_assign a join doc_part b on a.id_doc_part = b.id_doc_part join user c on a.checker_id = c.id_user
				where a.id_project = '$id_project' AND a.id_product = '$id_product' AND a.id_part = '$id_part' AND a.id_doc_part = '$id_doc_part' AND a.check_params = '$check_params'";
		/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);

	return $result;
	}

	function get_param_doc_has_checked_data2($id_project, $id_product, $id_part, $id_doc_part, $check_params){

		$conn = get_connection(); 
		$query = "SELECT *, b.nm_doc_part, c.nm_user from proj_vendor_assign a join doc_part b on a.id_doc_part = b.id_doc_part join user c on a.checker_id = c.id_user
				where a.id_project = '$id_project' AND a.id_product = '$id_product' AND a.id_part = '$id_part' AND a.id_doc_part = '$id_doc_part' AND a.check_params = '$check_params'";
		/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);

	return $result;
	}

	function update_doc_chek_params($id_project, $id_product, $id_part, $id_doc_part, $check_params, $check_status, $checker_id, $comment){

		$conn 	= get_connection(); 
		$query 	= "UPDATE proj_doc_assign a SET a.check_status = '$check_status', a.checker_id = '$checker_id', a.check_date = '".date("Y-m-d H:i:s")."', a.comment='$comment' WHERE a.id_project = '$id_project' AND a.id_product = '$id_product' AND a.id_part = '$id_part' AND a.id_doc_part = '$id_doc_part' AND a.check_params = '$check_params'";
		/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);

	return $result;
	}

	function insert_proj_vendor_assign($id_project, $id_product, $id_part, $id_doc_part, $check_params, $id_vendor){

		$conn = get_connection(); 
		$query = "INSERT INTO proj_vendor_assign (id_project, id_product, id_part, id_doc_part, check_params, id_vendor) VALUES ('$id_project', '$id_product', '$id_part', '$id_doc_part', '$check_params', '$id_vendor')";
		/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}

	function insert_proj_vendor_upload($id_project, $id_product, $id_part, $id_doc_part, $doc_required, $file_nm, $upload_n, $version_n, $uploader_id, $upload_path, $id_vendor){
		
		$conn = get_connection(); 
		$query = "INSERT INTO proj_vendor_upload (id_project, id_product, id_part, id_doc_part, doc_required, file_nm, upload_n, version_n, upload_date, uploader_id, upload_path, id_vendor) VALUES ('$id_project', '$id_product', '$id_part', '$id_doc_part', '$doc_required','$file_nm','$upload_n', '$version_n', '".date("Y-m-d H:i:s")."', '$uploader_id', '$upload_path', '$id_vendor')";
		/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}

	function get_vendor_has_assigned($id_project){

		$conn = get_connection(); 
		$query = "SELECT * FROM proj_vendor_assign WHERE id_project = '$id_project' group by id_vendor";
		/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);

	return $result;
	}

	function get_vendor_has_assigned_detail($id_project, $id_vendor, $doc_type){

		$conn = get_connection(); 
		$query = "SELECT a.id_project, d.nm_project, a.id_product, e.nm_product, a.id_part, f.nm_part, a.id_doc_part, b.nm_doc_part, b.doc_required, b.doc_type, c.file_nm, c.upload_path, c.upload_n, c.version_n, date_format(c.upload_date, '%d.%m.%Y') as upload_date, c.uploader_id, g.nm_user  FROM proj_vendor_assign a 
				join doc_part b on a.id_doc_part = b.id_doc_part 
				join proj_doc_upload c on a.id_project = c.id_project and a.id_product = c.id_product and a.id_part = c.id_part and a.id_doc_part = c.id_doc_part 
				join project d on a.id_project = d.id_project
				join product e on a.id_product = e.id_product
				join part f on a.id_part = f.id_part
				left join user g on g.id_user = c.uploader_id

				WHERE a.id_project='$id_project' AND a.id_vendor = '$id_vendor' AND b.doc_type = '$doc_type'
				GROUP By a.id_part, a.id_doc_part

				";
		/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);

	return $result;
	}

	function get_vendor_has_assigned_detail2($id_project, $id_vendor, $doc_type){

		$conn = get_connection(); 
		$query = "SELECT a.id_project, d.nm_project, a.id_product, e.nm_product, a.id_part, f.nm_part, a.id_doc_part, b.nm_doc_part, b.doc_required, b.doc_type, c.file_nm, c.upload_path, c.upload_n, c.version_n, date_format(c.upload_date, '%d.%m.%Y') as upload_date, c.uploader_id, g.nm_user  FROM proj_vendor_assign a 
				join doc_part b on a.id_doc_part = b.id_doc_part 
				join proj_doc_upload c on a.id_project = c.id_project and a.id_product = c.id_product and a.id_part = c.id_part and a.id_doc_part = c.id_doc_part 
				join project d on a.id_project = d.id_project
				join product e on a.id_product = e.id_product
				join part f on a.id_part = f.id_part
				left join user g on g.id_user = c.uploader_id

				WHERE a.id_project='$id_project' AND a.id_vendor = '$id_vendor' AND b.doc_type = '$doc_type'
				GROUP BY a.id_project, a.id_product, a.id_part, a.id_doc_part

				";
		/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);

	return $result;
	}


	function get_all_project_vendor_assign($id_vendor){

		$conn = get_connection(); 
		$query = "SELECT a.*, b.nm_project FROM `proj_vendor_assign` a
		join project b on a.id_project = b.id_project
		WHERE id_vendor = '$id_vendor' group by id_project";
		/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);

	return $result;
	}
	
	function get_vendor_user($id_user)
	{
		$result = DB::table('vendor')->where('id_vendor',$id_user)->first();
		return $result;
		
		//MYSQL ==BACKUP==
		$conn = get_connection(); 
		$query = "SELECT * FROM vendor v JOIN user u ON v.id_vendor = u.foreign_id WHERE u.id_user = '$id_user'  ";
		/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);

		return $result;
	}

	function get_vendor_prod_part_data($id_project, $doc_type, $id_vendor){

		$conn = get_connection();
		$query = "SELECT a.id_project, b.nm_project, a.id_product, c.prod_num, c.nm_product, a.id_part, d.part_num ,d.nm_part, a.id_doc_part, e.nm_doc_part, a.id_vendor, e.doc_type FROM `proj_vendor_assign` a 
			join project b on a.id_project = b.id_project 
			join product c on a.id_product = c.id_product 
			join part d on a.id_part = d.id_part 
			join doc_part e on a.id_doc_part = e.id_doc_part 
			WHERE a.id_project = '$id_project' AND a.id_vendor = '$id_vendor' AND e.doc_type = 'V' 
			group by a.id_project, a.id_product, a.id_part
			order by a.id_project";

		/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}

	/*
	function get_vendor_prod_part_doc_data($id_project, $id_product, $id_part, $doc_type, $id_vendor){

		$conn = get_connection();
		$query = "SELECT a.id_project, b.nm_project, a.id_product, c.nm_product, a.id_part, d.nm_part, a.id_doc_part, e.nm_doc_part, a.id_vendor, e.doc_type, a.check_status_a, a.check_status_b, f.upload_path FROM `proj_vendor_assign` a 
			join project b on a.id_project = b.id_project 
			join product c on a.id_product = c.id_product 
			join part d on a.id_part = d.id_part 
			join doc_part e on a.id_doc_part = e.id_doc_part
            join proj_vendor_upload f on a.id_project = f.id_project and a.id_product = f.id_product and a.id_part = f.id_part and a.id_doc_part = f.id_doc_part
			WHERE a.id_project = '$id_project' AND a.id_product = '$id_product' 
			AND a.id_part = '$id_part' AND a.id_vendor = '$id_vendor' AND e.doc_type = '$doc_type' 
			group by a.id_project, a.id_product, a.id_part, a.id_doc_part
			order by a.id_project";

		$result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn);
	return $result;
	}

	*/

	function get_vendor_prod_part_doc_data($id_project, $id_product, $id_part, $doc_type, $id_vendor){

		$conn = get_connection();
		$query = "SELECT a.id_project, b.nm_project, a.id_product, c.nm_product, a.id_part, d.nm_part, a.id_doc_part, e.nm_doc_part, f.id_vendor, e.doc_type, a.check_status_a, a.check_status_b, f.upload_path, f.file_nm, f.version_n, f.upload_n FROM `proj_vendor_assign` a 
			join project b on a.id_project = b.id_project 
			join product c on a.id_product = c.id_product 
			join part d on a.id_part = d.id_part 
			join doc_part e on a.id_doc_part = e.id_doc_part
            join proj_vendor_upload f on a.id_project = f.id_project and a.id_product = f.id_product and a.id_part = f.id_part and a.id_doc_part = f.id_doc_part
			WHERE a.id_project = '$id_project' AND a.id_product = '$id_product' 
			AND a.id_part = '$id_part' AND f.id_vendor = '$id_vendor' AND e.doc_type = '$doc_type' 
			group by a.id_project, a.id_product, a.id_part, a.id_doc_part
			order by a.id_project";

		/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}

	function get_proj_vendor_assign_data(){

		$conn = get_connection(); 
		$query = "SELECT a.id_project, b.nm_project, a.id_product, c.nm_product, a.id_part, d.nm_part, a.id_vendor, e.nm_vendor
				FROM `proj_vendor_assign` a
				join project b on a.id_project = b.id_project
				join product c on a.id_product = c.id_product
				join part d on a.id_part = d.id_part
				join vendor e on a.id_vendor = e.id_vendor
				group by a.id_project, a.id_product, a.id_part, a.id_vendor";
		/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);

	return $result;
	}

	function get_proj_vendor_assign($id_project){

		$conn = get_connection(); 
		$query = "SELECT a.id_project, b.nm_project, a.id_product, c.nm_product, a.id_part, d.nm_part, a.id_vendor, e.nm_vendor
				FROM `proj_vendor_assign` a
				join project b on a.id_project = b.id_project
				join product c on a.id_product = c.id_product
				join part d on a.id_part = d.id_part
				join vendor e on a.id_vendor = e.id_vendor
				WHERE a.id_project = '$id_project'
				group by a.id_project, a.id_vendor";
		/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);

	return $result;
	}


	function get_proj_assign_data_all3($id_project, $id_product, $id_part, $doc_type){

		$conn = get_connection(); 
		$query = "SELECT a.id_project, b.nm_project, a.id_product, c.nm_product, d.id_part, e.nm_part, f.id_doc_part, g.nm_doc_part, h.check_params, g.doc_type, g.doc_required, j.upload_path, i.version_n, i.upload_n, i.permit_n, j.file_nm
			from product_for_project a 
			join project b on a.id_project = b.id_project 
			join product c on c.id_product = a.id_product 
			join part_for_product d on d.id_product = a.id_product join part e on e.id_part = d.id_part left join doc_for_part f on f.id_part = d.id_part 
			left join doc_part g on g.id_doc_part = f.id_doc_part 
			left join doc_check_list h on f.id_doc_part = h.id_doc_part 
			left join proj_doc_upload i on a.id_project = i.id_project and a.id_product = i.id_product and d.id_part = i.id_part and i.id_doc_part = f.id_doc_part 
			left join proj_doc_upload j on a.id_project = j.id_project and a.id_product = j.id_product and d.id_part = j.id_part and f.id_doc_part = j.id_doc_part 
			WHERE a.id_project = '$id_project' AND a.id_product= '$id_product' AND d.id_part = '$id_part' AND doc_type = '$doc_type' 
			GROUP BY f.id_doc_part 
			ORDER BY f.id_doc_part ASC ";
		/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}

	function get_upload_sequence2($id_project, $id_product, $id_part, $id_doc_part){

		$conn = get_connection(); 
		$query = "SELECT upload_n FROM proj_vendor_upload
			WHERE id_project= '$id_project' AND id_product ='$id_product' AND id_part='$id_part' AND id_doc_part='$id_doc_part'";
		/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);

	return $result;
	}

	function proj_prod_part_vendor_assigned($id_project, $id_product, $id_part){

		$conn = get_connection(); 
		$query = "SELECT a.*, b.* FROM `proj_vendor_assign` a
				left join vendor b on a.id_vendor = b.id_vendor 
				where id_project ='$id_project' and id_product = '$id_product' and id_part = '$id_part'
				group by id_project, id_product, id_part, a.id_vendor ";
		/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);

	return $result;
	}

	function update_vendor_doc_upload($id_project, $id_product, $id_part, $id_doc_part, $file_nm, $upload_n, $version_n, $uploader_id, $upload_path, $id_vendor){

		$conn = get_connection(); 
		$query = "UPDATE proj_vendor_upload SET file_nm = '$file_nm', upload_n = '$upload_n', version_n = '$version_n', uploader_id = '$uploader_id', upload_path = '$upload_path', upload_date = '".date("Y-m-d H:i:s")."' WHERE id_project = '$id_project' AND id_product = '$id_product' AND id_part = '$id_part' AND id_doc_part = '$id_doc_part' AND id_vendor = '$id_vendor' ";
		/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}

	function get_upload_vendor_data($id_project, $id_product, $id_part, $id_vendor, $doc_type){

		$conn = get_connection(); 
		$query = "SELECT a.*, b.nm_doc_part, b.doc_type FROM `proj_vendor_upload` a
				join doc_part b on a.id_doc_part = b.id_doc_part
				where a.id_project = '$id_project' and a.id_product = '$id_product'  and a.id_part = '$id_part' and a.id_vendor = '$id_vendor' and b.doc_type = '$doc_type' ";
		/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}


	function get_proj_doc_assign_data_vendor($id_project, $id_product, $id_part, $id_doc_part, $id_vendor){

		$conn = get_connection(); 
		$query = "SELECT * FROM proj_vendor_assign
			WHERE id_project= '$id_project' AND id_product ='$id_product' AND id_part='$id_part' AND id_doc_part='$id_doc_part' AND id_vendor = '$id_vendor' ";
		/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);

	return $result;
	}

	function get_proj_doc_assign_data_status_vendor($id_project, $id_product, $id_part, $id_doc_part, $id_vendor){

		$conn = get_connection(); 
		$query = "SELECT sum(check_status_a) as check_status FROM proj_vendor_assign
			WHERE id_project= '$id_project' AND id_product ='$id_product' AND id_part='$id_part' AND id_doc_part='$id_doc_part' AND id_vendor = '$id_vendor' ";
		/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);

	return $result;
	}

    function get_proj_doc_assign_data_status_vendor2($id_project, $id_product, $id_part, $id_doc_part, $id_vendor){

        $conn = get_connection();
        $query = "SELECT sum(check_status_b) as check_status_b FROM proj_vendor_assign
			WHERE id_project= '$id_project' AND id_product ='$id_product' AND id_part='$id_part' AND id_doc_part='$id_doc_part' AND id_vendor = '$id_vendor' ";
        /* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);

    return $result;
    }


	function get_proj_vendor_upload_data(){

		$conn = get_connection(); 
		$query = "SELECT DISTINCT a.id_project, b.nm_project FROM proj_vendor_upload a
				JOIN project b ON a.id_project=b.id_project";
		/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}

	function get_vendor_assign_data($id_project){

		$conn = get_connection(); 
		$query = "SELECT distinct(a.id_project), a.id_vendor, b.nm_vendor, b.allias FROM `proj_vendor_upload` a
				left join vendor b on a.id_vendor = b.id_vendor
				WHERE a.id_project = '$id_project'";
		/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}

if(!function_exists('get_vendor_data_by_id')) {
	function get_vendor_data_by_id($id_vendor){

	$conn = get_connection();
	$query = "SELECT * FROM vendor WHERE  id_vendor = '$id_vendor' ORDER BY id_vendor ASC";
	/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}
}

	function get_vendor_doc_has_uploaded_data($id_project, $id_vendor){

		$conn = get_connection(); 
		$query = "SELECT a.id_project, b.nm_project, a.id_product, c.nm_product, a.id_part, d.nm_part, a.id_doc_part, e.nm_doc_part, e.doc_required, a.file_nm, a.upload_path, a.upload_n, a.version_n, a.file_nm, date_format(a.upload_date, '%d.%m.%Y') as upload_date, a.uploader_id, f.nm_user, e.doc_required from proj_vendor_upload a
				join project b on b.id_project = a.id_project
				join product c on c.id_product = a.id_product
				join part d on d.id_part = a.id_part
				join doc_part e on e.id_doc_part = a.id_doc_part
				left join user f on f.id_user = a.uploader_id
				where a.id_project ='$id_project' AND a.id_vendor = '$id_vendor'
				order by a.id_product";
		/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);

	return $result;
	}
			

	function get_group_all_vendor_proj_prod_part_data($id_project, $id_product, $id_part, $id_doc_part, $doc_type, $id_vendor){

		$conn = get_connection();
		$query = "SELECT a.id_project, b.nm_project, a.id_product, c.nm_product, d.id_part, e.nm_part, f.id_doc_part, g.nm_doc_part, h.check_params,  g.doc_type, g.doc_required, i.version_n, i.id_vendor from product_for_project a
			join project b on a.id_project = b.id_project
			join product c on c.id_product = a.id_product

			join part_for_product d on d.id_product = a.id_product
			join part e on e.id_part = d.id_part

			left join doc_for_part f on f.id_part = d.id_part
			left join doc_part g on g.id_doc_part = f.id_doc_part

			left join doc_check_list h on f.id_doc_part = h.id_doc_part
			join proj_vendor_upload i on i.id_doc_part = f.id_doc_part
			WHERE i.id_project = '$id_project' AND i.id_product= '$id_product' 
            AND i.id_part = '$id_part' AND i.id_doc_part = '$id_doc_part'
            AND doc_type = '$doc_type' AND i.id_vendor = '$id_vendor'
            GROUP BY f.id_doc_part
			ORDER BY a.id_product ASC";

		/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}	

	function get_checklist_vendor_has_uploaded_data($id_project, $id_product, $id_part, $id_doc_part){

		$conn = get_connection(); 
		$query = "SELECT * from proj_vendor_assign where id_project= '$id_project' AND id_product ='$id_product' AND id_part='$id_part' AND id_doc_part = '$id_doc_part' order by check_params asc ";
		/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);

	return $result;
	}

	function get_param_vendor_has_checked_data($id_project, $id_product, $id_part, $id_doc_part, $check_params){

		$conn = get_connection(); 
		$query = "SELECT *, b.nm_doc_part, c.nm_user from proj_vendor_assign a join doc_part b on a.id_doc_part = b.id_doc_part join user c on a.checker_id_a = c.id_user
				where a.id_project = '$id_project' AND a.id_product = '$id_product' AND a.id_part = '$id_part' AND a.id_doc_part = '$id_doc_part' AND a.check_params = '$check_params'";
		/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);

	return $result;
	}

	function update_doc_chek_params_vendor($id_project, $id_product, $id_part, $id_doc_part, $check_params, $check_status, $checker_id, $comment){

		$conn 	= get_connection(); 
		$query 	= "UPDATE proj_vendor_assign a SET a.check_status_a = '$check_status', a.checker_id_a = '$checker_id', a.check_date_a = '".date("Y-m-d H:i:s")."', a.comment='$comment' WHERE a.id_project = '$id_project' AND a.id_product = '$id_product' AND a.id_part = '$id_part' AND a.id_doc_part = '$id_doc_part' AND a.check_params = '$check_params'";
		/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);

	return $result;
	}


	function get_checklist_vendor_has_uploaded_data2($id_project, $id_product, $id_part, $id_doc_part, $id_vendor){

		$conn = get_connection(); 
		$query = "SELECT * from proj_vendor_assign where id_project= '$id_project' AND id_product ='$id_product' AND id_part='$id_part' AND id_doc_part = '$id_doc_part' AND id_vendor = '$id_vendor' order by check_params asc ";
		/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);

	return $result;
	}


	function get_param_vendor_has_checked_data2($id_project, $id_product, $id_part, $id_doc_part, $check_params, $id_vendor){

		$conn = get_connection(); 
		$query = "SELECT *, b.nm_doc_part, c.nm_user from proj_vendor_assign a join doc_part b on a.id_doc_part = b.id_doc_part join user c on a.checker_id_a = c.id_user
				where a.id_project = '$id_project' AND a.id_product = '$id_product' AND a.id_part = '$id_part' AND a.id_doc_part = '$id_doc_part' AND a.check_params = '$check_params' AND id_vendor = '$id_vendor'";
		/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);

	return $result;
	}

	//if user proc
	function update_doc_check_params_vendor2($id_project, $id_product, $id_part, $id_doc_part, $check_params, $check_status, $checker_id, $comment, $id_vendor){

		$conn 	= get_connection(); 
		$query 	= "UPDATE proj_vendor_assign a SET a.check_status_a = '$check_status', a.checker_id_a = '$checker_id', a.check_date_a = '".date("Y-m-d H:i:s")."', a.comment='$comment' WHERE a.id_project = '$id_project' AND a.id_product = '$id_product' AND a.id_part = '$id_part' AND a.id_doc_part = '$id_doc_part' AND a.check_params = '$check_params' AND a.id_vendor = '$id_vendor' ";
		/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);

	return $result;
	}

	//if user qa
    function update_doc_check_params_vendor3($id_project, $id_product, $id_part, $id_doc_part, $check_params, $check_status_b, $checker_id_b, $comment_b, $id_vendor){

        $conn 	= get_connection();
        $query 	= "UPDATE proj_vendor_assign a SET a.check_status_b = '$check_status_b', a.checker_id_b = '$checker_id_b', a.check_date_b = '".date("Y-m-d H:i:s")."', a.comment_b='$comment_b' WHERE a.id_project = '$id_project' AND a.id_product = '$id_product' AND a.id_part = '$id_part' AND a.id_doc_part = '$id_doc_part' AND a.check_params = '$check_params' AND a.id_vendor = '$id_vendor' ";
        /* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);

    return $result;
    }

	function dashboard_proc_data(){

		$conn = get_connection(); 
		$query = "SELECT b.id_project, b.proj_num, b.nm_project, d.id_vendor, a.id_product, a.id_part, a.id_doc_part, d.nm_vendor, d.allias from proj_vendor_assign a
				right join project b on a.id_project = b.id_project
                left join proj_doc_assign c on b.id_project = c.id_Project
                left join vendor d on a.id_vendor = d.id_vendor
                group by b.id_project, a.id_vendor
				";
		/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);

	return $result;
	}

	function dashboard_vendor_data($id_vendor)
	{
		$proj_vendor_assign = DB::collection('proj_vendor_assign')->get();
		
		var_dump($proj_vendor_assign);die;
		
		return $result;
		
		//MYSQL ==BACKUP==OLD
		$conn = get_connection(); 
		$query = "SELECT b.id_project, b.nm_project, d.id_vendor, a.id_product, a.id_part, a.id_doc_part, a.id_vendor, d.nm_vendor, d.allias from proj_vendor_assign a
				right join project b on a.id_project = b.id_project
                left join proj_doc_assign c on b.id_project = c.id_Project
                left join vendor d on a.id_vendor = d.id_vendor
                where a.id_vendor = '$id_vendor'
                group by b.id_project, a.id_vendor
				";
		/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);

		return $result;
	}

	function get_proj_doc_assign_data2($id_project){

		$conn = get_connection(); 
		$query = "SELECT a.*, b.doc_type, b.doc_required FROM proj_doc_assign a left join doc_part b on a.id_doc_part = b.id_doc_part WHERE id_project= '$id_project' AND doc_type ='P' AND (doc_required ='Y' OR doc_required = 'M') group by id_project, id_product, id_part, id_doc_part";
		/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);

	return $result;
	}

	function get_proj_doc_upload_data_status($id_project){

		$conn = get_connection(); 
		$query = "SELECT a.*, b.doc_type, b.doc_required FROM proj_doc_upload a left join doc_part b on a.id_doc_part = b.id_doc_part WHERE id_project= '$id_project' AND doc_type ='P' AND (b.doc_required ='Y' OR b.doc_required = 'M') AND upload_path <> '' group by id_project, id_product, id_part, id_doc_part";
		/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);

	return $result;
	}

	function get_proj_doc_assign_data3($id_project, $id_vendor){

		$conn = get_connection(); 
		$query = "SELECT a.*, b.doc_type, b.doc_required FROM proj_vendor_assign a left join doc_part b on a.id_doc_part = b.id_doc_part WHERE id_project= '$id_project' AND doc_type ='V' AND (doc_required ='Y' OR doc_required = 'M') AND id_vendor = '$id_vendor' group by id_project, id_product, id_part, id_doc_part";
		/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);

	return $result;
	}


	function get_proj_doc_upload_data_status2($id_project, $id_vendor){

		$conn = get_connection(); 
		$query = "SELECT a.*, b.doc_type, b.doc_required FROM proj_vendor_upload a left join doc_part b on a.id_doc_part = b.id_doc_part WHERE id_project= '$id_project' AND doc_type ='V' AND (b.doc_required ='Y' OR b.doc_required = 'M' ) AND upload_path <> '' AND id_vendor = '$id_vendor' group by id_project, id_product, id_part, id_doc_part";
		/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);

	return $result;
	}

	function get_proj_vendor_assign_data2($id_project, $id_product, $id_part, $id_doc_part, $id_vendor){

		$conn = get_connection(); 
		$query = "SELECT * FROM proj_vendor_assign
			WHERE id_project= '$id_project' AND id_product ='$id_product' AND id_part='$id_part' AND id_doc_part='$id_doc_part' AND id_vendor = '$id_vendor' ";
		/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);

	return $result;
	}

	function get_proj_venodr_assign_data_status($id_project, $id_product, $id_part, $id_doc_part, $id_vendor){

		$conn = get_connection(); 
		$query = "SELECT sum(check_status_a) as check_status FROM proj_vendor_assign
			WHERE id_project= '$id_project' AND id_product ='$id_product' AND id_part='$id_part' AND id_doc_part='$id_doc_part' AND id_vendor='$id_vendor'";
		/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);

	return $result;
	}

	function get_proj_doc_assign_data_all($id_project){

		$conn = get_connection(); 
		$query = "SELECT a.*, b.doc_type, b.doc_required FROM proj_doc_assign a left join doc_part b on a.id_doc_part = b.id_doc_part WHERE id_project= '$id_project' AND doc_type ='P' AND (doc_required = 'M' OR doc_required ='Y') group by id_project, id_product, id_part, id_doc_part, check_params";
		/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}

	function get_proj_doc_assign_data_status_all($id_project){

		$conn = get_connection(); 
		$query = "SELECT sum(check_status) as check_status FROM proj_doc_assign
			WHERE id_project= '$id_project'";
		/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);

	return $result;
	}

	//editan tanggal 22112017
    function get_proj_doc_assign_data_status_sum_vendor($id_project, $id_vendor){

        $conn = get_connection();
        $query = "SELECT sum(c.check_status) as check_status FROM proj_vendor_assign a 
                  join doc_part b on a.id_doc_part = b.id_doc_part
                  right join proj_doc_assign c on a.id_project = c.id_project and a.id_product =  c.id_product
                  and a.id_part =  c.id_part and a.id_doc_part = c.id_doc_part  and a.check_params = c.check_params
                  WHERE a.id_project= '$id_project' and a.id_vendor = '$id_vendor' and doc_type = 'P'";
        /* $result = mysql_query($query) or die(mysqli_error($conn));
        mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
        mysqli_close($conn);

    return $result;
    }

    function get_proj_doc_assign_data_status_all_vendor($id_project, $id_vendor){

        $conn = get_connection();
        $query = "SELECT a.id_assign, a.id_project, a.id_product, a.id_part, a.id_doc_part, a.check_params, 
                  c.check_status, b.doc_type, a.id_vendor FROM proj_vendor_assign a 
                  join doc_part b on a.id_doc_part = b.id_doc_part
                  right join proj_doc_assign c on a.id_project = c.id_project and a.id_product =  c.id_product 
                  and a.id_part = c.id_part and a.id_doc_part = c.id_doc_part  and a.check_params = c.check_params
                  WHERE a.id_project= '$id_project' and a.id_vendor = '$id_vendor' and doc_type = 'P'";
        /* $result = mysql_query($query) or die(mysqli_error($conn));
        mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
        mysqli_close($conn);

    return $result;
    }

//end of edit tgl 22112017

    function get_proj_doc_assign_sum_part_doc_all_new($id_project, $id_product, $id_part){

        $conn = get_connection();
        $query = "SELECT sum(a.check_status) as check_status FROM proj_doc_assign a join doc_part b on a.id_doc_part = b.id_doc_part WHERE a.id_project= '$id_project' and a.id_product ='$id_product' and a.id_part = '$id_part' and b.doc_required = 'M'";
        /* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);

    return $result;
    }

	function get_proj_doc_assign_sum_part_doc_all($id_project, $id_product, $id_part){

		$conn = get_connection(); 
		$query = "SELECT sum(a.check_status) as check_status FROM proj_doc_assign a join doc_part b on a.id_doc_part = b.id_doc_part WHERE a.id_project= '$id_project' and a.id_product ='$id_product' and a.id_part = '$id_part' and b.doc_required = 'Y'";
		/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);

	return $result;
	}

    function get_proj_doc_assign_part_doc_all_new($id_project, $id_product, $id_part){
        $conn = get_connection();
        $query = "SELECT a.*, b.doc_required, b.doc_type FROM proj_doc_assign a left join doc_part b on a.id_doc_part = b.id_doc_part where a.id_project='$id_project' AND a.id_product = '$id_product' AND a.id_part = '$id_part' AND b.doc_type = 'P' AND b.doc_required = 'M'";
        /* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);

    return $result;
    }

	function get_proj_doc_assign_part_doc_all($id_project, $id_product, $id_part){

		$conn = get_connection(); 
		$query = "SELECT a.*, b.doc_required, b.doc_type FROM proj_doc_assign a left join doc_part b on a.id_doc_part = b.id_doc_part where a.id_project='$id_project' AND a.id_product = '$id_product' AND a.id_part = '$id_part' AND b.doc_type = 'P' AND b.doc_required = 'Y'";
		/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);

	return $result;
	}

    function get_proj_doc_assign_part_doc_all2($id_project, $id_product, $id_part, $id_doc_part){

        $conn = get_connection();
        $query = "SELECT a.*, b.doc_required, b.doc_type FROM proj_doc_assign a left join doc_part b on a.id_doc_part = b.id_doc_part where a.id_project='$id_project' AND a.id_product = '$id_product' AND a.id_part = '$id_part' AND a.id_doc_part ='$id_doc_part' AND b.doc_type = 'P' AND b.doc_required = 'Y'";
        /* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);

    return $result;
    }

    function get_proj_doc_assign_part_doc_all2_new($id_project, $id_product, $id_part, $id_doc_part){

    $conn = get_connection();
    $query = "SELECT a.*, b.doc_required, b.doc_type FROM proj_doc_assign a left join doc_part b on a.id_doc_part = b.id_doc_part where a.id_project='$id_project' AND a.id_product = '$id_product' AND a.id_part = '$id_part' AND a.id_doc_part ='$id_doc_part' AND b.doc_type = 'P' AND (b.doc_required = 'Y' OR b.doc_required='M')";
    /* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);

    return $result;
    }

    function get_proj_doc_assign_sum_part_doc_all2($id_project, $id_product, $id_part, $id_doc_part){

        $conn = get_connection();
        $query = "SELECT sum(a.check_status) as check_status FROM proj_doc_assign a join doc_part b on a.id_doc_part = b.id_doc_part WHERE a.id_project= '$id_project' and a.id_product ='$id_product' and a.id_part = '$id_part' AND a.id_doc_part ='$id_doc_part' and b.doc_required = 'Y'";
        /* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);

    return $result;
    }

    function get_proj_doc_assign_sum_part_doc_all2_new($id_project, $id_product, $id_part, $id_doc_part){

    $conn = get_connection();
    $query = "SELECT sum(a.check_status) as check_status FROM proj_doc_assign a join doc_part b on a.id_doc_part = b.id_doc_part WHERE a.id_project= '$id_project' and a.id_product ='$id_product' and a.id_part = '$id_part' AND a.id_doc_part ='$id_doc_part' and (b.doc_required = 'Y' OR b.doc_required = 'M')";
    /* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);

    return $result;
    }

	function get_proj_vendor_assign_data_all($id_project, $id_vendor){

		$conn = get_connection(); 
		$query = "SELECT a.*, b.doc_type, b.doc_required FROM proj_vendor_assign a left join doc_part b on a.id_doc_part = b.id_doc_part WHERE id_project= '$id_project' AND doc_type ='V' AND (b.doc_required ='Y' OR b.doc_required = 'M') AND id_vendor = '$id_vendor' group by id_project, id_product, id_part, id_doc_part, check_params";
		/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);

	return $result;
	}

	function get_proj_vendor_assign_data_status_all($id_project, $id_vendor){

		$conn = get_connection(); 
		$query = "SELECT sum(check_status_a) as check_status FROM proj_vendor_assign
			WHERE id_project= '$id_project' AND id_vendor = '$id_vendor' ";
		/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);

	return $result;
	}

    function get_proj_vendor_assign_data_status_all2($id_project, $id_vendor){

        $conn = get_connection();
        $query = "SELECT sum(check_status_b) as check_status_b FROM proj_vendor_assign
			WHERE id_project= '$id_project' AND id_vendor = '$id_vendor' ";
        /* $result = mysql_query($query) or die(mysqli_error($conn));
        mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
        mysqli_close($conn);

    return $result;
    }

	function insert_proj_doc_download($id_project, $id_downloader){

		$conn = get_connection();
		$query = "INSERT INTO proj_doc_download (id_project, download_date, id_downloader) VALUES ('$id_project', '".date("Y-m-d")."', '$id_downloader')";
		/* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}

    function get_proj_vendor_assign_data_vendor($id_project, $id_product, $id_part, $id_vendor){

        $conn = get_connection();
        $query = "SELECT * FROM proj_vendor_assign
			WHERE id_project= '$id_project' AND id_product ='$id_product' AND id_part ='$id_part' AND id_vendor = '$id_vendor' ";
        /* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);

    return $result;
    }

    function get_proj_vendor_assign_data_vendor2($id_project, $id_product, $id_part, $id_doc_part, $check_params, $id_vendor){

        $conn = get_connection();
        $query = "SELECT * FROM proj_vendor_assign
			WHERE id_project= '$id_project' AND id_product ='$id_product' AND id_part ='$id_part' AND id_doc_part = '$id_doc_part' AND check_params = '$check_params' AND id_vendor = '$id_vendor' ";
        /* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);

    return $result;
    }


    function get_upload_sequence_vendor($id_project, $id_product, $id_part, $id_vendor){

        $conn = get_connection();
        $query = "SELECT MAX(upload_n) as upload_n FROM proj_vendor_upload
			WHERE id_project= '$id_project' AND id_product ='$id_product' AND id_part='$id_part' AND id_vendor = '$id_vendor'";
        /* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);

    return $result;
    }

    function get_doc_ver_vendor($id_project, $id_product, $id_part, $id_doc_part, $id_vendor){

        $conn = get_connection();
        $query = "SELECT version_n FROM proj_vendor_upload
			WHERE id_project= '$id_project' AND id_product ='$id_product' AND id_part='$id_part' AND id_doc_part='$id_doc_part' AND id_vendor = '$id_vendor'";
        /* $result = mysql_query($query) or die(mysqli_error($conn));
		mysql_close($conn); */
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);

    return $result;
    }


?>