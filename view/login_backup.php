<?php

    include_once "registration/master-data-query.php";
    require "lib/ip-detect.php";
    include "lib/function.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>eProc Dharma Polimetal</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<!--
	<link rel="icon" type="image/png" href="../assets/login/images/icons/favicon.ico"/>
	-->
	
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../assets/login/vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../assets/login/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../assets/login/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../assets/login/vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="../assets/login/vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../assets/login/vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../assets/login/vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="../assets/login/vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../assets/login/css/util.css">
	<link rel="stylesheet" type="text/css" href="../assets/login/css/main.css">
<!--===============================================================================================-->

    <link rel="stylesheet" href="../assets/login/css/w3.css">
    <link rel="stylesheet" href="../assets/login/css/animate.css">

 <!-- Bootstrap 3.3.6 -->
	<link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
	<link href="../css/AdminLTE.css" rel="stylesheet" type="text/css" />
	
	<script src="../js/sweet-alert/sweetalert.min.js" type="text/javascript"></script>
	
	<link rel="icon" type="image/x-icon" href="../img/favicon3.png" />


</head>
<body style="background-color: #666666;" oncontextmenu="return false">
	
	<div class="limiter">
		<div class="container-login100">
		
			<div class="wrap-login100">
				<form class="login100-form validate-form" role=form name="Form1" id="Form1" onSubmit="return myLoader()" action="" method="post">
					
					<div class="login-logo" style="margin-top: -8%;" >
						<br>
						<center><img src="../assets/login/images/logo1.png" style="width: 80px; margin-top: 10%;"></center>
					</div>
                    <br>
                    <center><b style="color: #000; font-size: 20px;">eProcurement</b></center>
                    <br>

                    <?php
												
                    if (isset($_POST['login'])){

                        session_start();
                        //require "conn/conn.php";
                        //get_connection();
                        $ip         = ip_detect();
                        function anti_injection($data){
						  get_connection();
                          $filter = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
                          return $filter;
                        }

                            $username = anti_injection($_POST['username']);
                            $pass = anti_injection(md5($_POST['password']));
                            //$username = $_POST['username'];
                            //$pass     = md5($_POST['password']);
							
							

                        // pastikan username dan password adalah berupa huruf atau angka.
                        //if (!ctype_alnum($username) OR !ctype_alnum($pass))
                        if (!ctype_alnum($pass)){
                          echo "You don't have access to this site!";
                        }else{
                            
                            //echo "<script>alert('asdfas')</script>";
                            $model = get_vendor_login($username, $pass);
                            
                            $count = mysql_num_rows($model);
                            $menu_arr   = array();
                            $access_arr = array();
                            
                            if ($count > 0){
                                
                                $log = mysql_fetch_array($model);
                                //$tgl_sekarang = date("Ymd");
                                //$ip = $_SERVER['REMOTE_ADDR'];
            
                                include "lib/timeout.php";
                                include "lib/library.php";

                                $_SESSION['id_user']        = $log['id_user'];
                                $_SESSION['username']       = $log['username'];
                                $_SESSION['nm_user']        = $log['nm_user'];
                                $_SESSION['nm_vendor']      = $log['nm_vendor'];
                                $_SESSION['role']           = $log['role'];
                                $_SESSION['nm_tipe_user']   = $log['nm_tipe_user'];
                                
                                //get user's menu group
                                $get_menu_group = get_menu_group_by_id_user($log['id_user']);
                                while ($row = mysql_fetch_assoc($get_menu_group)) {
                                    array_push($menu_arr, $row['menu_group_object']);	
                                }
                                $_SESSION['menu_group']   = $menu_arr; 
                                

                                 //get user's access group
                                $get_acccess_group = get_access_group_by_id_user($log['id_user']);
                                while ($row = mysql_fetch_assoc($get_acccess_group)) {
                                    array_push($access_arr, $row['menu_object']);	
                                }
                                $_SESSION['access_group']   = $access_arr; 

                                // session timeout
                                $_SESSION['login'] = 1;
                                timer();
                                $sid_old = session_id();
                                session_regenerate_id();
                                $sid_new = session_id();
                                
                                //mysql_query("UPDATE user SET id_session='$sid_new' WHERE username='$username' AND id_user='".$_SESSION['id_user']."'");
                                set_login($sid_new, $username, $_SESSION['id_user']);
                                insert_user_log($_SESSION['id_user'], $ip, 'S', 'in' ,'');

                                //header('location:home.php?mnu=home');
                                header('location:home.php?'.token().'mnu=home'.token2().'');

                                

                            }else{
                                /*
                                $query = "SELECT * FROM user u JOIN tipe_user t on u.id_tipe_user = t.id_tipe_user WHERE username='$username' AND password='$pass'";
                                $model = mysql_query($query);
                                */
                                $model = get_user_login($username, $pass);
                                $count = mysql_num_rows($model);

                                $menu_arr   = array();
                                $access_arr = array();

                                if ($count > 0){
                                    $log = mysql_fetch_array($model);
                                    //$tgl_sekarang = date("Ymd");
                                    //$ip = $_SERVER['REMOTE_ADDR'];
            
                                    include "lib/timeout.php";
                                    include "lib/library.php";

                                    $_SESSION['id_user']        = $log['id_user'];
                                    $_SESSION['username']       = $log['username'];
                                    $_SESSION['nm_user']        = $log['nm_user'];
                                    $_SESSION['role']           = $log['role'];
                                    $_SESSION['nm_tipe_user']   = $log['nm_tipe_user'];
                                    
                                    //get user's menu group
                                    $get_menu_group = get_menu_group_by_id_user($log['id_user']);
                                    while ($row = mysql_fetch_assoc($get_menu_group)) {
                                        array_push($menu_arr, $row['menu_group_object']);	
                                    }
                                    $_SESSION['menu_group']   = $menu_arr; 
                                    
                                    //get user's access group
                                    $get_acccess_group = get_access_group_by_id_user($log['id_user']);
                                    while ($row = mysql_fetch_assoc($get_acccess_group)) {
                                        array_push($access_arr, $row['menu_object']);	
                                    }
                                    $_SESSION['access_group']   = $access_arr; 

                                    // session timeout
                                    $_SESSION['login'] = 1;
                                    timer();
                                    $sid_old = session_id();
                                    session_regenerate_id();
                                    $sid_new = session_id();

                                    //mysql_query("UPDATE user SET id_session='$sid_new' WHERE username='$username' AND id_user='".$_SESSION['id_user']."'");
                                    set_login($sid_new, $username, $_SESSION['id_user']);
                                    insert_user_log($_SESSION['id_user']  , $ip, 'S', 'in','');

                                    header('location:home.php?'.token().'mnu=home'.token2().'');
                                }
                                else
                                {
                                    //insert_user_login($_SESSION['id_user'], $ip, 'F');
                                    insert_user_log('', $ip, 'F', 'in', $username);
                                    echo
                                    '   
                                    <br>
                                    <div class="callout callout-danger alert-dismissable">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                        <medium><i class="fa fa-warning"></i> Wrong Username or Password!</medium>
                                        
                                    </div>
                                    ';

                                }//if ($count > 0)

                            }//ELSE OF if ($count > 0)
    
                        }//if (!ctype_alnum($username) OR !ctype_alnum($pass))

                    }//if (isset($_POST['login'])){

					?>
					
					<label >USERNAME</label>
					 <div class="form-group has-feedback">
						<input type="text" id="username" placeholder="Username" class="form-control"  name="username" required/>
						<!--
						<span class="glyphicon glyphicon-user form-control-feedback"></span>
						-->
					  </div>
					  
					  <label >PASSWORD</label>
					  <div class="form-group has-feedback">
						<input type="password" id="password" name="password" class="form-control" placeholder="Password" required/>
						<!--
						<span class="glyphicon glyphicon-lock form-control-feedback"></span>
						-->
					  </div>
				
					 <div class="container-login100-form-btn">
						<button class="login100-form-btn" type="submit" id="login" name='login'>
							Login
						</button>
					</div>
					
					
				</form>

                <!--
				<div class="login100-more" style="background-image: url('../assets/login/images/bg-01.jpg');">
				</div>
				-->

                <div class="login100-more animated fade-in" style="background-image: url('../assets/login/images/bg-01.jpg');">
                </div>

                <div class="login100-more w3-animate-opacity" style="background-image: url('../assets/login/images/bg-04.jpg');">
                </div>

                <div class="login100-more animated fade-in" style="background-image: url('../assets/login/images/bg-06.jpg');">
                </div>

                <div class="login100-more w3-animate-opacity" style="background-image: url('../assets/login/images/bg-05.jpg');">
                </div>
				
			</div> <!-- wrap -->
			
		</div> <!-- container -->
		
	</div> <!-- limiter -->
	

	
