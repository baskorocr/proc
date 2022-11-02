<?php

    include_once "registration/master-data-query.php";
    require "lib/ip-detect.php";
    include "lib/function.php";

?>
<!DOCTYPE html>
<html class="lockscreen">
    <head>
        <meta charset="UTF-8">
        <title>eProc Dharma Polimetal</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->
        <link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="../css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="../css/AdminLTE.css" rel="stylesheet" type="text/css" />

        <!-- sweet alert -->
        <!--
        <link href="../css/sweet-alert.css" rel="stylesheet" type="text/css" />
        -->
        <script src="../js/sweet-alert/sweetalert.min.js" type="text/javascript"></script>

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
        <link rel="icon" type="image/x-icon" href="../img/favicon3.png" />
    </head>
    <body>

        <div class="form-box" id="login-box" style = "margin-top: 12%;">
            
            <form role=form name="Form1" id="Form1" onSubmit="return myLoader()" action="" method="post">
                <div class="box no-border"> <!-- body bg-white-->
                <br>
                <center><img src="../img/logo.png" style="width: 35%;"></center>
                    <div class="box-body">
                        <hr style="margin-bottom: -10px; margin-top: 8px;">
                    </div>

                <div class="box-body" style="margin-left: 15px; margin-right: 15px;">

                <?php

                    if (isset($_POST['login'])){

                        session_start();
                        //require "conn/conn.php";
                        //get_connection();
                        $ip         = ip_detect();
                        function anti_injection($data){
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

                            $model = get_vendor_login($username, $pass);
                            /*
                            $query = "SELECT * FROM user u
                                    JOIN vendor v ON u.id_user=v.id_user
                                    JOIN tipe_user t on u.id_tipe_user = t.id_tipe_user WHERE username='$username' AND password='$pass'";
                            */
                            //$model = mysql_query($query);
                            $count = mysql_num_rows($model);
                            
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
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" id="username" name="username" class="form-control" placeholder="Username" required/>
                    </div><!-- /.form group -->

                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" id="password" name="password" class="form-control" placeholder="Password" required/>
                    </div><!-- /.form group -->
                </div>

                <div class="footer" style="margin-top: -10px;">
                    <button type="submit" id="login" name='login' class="btn bg-blue btn-block btn-flat">Login</button>
                    <!--
                    <a href="registration.php" class="text-center">Register a new membership</a>
                    -->
                </div>
               
            </form>
        </div>


        <!-- jQuery 2.0.2 
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
		-->
		<script src="../jquery-2/jquery.min.js"></script>
        <!-- Bootstrap -->
        <script src="../js/bootstrap.min.js" type="text/javascript"></script>

        <!-- jQuery UI 1.10.3 -->
        <script src="../js/jquery-ui-1.10.3.min.js" type="text/javascript"></script>

        <!-- Bootstrap WYSIHTML5 -->
        <!--
        <script src="../js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
        -->
        <!-- Bootstrap -->
        <script src="../js/bootstrap.min.js" type="text/javascript"></script>

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

    </body>
</html>


