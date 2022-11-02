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

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
        <link rel="icon" type="image/x-icon" href="../img/favicon3.png" />
    </head>
    <body>

        <div class="form-box" style="margin-top:4%;">

            <form action="control/add_vendor_reg.php" method="post" enctype="multipart/form-data">
                <div class="box"> <!-- body bg-white-->
                </br>
                
                <div class="box-body" style="margin-left: 15px; margin-right: 15px;">
				    <center><img src="../img/logo.png"  style="width: 40%; "></center></br>

					    <div class="form-group">
                            <label>Vendor name</label>
                            <input type="text" id="vendor_nm" name="vendor_nm" class="form-control" placeholder="Your Company, PT." required/>
                        </div><!-- /.form group -->
					
					   <div class="form-group">
                            <label>Sales Person</label>
                            <input type="text" id="sales_person" name="sales_person" class="form-control" placeholder="Sales person name (Mr/Ms)" required/>
                        </div>

					   <div class="form-group">
                            <label>Contact Number</label>
                            <input type="text" id="contact_num" name="contact_num" class="form-control" placeholder="+6221 0987 665" required/>
                        </div><!-- /.form group -->
					
					   <div class="form-group">
                            <label>Email</label>
                                <input type="email" id="mail" name="mail" class="form-control" placeholder="your_mail@domain.com" required/>
                        </div><!-- /.form group -->
					
                </div>
                
                <div class="footer">                    
                    <button type="submit" class="btn bg-blue btn-block btn-flat">Register Now</button>
                    <a href="login.php" class="text-center">I already have a membership</a>
                </div>

                </div>
            </form>

        </div>


        <!-- jQuery 2.0.2
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
		 -->
		<script src="../jquery-2/jquery.min.js"></script>
        <!-- Bootstrap -->
        <script src="../js/bootstrap.min.js" type="text/javascript"></script>

    </body>
</html>