<!--===============================================================================================-->
	<script src="../jquery-2/jquery.min.js"></script>
<!--===============================================================================================-->
	<script src="../assets/login/vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="../assets/login/vendor/bootstrap/js/popper.js"></script>
	<script src="../assets/login/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="../assets/login/vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="../assets/login/vendor/daterangepicker/moment.min.js"></script>
	<script src="../assets/login/vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="../assets/login/vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="../assets/login/js/main.js"></script>
	
	<script src="../js/bootstrap.min.js" type="text/javascript"></script>
	
	<script src="../js/jquery-ui-1.10.3.min.js" type="text/javascript"></script>
	
	 <script>
            function myLoader(){

                swal({
                    title: 'Finding your information',
                    text: 'Please wait...',
                    allowOutsideClick: false,
                    onOpen: function () {
                        swal.showLoading()
                    }
                })

            }

        </script>

        <script>
            var myIndex = 0;
            carousel();

            function carousel() {
                var i;
                var x = document.getElementsByClassName("login100-more");
                for (i = 0; i < x.length; i++) {
                    x[i].style.display = "none";
                }
                myIndex++;
                if (myIndex > x.length) {myIndex = 1}
                x[myIndex-1].style.display = "block";
                setTimeout(carousel, 10000);
            }
        </script>

</body>
</html>