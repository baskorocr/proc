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
	include_once "../conn/conn_proc.php";
	include_once "../lib/ip-detect.php";
	//include_once "dociso-query.php";

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

    //MASTER CERTIFICATE
    function del_mstcert_data($cert_id){

		$conn = get_connection_proc();
		$query = "DELETE FROM mst_cert_type WHERE cert_id = '$cert_id' ";
		//$result = mysql_query($query) or die(mysqli_error($conn));
		//mysql_close($conn);
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
		return $result;
	}

	function update_mstcert_data($cert_id, $cert_name, $id_user, $ch_date){

		$conn = get_connection_proc();
		$query = "UPDATE mst_cert_type SET cert_name = '$cert_name', ch_date ='".date("Y-m-d h:i:s")."', ch_by ='$id_user' 
					WHERE cert_id = '$cert_id' ";
		//$result = mysql_query($query) or die(mysqli_error($conn));
		//mysql_close($conn);
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
		return $result;
	}

	//MASTER ISO TYPE
	function del_mstiso_data($iso_type_id){

		$conn = get_connection_proc();
		$query = "DELETE FROM mst_iso_type WHERE iso_type_id = '$iso_type_id' ";
		//$result = mysql_query($query) or die(mysqli_error($conn));
		//mysql_close($conn);
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
		return $result;
	}

	function update_mstiso_data($iso_type_id, $cert_type_name, $id_user, $ch_date){

		$conn = get_connection_proc();
		$query = "UPDATE mst_iso_type SET iso_type_name = '$cert_type_name', ch_date ='".date("Y-m-d h:i:s")."', ch_by ='$id_user' 
					WHERE iso_type_id = '$iso_type_id' ";
		//$result = mysql_query($query) or die(mysqli_error($conn));
		//mysql_close($conn);
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
		return $result;
	}

	//MASTER ISO NOTIFY
	function del_mstnotif_data($notif_id){

		$conn = get_connection_proc();
		$query = "DELETE FROM mst_iso_notify WHERE notif_id = '$notif_id' ";
		//$result = mysql_query($query) or die(mysqli_error($conn));
		//mysql_close($conn);
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
		return $result;
	}

	function update_mstnotif_data($notif_id, $notif_before, $uom, $id_user, $ch_date){

		$conn = get_connection_proc();
		$query = "UPDATE mst_iso_notify SET notif_before = '$notif_before', uom = '$uom', ch_date ='".date("Y-m-d h:i:s")."', ch_by ='$id_user' 
					WHERE notif_id = '$notif_id' ";
		//$result = mysql_query($query) or die(mysqli_error($conn));
		//mysql_close($conn);
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
		return $result;
	}

	//REGISTER ISO
	function del_regiso_data($trn_id, $doc_year){

		$conn = get_connection_proc();
		$query = "UPDATE trn_iso_doc SET del_indicator = 'X' WHERE trn_id = '".$trn_id."' AND $doc_year = '".$doc_year."' ";
		//$result = mysql_query($query) or die(mysqli_error($conn));
		//mysql_close($conn);
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
		return $result;
	}

	

//php tag
    if(isset($_GET['act']) && $_GET['act']=="del" && $_GET['mod']=="mstcert"){

    	$cert_id = $_GET['cert_id'];

		del_mstcert_data($cert_id);
    	echo"
		<script>window.alert('Data has been deleted');
			window.location=('../home.php?mnu=mstcert')
		</script>";

    } elseif (isset($_POST['edit-mstcert'])){

		$cert_id 	 = $_POST['cert_id'];
		$cert_name 	 = $_POST['cert_name'];
		$id_user 	 = $_POST['id_user'];
		$ch_date	 = date("Y-m-d h:i:s");

        update_mstcert_data($cert_id, $cert_name, $id_user, $ch_date);

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
            window.location = (\'../home.php?mnu=mstcert\');
        });
        
        </script>
        ';

	} 
	

	elseif(isset($_GET['act']) && $_GET['act']=="del" && $_GET['mod']=="mstiso"){

    	$iso_type_id = $_GET['iso_type_id'];

		del_mstiso_data($iso_type_id);
    	echo"
		<script>window.alert('Data has been deleted');
			window.location=('../home.php?mnu=mstiso')
		</script>";

    } elseif (isset($_POST['edit-mstiso'])){

		$iso_type_id 	= $_POST['iso_type_id'];
		$cert_type_name = $_POST['iso_type_name'];
		$id_user 	 	= $_POST['id_user'];
		$ch_date	 	= date("Y-m-d h:i:s");

        update_mstiso_data($iso_type_id, $cert_type_name, $id_user, $ch_date);

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
            window.location = (\'../home.php?mnu=mstiso\');
        });
        
        </script>
        ';

	} 
	
	elseif(isset($_GET['act']) && $_GET['act']=="del" && $_GET['mod']=="mstnotif"){

    	$notif_id = $_GET['notif_id'];

		del_mstnotif_data($notif_id);
    	echo"
		<script>window.alert('Data has been deleted');
			window.location=('../home.php?mnu=mstnotif')
		</script>";

    } elseif (isset($_POST['edit-mstnotif'])){

		$notif_id 	 	= $_POST['notif_id'];
		$notif_before 	= $_POST['notif_before'];
		$uom 			= $_POST['uom'];
		$id_user 	 	= $_POST['id_user'];
		$ch_date	 	= date("Y-m-d h:i:s");

        update_mstnotif_data($notif_id, $notif_before, $uom, $id_user, $ch_date);

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
            window.location = (\'../home.php?mnu=mstnotif\');
        });
        
        </script>
        ';

	} 

	elseif(isset($_GET['act']) && $_GET['act']=="del" && $_GET['mod']=="regiso"){

		$trn_id 	= $_GET['trn_id'];
		$doc_year 	= $_GET['doc_year'];
		$id_user    = $_GET['id_user'];
		$trn_type   = "";
		$trn_date	= date('Y-m-d');
		$trn_time 	= date('H:i:s');
		$trn_detail	= '';

		$ip_addr       = ip_detect();

		del_regiso_data($trn_id, $doc_year);
		insert_iso_log($trn_id, $doc_year, $id_user, $trn_type, $trn_date, $trn_time, $ip_addr, $trn_detail);
		
		echo"
		<script>window.alert('Data has been deleted');
			window.location=('../home.php?mnu=isoreport')
		</script>";
		

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
