<?php

//include "../conn/connection.php";
include "master-data-query.php";

?>
           
<div class="box-header">
	<h3 class="box-title">Change Password</h3>
</div>
<hr style="margin-top: 1px;">

    <div class="alert alert-info alert-dismissable">
        <i class="fa fa-info"></i>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <b>Alert!</b> If you need to change your password, please do so below. You will need to enter your current password in order to change it.
    </div>

<?php

    $id_user = $_SESSION['id_user'];

    $query_exec2 = get_user_data_by_id($id_user);
    
        while ($row2 = mysql_fetch_assoc($query_exec2)) {
           
            $nm_user        = $row2['nm_user'];
            $id_tipe_user   = $row2['id_tipe_user'];
            $status_user    = $row2['status_user'];
            $username       = $row2['username'];

?>
    <form role=form name="myForm" id="myForm" onSubmit="return validateForm()" action="" method="post" enctype="multipart/form-data">
        
        <div class="box-body">                            
            
            <input type="hidden" id="id_user" name="id_user" value ="<?php echo  $id_user; ?>">


            <?php

            if (isset($_POST['edit-pass'])) {
				
				/*
                function anti_injection($data){
                    $filter = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
                    return $filter;
                }
				*/
				
				//changed by HOS.03.09.2020
				function anti_injection($data){
						  get_connection();
                          $filter = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
                          return $filter;
                        }
				//end of change
				
                $id_user = $_POST['id_user'];
                $sent_pass      = anti_injection(md5($_POST['curr-pass']));
                $new_pass       = $_POST['new-pass'];
                $conf_pass      = $_POST['conf-pass'];

                $query_exec    = get_user_data_by_id($id_user);
                $row           = mysql_fetch_assoc($query_exec);
                $curr_pass     = $row['password'];
                $uname         = $row['username'];

                //check if password inputed are correct as in database
                if ($sent_pass == $curr_pass) {

                    //check if new confirm password inputed are correct as new password AND length >= 5
                    if ($new_pass == $conf_pass AND strlen($conf_pass) >= 5){

                        if($curr_pass == anti_injection(md5($conf_pass))){

                             echo '
                                <div class="callout callout-danger alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <medium><i class="fa fa-warning"></i> Please input brand new password!</medium>
                                </div> 
                            ';

                        } elseif ($curr_pass != anti_injection(md5($conf_pass))){

                            update_password($id_user, $uname, $conf_pass);
                            /*
                            echo "
                                    <script>alert('Success change password!\\rYou will be logged out first.');</script>
                                    <script>window.location=('../view/logout.php')</script>
                            ";
                            */

                            echo '
                                <script>
                                swal({
                                    title: "Success!",
                                    text: "Success change password! You will be logged out first.",
                                    type: "success",
                                    customClass: \'swal-wide\',
                                    allowOutsideClick: false
                                })
                                    .then(function() {
                                    window.location = (\'../view/logout.php\');
                                });
                                
                                </script>
                            ';

                        }
                        
                    //check if new confirm password inputed are correct as new password AND length < 5
                    } elseif ($new_pass == $conf_pass AND strlen($conf_pass) < 5){

                        echo '
                        <div class="callout callout-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <medium><i class="fa fa-warning"></i> Password minimum 5 character!</medium>
                        </div> 
                        ';

                    //check if new confirm password inputed are incorrect as new password
                    } elseif ($new_pass != $conf_pass) {
                        
                        echo '
                        <div class="callout callout-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <medium><i class="fa fa-warning"></i> Please check new password!</medium>
                        </div> 
                        ';

                    }

                //check if password inputed are incorrect as in database
                } elseif ($sent_pass != $curr_pass) {

                    echo '
                        <div class="callout callout-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <medium><i class="fa fa-warning"></i> Wrong password!</medium>
                        </div> 
                    ';
                }
            
            }

        ?>

            <div class="form-group">
                <label>Login Username</label>
                <input type="text" class="form-control" id="nm_user" name="username" value="<?php echo $username; ?>" required disabled> 
            </div>

            <div class="form-group">
            <label>Current Password</label>
                <div class="form-group input-group input-group-sm">
                    <input  type="password" class="form-control" id="curr-pass" name="curr-pass" data-toggle='password' placeholder="Current password" required focused>

                    <span class="input-group-btn">
                        <button type="button" id="show" class="btn btn-flat bg-blue" data-toggle='tooltip' title="show" onclick="showPass()"><i class="ion ion-eye" style="color: #fff;"></i>
                        </button>
                        <button type="button" style="display:none" id="hide" class="btn btn-flat bg-blue" data-toggle='tooltip' title="hide" onclick="hidePass()"><i class="ion ion-eye-disabled" style="color: #fff;"></i>
                        </button>
                    </span>
                </div>    
            </div>                                                                    
                
            <div class="form-group">
                <label>New Password</label>
                <input type = "password" class="form-control" id="new-pass" name ="new-pass" placeholder="New password" required> 
            </div>

            <div class="form-group">
                <label>Confirm New Password</label>
                <input type = "password" class="form-control" id="conf-pass" name ="conf-pass" placeholder="Confirm password" data-toggle='password' required> 
            </div> 

            <div class="form-group">
                <span id='message'></span>
            </div>                                                                 
    
    	</div><!-- /.box-body -->

        	<div class="box-footer">
        	    <button type="submit" id="edit-pass" name="edit-pass" class="btn btn-primary"><i class="fa fa-lock"></i>&nbsp; Change</button>
        	</div>
    </form>

    <?php

        }
    ?>

<!-- jQuery 2.0.2 -->
<script src="../jquery-2/jquery.min.js"></script>

<!-- Bootstrap -->
<script src="../js/bootstrap.min.js" type="text/javascript"></script>
<!-- AdminLTE App -->
<script src="../js/AdminLTE/app.js" type="text/javascript"></script>

    <script>
        $('#new-pass, #conf-pass').on('keyup', function () {
            if ($('#new-pass').val() == $('#conf-pass').val() && ($('#new-pass').val() != "" || $('#conf-pass').val() != "")) {

                $('#message').html('<i class="fa fa-check-circle-o"></i> Match').css('color', 'green');
                document.getElementById("edit-pass").disabled = false;

            } else if ($('#new-pass').val() != $('#conf-pass').val() && ($('#new-pass').val() != "" || $('#conf-pass').val() != ""))  {

                $('#message').html('<i class="fa fa-exclamation-circle"></i> Not Match').css('color', 'red');
                document.getElementById("edit-pass").disabled = true;

            } else {

                $('#message').html('').css('color', 'red');
            }
        });
    </script> 


    <script type="text/javascript">
        
        function showPass()
        {
            if(document.getElementById("curr-pass").value!="")
            {
                document.getElementById("curr-pass").type="text";
                document.getElementById("show").style.display="none";
                document.getElementById("hide").style.display="block";
            }
        }

        function hidePass()
        {
            if(document.getElementById("curr-pass").type == "text")
            {
                document.getElementById("curr-pass").type="password"
                document.getElementById("show").style.display="block";
                document.getElementById("hide").style.display="none";
            }
        }

    </script>


    </body>
</html>