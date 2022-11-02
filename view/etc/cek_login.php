<?php
session_start();
require "conn/conn.php";
$conn = get_connection();
function anti_injection($data){
  $filter = mysqli_real_escape_string($conn,stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  return $filter;
}
//$username = anti_injection($_POST['username']);
//$pass     = anti_injection(md5($_POST['password']));
$username = $_POST['username'];
$pass     = md5($_POST['password']);
// pastikan username dan password adalah berupa huruf atau angka.
if (!ctype_alnum($username) OR !ctype_alnum($pass)){
  echo "Sekarang loginnya tidak bisa di injeksi lho.";
}else{
	$query = "SELECT * FROM user u JOIN vendor v ON u.id_user=v.id_user WHERE username='$username' AND password='$pass'";
	$model = mysqli_query($conn,$query);
	$count = mysqli_num_rows($model);
	if ($count > 0){
		$log = mysqli_fetch_assoc($model);
			//$tgl_sekarang = date("Ymd");
			//$ip = $_SERVER['REMOTE_ADDR'];
			
			include "lib/timeout.php";
			include "lib/library.php";
			
			$_SESSION['id_user']     	= $log['id_user'];
			$_SESSION['username'] 		= $log['username'];
			$_SESSION['nm_user']		= $log['nm_user'];
			$_SESSION['nm_vendor'] 		= $log['nm_vendor'];
			$_SESSION['role']    		= $log['role'];
			// session timeout
			$_SESSION['login'] = 1;
			timer();
			$sid_old = session_id();
			session_regenerate_id();
			$sid_new = session_id();
				mysqli_query($conn,"UPDATE user SET id_session='$sid_new' WHERE username='$username' AND id_user='".$_SESSION['id_user']."'");
				header('location:home.php');
				
	}else{
		$query = "SELECT * FROM user WHERE username='$username' AND password='$pass'";
		$model = mysqli_query($conn,$query);
		$count = mysqli_num_rows($model);
		if ($count > 0){
			$log = mysqli_fetch_assoc($model);
			//$tgl_sekarang = date("Ymd");
			//$ip = $_SERVER['REMOTE_ADDR'];
			
			include "lib/timeout.php";
			include "lib/library.php";
			
			$_SESSION['id_user']     	= $log['id_user'];
			$_SESSION['username'] 		= $log['username'];
			$_SESSION['nm_user']		= $log['nm_user'];
			$_SESSION['role']    		= $log['role'];
			// session timeout
			$_SESSION['login'] = 1;
			timer();
			$sid_old = session_id();
			session_regenerate_id();
			$sid_new = session_id();
				mysqli_query($conn,"UPDATE user SET id_session='$sid_new' WHERE username='$username' AND id_user='".$_SESSION['id_user']."'");
				header('location:home.php');
}
			else{
				//echo "<center><div><p><a class='button' href='login.php'><b>ULANGI LAGI</b></a></p></div></center>";
				//login url
				echo"
		<script>window.alert('Wrong username and password!');
			window.location=('login.php')
		</script>";
				
			}
		}
	
}
?>