<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">

	<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

	<!-- bootstrap 3.0.2 -->
	<link href="../../css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<!-- font Awesome -->
	<link href="../../css/font-awesome.min.css" rel="stylesheet" type="text/css" />

	<!-- sweet alert -->
	<link href="../../css/sweet-alert.css" rel="stylesheet" type="text/css" />
	<script src="../../js/sweet-alert/sweetalert.min.js" type="text/javascript"></script>

</head>

<body>
<?php
    include_once "../conn/conn.php";

    //PRODUCT
    function del_prod_data($id_product){

		$conn = get_connection();
		$query = "DELETE FROM product WHERE id_product = '$id_product'";
		//$result = mysql_query($query) or die(mysqli_error($conn));
		//mysql_close($conn);
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
		return $result;
	}


	function update_prod_data($id_product, $prod_num, $nm_product, $id_user){

		$conn = get_connection();
		$query = "UPDATE product SET prod_num = '$prod_num', nm_product='$nm_product', modify_date='".date("Y-m-d")."', id_user='$id_user' WHERE id_product = '$id_product'";
		//$result = mysql_query($query) or die(mysqli_error($conn));
		//mysql_close($conn);
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}

	//PRODUCT FOR PROJECT
	function del_prod_for_proj($id_project){

		$conn = get_connection();
		$query = "DELETE FROM product_for_project WHERE id_project = '$id_project'";
		//$result = mysql_query($query) or die(mysqli_error($conn));
		//mysql_close($conn);
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
		return $result;
	}

	//PRODUCT FOR PROJECT
	function del_part_for_prod($id_product){

		$conn = get_connection();
		$query = "DELETE FROM part_for_product WHERE id_product = '$id_product'";
		//$result = mysql_query($query) or die(mysqli_error($conn));
		//mysql_close($conn);
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
		return $result;
	}

	//DOCUMENT FOR PART
	function del_doc_for_part($id_part){

		$conn = get_connection();
		$query = "DELETE FROM doc_for_part WHERE id_part = '$id_part'";
		//$result = mysql_query($query) or die(mysqli_error($conn));
		//mysql_close($conn);
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
		return $result;
	}

	//PART
	function del_part_data($id_part){

		$conn = get_connection();
		$query = "DELETE FROM part WHERE id_part = '$id_part'";
		//$result = mysql_query($query) or die(mysqli_error($conn));
		//mysql_close($conn);
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
		return $result;
	}

	function update_part_data($id_part, $part_num, $nm_part, $id_user){

		$conn = get_connection();
		$query = "UPDATE part SET part_num ='$part_num', nm_part='$nm_part', modify_date='".date("Y-m-d")."', id_user='$id_user' WHERE id_part = '$id_part'";
		//$result = mysql_query($query) or die(mysqli_error($conn));
		//mysql_close($conn);
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}

	//PROJECT
	function update_project_data($id_project, $proj_num, $nm_project, $id_user){

		$conn = get_connection();
		$query = "UPDATE project SET proj_num ='$proj_num', nm_project='$nm_project', modify_date='".date("Y-m-d")."', id_user='$id_user' WHERE id_project = '$id_project'";
		//$result = mysql_query($query) or die(mysqli_error($conn));
		//mysql_close($conn);
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}

	function del_project_data($id_project){

		$conn = get_connection();
		$query = "DELETE FROM project WHERE id_project = '$id_project'";
		//$result = mysql_query($query) or die(mysqli_error($conn));
		//mysql_close($conn);
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
		return $result;
	}

	//DOCUMENT
	function update_doc_part_data($id_doc_part, $nm_doc_part, $doc_type, $doc_required, $id_user){

		$conn = get_connection();
		$query = "UPDATE doc_part SET nm_doc_part='$nm_doc_part', doc_type='$doc_type', doc_required='$doc_required', modify_date='".date("Y-m-d")."', id_user='$id_user' WHERE id_doc_part = '$id_doc_part'";
		//$result = mysql_query($query) or die(mysqli_error($conn));
		//mysql_close($conn);
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}


	function del_doc_part_data($id_doc_part){

		$conn = get_connection();
		$query = "DELETE FROM doc_part WHERE id_doc_part = '$id_doc_part'";
		//$result = mysql_query($query) or die(mysqli_error($conn));
		//mysql_close($conn);
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
		return $result;
	}

	//DOCUMENT FOR PART
	function del_doc_check_list($id_doc_part){

		$conn = get_connection();
		$query = "DELETE FROM doc_check_list WHERE id_doc_part = '$id_doc_part'";
		//$result = mysql_query($query) or die(mysqli_error($conn));
		//mysql_close($conn);
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
		return $result;
	}

	//LIST CHECK PARAMS
	function update_check_params_data($id_check, $check_params,  $id_user){

		$conn = get_connection();
		$query = "UPDATE doc_check_list SET check_params='$check_params', modify_date='".date("Y-m-d")."', id_user='$id_user' WHERE id_check = '$id_check'";
		//$result = mysql_query($query) or die(mysqli_error($conn));
		//mysql_close($conn);
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}

	//update permission
	function update_permission($id_project, $id_product, $id_part){

		$conn = get_connection();
		$query = "UPDATE proj_doc_upload SET permit_n = permit_n + 1 WHERE id_project= '$id_project' AND id_product = '$id_product' AND id_part = '$id_part' ";
		//$result = mysql_query($query) or die(mysqli_error($conn));
		//mysql_close($conn);
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}

	function stop_permission($id_project, $id_product, $id_part){

		$conn = get_connection();
		$query = "UPDATE proj_doc_upload SET permit_n = 0 WHERE id_project= '$id_project' AND id_product = '$id_product' AND id_part = '$id_part' ";
		//$result = mysql_query($query) or die(mysqli_error($conn));
		//mysql_close($conn);
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
	return $result;
	}
	

