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
    include_once "function.php";
    include_once "function-mail-reset-pwd.php";

    function del_user_data($id_user){

		$conn = get_connection();
		$query = "DELETE FROM user WHERE id_user = '$id_user'";
		//$result = mysql_query($query) or die(mysqli_error($conn));
		//mysql_close($conn);
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
		return $result;
	}


	function update_user_data($id_user, $nm_user, $id_tipe_user, $status_user, $username, $role, $id_access_group){

	$conn = get_connection();
	$query = "UPDATE user SET nm_user='$nm_user', id_tipe_user='$id_tipe_user', 
                status_user='$status_user', username = '$username', 
                role='$role', id_access_group = '$id_access_group' 
              WHERE id_user = '$id_user'";
	//$result = mysql_query($query) or die(mysqli_error($conn));
	//mysql_close($conn);
	$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
	mysqli_close($conn);
	return $result;
	}

	function reset_pwd($id_user, $passwd){
        //$passwd = "Dharma008";

        $conn = get_connection();
        $query = "UPDATE user SET password=md5('$passwd') WHERE id_user = '$id_user'";
        //$result = mysql_query($query) or die(mysqli_error($conn));
		//mysql_close($conn);
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
        return $result;
	}


	function inactive_user($id_user){

	$conn = get_connection();
	$query = "UPDATE user SET status_user='N' WHERE id_user = '$id_user'";
	//$result = mysql_query($query) or die(mysqli_error($conn));
	//mysql_close($conn);
	$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
	mysqli_close($conn);
	return $result;
	}


	function update_vendor_data($id_vendor, $nm_vendor, $allias, $street, $status_vendor){

	$conn = get_connection();
	$query = "UPDATE vendor SET nm_vendor='$nm_vendor', allias='$allias', street='$street', status_vendor='$status_vendor' WHERE id_vendor = '$id_vendor'";
	//$result = mysql_query($query) or die(mysqli_error($conn));
	//mysql_close($conn);
	$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
	mysqli_close($conn);
	return $result;
	}

	function del_vendor_data($id_vendor){

		$conn = get_connection();
		$query = "DELETE FROM vendor WHERE id_vendor = '$id_vendor'";
		//$result = mysql_query($query) or die(mysqli_error($conn));
		//mysql_close($conn); -->
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
		return $result;
	}

    function update_menu_data($id_menu, $menu_name, $menu_object, $object_path, $id_user, $mn_status){

        $conn = get_connection();
        $query = "UPDATE menu_list SET menu_name='$menu_name', menu_object='$menu_object', 
                    object_path='$object_path', last_changed_by = '$id_user', 
                    last_changed = '".date("Y-m-d H:i:s")."', mn_status='$mn_status'  
                 WHERE id_menu = '$id_menu' ";
        //$result = mysql_query($query) or die(mysqli_error($conn));
		//mysql_close($conn); -->
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
        return $result;
    }

    function del_menu_data($id_menu){

		$conn = get_connection();
		$query = "DELETE FROM menu_list WHERE id_menu = '$id_menu' ";
		//$result = mysql_query($query) or die(mysqli_error($conn));
		//mysql_close($conn); -->
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
		return $result;
    }
    
    function update_menu_group_data($id_menu_group, $menu_group_name, $menu_group_obj, $id_user, $mg_status){

        $conn = get_connection();
        $query = "UPDATE menu_group_list SET menu_group_name='$menu_group_name', menu_group_object= '$menu_group_obj', 
                    last_changed_by = '$id_user', last_changed = '".date("Y-m-d H:i:s")."', mg_status='$mg_status'  
                 WHERE id_menu_group = '$id_menu_group' ";
        //$result = mysql_query($query) or die(mysqli_error($conn));
		//mysql_close($conn); -->
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
        return $result;
    }

    function del_menu_group_data($id_menu_group){

		$conn = get_connection();
		$query = "DELETE FROM menu_group_list WHERE id_menu_group = '$id_menu_group' ";
		//$result = mysql_query($query) or die(mysqli_error($conn));
		//mysql_close($conn); -->
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
		return $result;
    }

    function del_email_group($dept_code){

		$conn = get_connection_proc();
		$query = "DELETE FROM dept_master WHERE dept_code = '$dept_code' ";
		//$result = mysql_query($query) or die(mysqli_error($conn));
		//mysql_close($conn); -->
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
		return $result;
	}

    function del_email_list_group($mail, $dept_code){

		$conn = get_connection_proc();
		$query = "DELETE FROM mail_mgt WHERE mail = '$mail' AND dept_code = '$dept_code' ";
		//$result = mysql_query($query) or die(mysqli_error($conn));
		//mysql_close($conn); -->
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
		return $result;
	}

    function del_number_range($doc_type, $doc_year){

		$conn = get_connection_proc();
		$query = "DELETE FROM doc_number WHERE doc_type = '$doc_type' AND doc_year = '$doc_year' ";
		//$result = mysql_query($query) or die(mysqli_error($conn));
		//mysql_close($conn); -->
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
		return $result;
	}

    function get_all_user_data_by_iduser($id_user){

        $conn = get_connection();
        $query = "SELECT u.id_user, u.nm_user, t.nm_tipe_user, u.username, u.password, 
                u.status_user, u.role, v.nm_vendor, ag.access_group_name
                FROM user u 
                join tipe_user t ON u.id_tipe_user = t.id_tipe_user 
                left join vendor v ON v.id_vendor = u.foreign_id
                left join access_group_list ag ON u.id_access_group = ag.id_access_group
                WHERE u.id_user = '$id_user'
                ORDER BY u.id_user ASC";
        //$result = mysql_query($query) or die(mysqli_error($conn));
		//mysql_close($conn); -->
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		mysqli_close($conn);
        return $result;
    }

    if(isset($_GET['act']) && $_GET['act']=="del" && $_GET['mod']=="umaster"){

    	$id_user = $_GET['id_user'];

    	del_user_data($id_user);
    	echo"
		<script>window.alert('Data has been deleted');
			window.location=('../home.php?mnu=umaster')
		</script>";

    } elseif (isset($_POST['edit-umaster'])){

    	$id_user = $_POST['id_user'];
    	$nm_user = $_POST['nm_user'];
    	$id_tipe_user = $_POST['tipe_user'];
    	$status_user = $_POST['status_user'];
        $username = $_POST['username'];
        $id_access_group = $_POST['id_access'];

    	if ($id_tipe_user == '00'){
            $role = 'proc';
        } elseif ($id_tipe_user == '01'){
            $role = 'eng';
        } elseif ($id_tipe_user == '02'){
            $role = 'qa';
        } elseif ($id_tipe_user == '03'){
            $role = 'admin';
        } elseif ($id_tipe_user == '04'){
            $role = 'vendor';
        }

        update_user_data($id_user, $nm_user, $id_tipe_user, $status_user, $username, $role, $id_access_group);

        //if update_user_data is ok and status_user is active
            //get data email by user
            //if username is an email address
                //send mail user activation to user by user id
                //attach username and password on email body
            //endif
        //endif

    	/*
    	echo"
		<script>window.alert('Data has been updated');
			window.location=('../home.php?mnu=umaster')
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
            window.location = (\'../home.php?mnu=umaster\');
        });
        
        </script>
        ';

    } elseif (isset($_POST['edit-vmaster'])){

    	$id_vendor 		= $_POST['id_vendor'];
    	$nm_vendor      = $_POST['nm_vendor'];
        $allias         = $_POST['allias'];
        $street         = $_POST['street'];
        $status_vendor  = $_POST['status_vendor'];
        //$id_user        = $_POST['id_user'];

        update_vendor_data($id_vendor, $nm_vendor, $allias, $street, $status_vendor);

    	/*
    	echo"
		<script>window.alert('Data has been updated');
			window.location=('../home.php?mnu=vmaster')
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
            window.location = (\'../home.php?mnu=vmaster\');
        });
        
        </script>
        ';

	} elseif (isset($_GET['act']) && $_GET['act']=="del" && $_GET['mod']=="vmaster"){

		$id_vendor = $_GET['id_vendor'];
		$id_user = $_GET['id_user'];

		//inactivated user

    	del_vendor_data($id_vendor);
    	inactive_user($id_user);
    	/*
    	echo"
		<script>window.alert('Data has been deleted');
			window.location=('../home.php?mnu=vmaster')
		</script>";
    	*/

        echo '
        <script>
        swal({
            title: "Deleted!",
            text: "Data has been deleted!",
            type: "warning",
            customClass: \'swal-wide\',
            allowOutsideClick: false
        })
            .then(function() {
            window.location = (\'../home.php?mnu=vmaster\');
        });
        
        </script>
        ';

	} elseif (isset($_GET['act']) && $_GET['act']=="rst" && $_GET['mod']=="umaster"){

        $id_user = $_GET['id_user'];    
        $passwd = randomPassword();
        $data = array();

        $query_exec = get_all_user_data_by_iduser($id_user);
        $row = mysqli_fetch_assoc($query_exec);

        if ($row['nm_vendor'] == ""){
            $data['nm_vendor'] = $row['nm_user'];
        } else {
            $data['nm_vendor']  = $row['nm_vendor'];
        }

        $data['email'] = $row['username'];
        $data['passwd'] = $passwd;

        if(reset_pwd($id_user, $passwd)){
            mailresetpwd($data);
        }

         //if reset_pwd is ok
            //get data email by user
            //if username is an email address
                //send mail reset pwd to user by user id
                //attach username and password on email body
            //endif
        //endif

		/*
        echo"
		<script>window.alert('Password reset success.');
			window.location=('../home.php?mnu=umaster')
		</script>";
		*/

        echo '
        <script>
        swal({
            title: "Success!",
            text: "Password reset success!",
            type: "success",
            customClass: \'swal-wide\',
            allowOutsideClick: false
        })
            .then(function() {
            window.location = (\'../home.php?mnu=umaster\');
        });
        
        </script>
        ';

    } elseif (isset($_GET['act']) && $_GET['act']=="inact" && $_GET['mod']=="umaster"){

        $id_user = $_GET['id_user'];

        inactive_user($id_user);
        /*
        echo"
        <script>window.alert('Password reset success.');
            window.location=('../home.php?mnu=umaster')
        </script>";
        */

        echo "
        <script>
            swal({
                title: 'Blocked!',
                text: 'Selected user has been blocked (inactivated) !',
                type: 'success',
                customClass: 'swal-wide',
                allowOutsideClick: false
                })
                    .then(function() {
                        window.location = ('../home.php?mnu=usrlog');
                });
        </script>
        ";

    } elseif (isset($_POST['edit-menu'])){

        $id_menu        = $_POST['id_menu'];
        $menu_name      = $_POST['menu_name'];
        $menu_object    = $_POST['menu_object'];
        $object_path    = $_POST['object_path'];
        $id_user        = $_POST['id_user'];
        $mn_status      = $_POST['mn_status'];

        update_menu_data($id_menu, $menu_name, $menu_object, $object_path, $id_user, $mn_status);

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
            window.location = (\'../home.php?mnu=mnumaster\');
        });
        
        </script>
        ';

    } elseif(isset($_GET['act']) && $_GET['act']=="del" && $_GET['mod']=="mnumaster"){

    	$id_menu = $_GET['id_menu'];

        del_menu_data($id_menu);
        
    	echo"
		<script>window.alert('Data has been deleted');
			window.location=('../home.php?mnu=mnumaster')
		</script>";

    } elseif (isset($_POST['edit-menu-group'])){

        $id_menu_group      = $_POST['id_menu_group']; 
        $menu_group_name    = $_POST['menu_group_name'];
        $menu_group_obj     = $_POST['menu_group_object'];
        $id_user            = $_POST['id_user']; 
        $mg_status          = $_POST['mg_status'];

        update_menu_group_data($id_menu_group, $menu_group_name, $menu_group_obj, $id_user, $mg_status);

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
            window.location = (\'../home.php?mnu=mnugroup\');
        });
        
        </script>
        ';

    } elseif(isset($_GET['act']) && $_GET['act']=="del" && $_GET['mod']=="mnugroup"){

        $id_menu_group = $_GET['id_menu_group'];
        
        del_menu_group_data($id_menu_group);
        
    	echo"
		<script>window.alert('Data has been deleted');
			window.location=('../home.php?mnu=mnugroup')
		</script>";

    } elseif(isset($_GET['act']) && $_GET['act']=="del" && $_GET['mod']=="emailgrp"){

        $dept_code = $_GET['dept_code'];
        
        if(del_email_group($dept_code)) {

            echo '
            <script>
            swal({
                title: "Deleted!",
                text: "Data has been deleted!",
                type: "success",
                customClass: \'swal-wide\',
                allowOutsideClick: false
            })
                .then(function() {
                window.location = (\'../home.php?mnu=emailgrp\');
            });
            
            </script>
            ';

        } else {

            echo '
            <script>
            swal({
                title: "No Deleted!",
                text: "Fail Deleting Data!",
                type: "error",
                customClass: \'swal-wide\',
                allowOutsideClick: false
            })
                .then(function() {
                window.location = (\'../home.php?mnu=emailgrp\');
            });
            
            </script>
            ';
        }

    } elseif(isset($_GET['act']) && $_GET['act']=="del" && $_GET['mod']=="emailgrlist"){

        $mail = $_GET['mail'];
        $dept_code = $_GET['dept_code'];
        
        if(del_email_list_group($mail, $dept_code)) {

            echo '
            <script>
            swal({
                title: "Deleted!",
                text: "Data has been deleted!",
                type: "success",
                customClass: \'swal-wide\',
                allowOutsideClick: false
            })
                .then(function() {
                window.location = (\'../home.php?mnu=emailgrlist\');
            });
            
            </script>
            ';

        } else {

            echo '
            <script>
            swal({
                title: "No Deleted!",
                text: "Fail Deleting Data!",
                type: "error",
                customClass: \'swal-wide\',
                allowOutsideClick: false
            })
                .then(function() {
                window.location = (\'../home.php?mnu=emailgrlist\');
            });
            
            </script>
            ';
        }

    } elseif(isset($_GET['act']) && $_GET['act']=="del" && $_GET['mod']=="numrange"){

        $doc_type = $_GET['doc_type'];
        $doc_year = $_GET['doc_year'];
        
        if(del_number_range($doc_type, $doc_year)) {

            echo '
            <script>
            swal({
                title: "Deleted!",
                text: "Data has been deleted!",
                type: "success",
                customClass: \'swal-wide\',
                allowOutsideClick: false
            })
                .then(function() {
                window.location = (\'../home.php?mnu=numrange\');
            });
            
            </script>
            ';

        } else {

            echo '
            <script>
            swal({
                title: "No Deleted!",
                text: "Fail Deleting Data!",
                type: "error",
                customClass: \'swal-wide\',
                allowOutsideClick: false
            })
                .then(function() {
                window.location = (\'../home.php?mnu=numrange\');
            });
            
            </script>
            ';
        }

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