//php tag
    if(isset($_GET['act']) && $_GET['act']=="del" && $_GET['mod']=="prodmaster"){

    	$id_product = $_GET['id_product'];

    	del_prod_data($id_product);
    	del_part_for_prod($id_product);
    	echo"
		<script>window.alert('Data has been deleted');
			window.location=('../home.php?mnu=prodmaster')
		</script>";

    } elseif (isset($_POST['edit-prodmaster'])){

    	$id_product	 = $_POST['id_product'];
    	$prod_num    = $_POST['prod_num'];
		$nm_product	 = $_POST['nm_product'];
		$id_user 	 = $_POST['id_user'];

        update_prod_data($id_product, $prod_num, $nm_product, $id_user);
        /*
    	echo"
		<script>window.alert('Data has been updated');
			window.location=('../home.php?mnu=prodmaster')
		</script>";
		*/
        echo '
        <script>
        swal({
            title: "Success!",
            text: "Data has been updated!",
            type: "success",
            customClass: \'swal-wide\',
            allowOutsideClick: false
        })
            .then(function() {
            window.location = (\'../home.php?mnu=prodmaster\');
        });
        
        </script>
        ';

    } elseif (isset($_POST['edit-partmaster'])){

    	$id_part	= $_POST['id_part'];
    	$part_num   = $_POST['part_num'];
    	$nm_part	= $_POST['nm_part'];
    	$id_user	= $_POST['id_user'];

        update_part_data($id_part, $part_num, $nm_part, $id_user);
        /*
    	echo"
		<script>window.alert('Data has been updated');
			window.location=('../home.php?mnu=partmaster')
		</script>";
        */

        echo '
        <script>
        swal({
            title: "Success!",
            text: "Data has been updated!",
            type: "success",
            customClass: \'swal-wide\',
            allowOutsideClick: false
        })
            .then(function() {
            window.location = (\'../home.php?mnu=partmaster\');
        });
        
        </script>
        ';

	} elseif (isset($_GET['act']) && $_GET['act']=="del" && $_GET['mod']=="partmaster"){

		$id_part = $_GET['id_part'];
		//inactivated user

    	del_part_data($id_part);
    	del_doc_for_part($id_part);
    	echo"
		<script>window.alert('Data has been deleted');
			window.location=('../home.php?mnu=partmaster')
		</script>";

	} elseif (isset($_POST['edit-partforprod'])){

    	$id_part	= $_POST['id_part'];
    	$nm_part	= $_POST['nm_part'];
    	$id_user	= $_POST['id_user'];

    	update_part_data($id_part, $nm_part, $id_user);
    	/*
    	echo"
		<script>window.alert('Data has been updated');
			window.location=('../home.php?mnu=partmaster')
		</script>";
    	*/

        echo '
        <script>
        swal({
            title: "Success!",
            text: "Data has been updated!",
            type: "success",
            customClass: \'swal-wide\',
            allowOutsideClick: false
        })
            .then(function() {
            window.location = (\'../home.php?mnu=partmaster\');
        });
        
        </script>
        ';

	} elseif (isset($_POST['edit-projmaster'])){

    	$id_project	= $_POST['id_project'];
        $proj_num	= $_POST['proj_num'];
    	$nm_project	= $_POST['nm_project'];
    	$id_user	= $_POST['id_user'];
    	//$id_user	= "00001";

    	update_project_data($id_project, $proj_num, $nm_project, $id_user);
    	/*
    	echo"
		<script>window.alert('Data has been updated');
			window.location=('../home.php?mnu=projmaster')
		</script>";
		*/
        echo '
        <script>
        swal({
            title: "Success!",
            text: "Data has been updated!",
            type: "success",
            customClass: \'swal-wide\',
            allowOutsideClick: false
        })
            .then(function() {
            window.location = (\'../home.php?mnu=projmaster\');
        });
        
        </script>
        ';

	} elseif (isset($_GET['act']) && $_GET['act']=="del" && $_GET['mod']=="projmaster"){

		$id_project = $_GET['id_project'];
		//inactivated user

    	del_project_data($id_project);
    	del_prod_for_proj($id_project);
    	echo"
		<script>window.alert('Data has been deleted');
			window.location=('../home.php?mnu=projmaster')
		</script>";

	} elseif (isset($_POST['edit-docmaster'])){

    	$id_doc_part	= $_POST['id_doc_part'];
		$nm_doc_part 	= $_POST['nm_doc_part'];
		$doc_type		= $_POST['doc_type'];
		$id_user 	 	= $_POST['id_user'];

        if ($_POST['doc_required'] == "M"){
            $doc_required   = "M";
        } elseif ($_POST['doc_required'] == "Y") {
            $doc_required   = "Y";
        } elseif ($_POST['doc_required'] == "N") {
            $doc_required   = "N";
        }

    	update_doc_part_data($id_doc_part, $nm_doc_part, $doc_type, $doc_required, $id_user);
        /*
    	echo"
		<script>window.alert('Data has been updated');
			window.location=('../home.php?mnu=docmaster')
		</script>";
        */

        echo '
        <script>
        swal({
            title: "Success!",
            text: "Data has been updated!",
            type: "success",
            customClass: \'swal-wide\',
            allowOutsideClick: false
        })
            .then(function() {
            window.location = (\'../home.php?mnu=docmaster\');
        });
        
        </script>
        ';

    } elseif (isset($_GET['act']) && $_GET['act']=="del" && $_GET['mod']=="docmaster"){

		$id_doc_part = $_GET['id_doc'];

    	del_doc_part_data($id_doc_part);
    	del_doc_check_list($id_doc_part);
    	echo"
		<script>window.alert('Data has been deleted');
			window.location=('../home.php?mnu=docmaster')
		</script>";

	} elseif (isset($_POST['edit-listcheckmaster'])){

    	$id_check		= $_POST['id_check'];
		$check_params 	= $_POST['check_params'];
		$id_user 	 	= $_POST['id_user'];

    	update_check_params_data($id_check, $check_params,  $id_user);
    	/*
    	echo"
		<script>window.alert('Data has been updated');
			window.location=('../home.php?mnu=listcheckmaster')
		</script>";
    	*/

        echo '
        <script>
        swal({
            title: "Success!",
            text: "Data has been updated!",
            type: "success",
            customClass: \'swal-wide\',
            allowOutsideClick: false
        })
            .then(function() {
            window.location = (\'../home.php?mnu=listcheckmaster\');
        });
        
        </script>
        ';

    } elseif (isset($_GET['act']) && $_GET['act']=="permitupl"){

    	$string = $_GET['data'];
    	$data = explode(",", $string);

    	$id_project		= $data[0];
		$id_product 	= $data[1];
		$id_part 	 	= $data[2];

    	update_permission($id_project, $id_product, $id_part);
    	/*
    	echo"
		<script>window.alert('Permission activated');
			window.location=('../home.php?mnu=uplddraw')
		</script>";
    	*/

        echo '
        <script>
        swal({
            title: "Activated!",
            text: "Permission was activated!",
            type: "success",
            customClass: \'swal-wide\',
            allowOutsideClick: false
        })
            .then(function() {
            window.location = (\'../home.php?mnu=uplddraw\');
        });
        
        </script>
        ';

    } elseif (isset($_GET['act']) && $_GET['act']=="unpermitupl"){

    	$string = $_GET['data'];
    	$data = explode(",", $string);

    	$id_project		= $data[0];
		$id_product 	= $data[1];
		$id_part 	 	= $data[2];

    	stop_permission($id_project, $id_product, $id_part);
    	/*
    	echo"
		<script>window.alert('Permission deactivated');
			window.location=('../home.php?mnu=uplddraw')
		</script>";
    	*/

        echo '
        <script>
        swal({
            title: "Deactivated!",
            text: "Permission deactivated!",
            type: "warning",
            customClass: \'swal-wide\',
            allowOutsideClick: false
        })
            .then(function() {
            window.location = (\'../home.php?mnu=uplddraw\');
        });
        
        </script>
        ';

    }
?>


<script src="../../jquery-2/jquery.min.js"></script>
<!-- jQuery UI 1.10.3 -->
<script src="../../js/jquery-ui-1.10.3.min.js" type="text/javascript"></script>
<!-- Bootstrap -->
<script src="../../js/bootstrap.min.js" type="text/javascript"></script>

<!-- Bootstrap WYSIHTML5 -->
<script src="../../js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
<!-- Bootstrap -->
<script src="../../js/bootstrap.min.js" type="text/javascript"></script>
</body>
