<?php
    include "data-model/my-query.php";
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>AdminLTE | Dashboard</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->
        <link href="../../css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="../../css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="../../css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="../../css/AdminLTE.css" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="skin-black">
       
        <!-- MENU CONTROL
            #MENU TOP
            #MENU SIDE
        -->

        <?php include "menu/side-menu.php";?>
        <?php include "menu/top-menu.php";?>

        <div class="wrapper row-offcanvas row-offcanvas-left">

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">

            <?php           
            //TAG PHP
                $id_register = $_GET['id_reg'];
                $query_exec = get_vendor_register_by_id($id_register);
                $row = mysqli_fetch_assoc($query_exec);
            
            ?> 

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <!-- left column -->
                        <div class="col-xs-12">
                            <!-- general form elements -->
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">Vendor Data for "<?php echo $row['vendor_nm']; ?>"</h3>
                                </div><!-- /.box-header -->
                                <!-- form start  update vendor registration stat and add new vendor master data-->
                                <form role="form" action="../control/approve_vendor_reg.php" method="post" enctype="multipart/form-data">
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">SAP ID Vendor</label>
                                            <input type="text" class="form-control" id="id_vendor" name="id_vendor" value="" autofocus required>
                                        </div>
										<div class="form-group">
                                            <label for="exampleInputEmail1">Vendor Name</label>
                                            <input type="text" class="form-control" id="vendor_nm" name="vendor_nm"  value="<?php echo $row['vendor_nm']; ?>" readonly="readonly">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Vendor Name Allias</label>
                                            <input type="text" class="form-control" id="allias" name="allias"  placeholder="(ex. Dharma Electrindo Mfg = DEM)" required>
                                        </div>
										<div class="form-group">
                                            <label for="exampleInputEmail1">Sales Person-1</label>
                                            <input type="text" class="form-control" id="sales_person_1" name="sales_person_1"  value="<?php echo   $row['sales_person']; ?>" readonly="readonly">
                                        </div>
										<div class="form-group">
                                            <label for="exampleInputEmail1">Telephone</label>
                                            <input type="text" class="form-control" id="contact_num" name="contact_num" value="<?php echo $row['contact_num']; ?>" readonly="readonly">
                                        </div>
										<div class="form-group">
                                            <label for="exampleInputEmail1">Email</label>
                                            <input type="email" class="form-control" id="mail" name="mail" value="<?php echo $row['mail']; ?>" readonly="readonly">
                                            <input type="hidden" class="form-control" id="id_register" name="id_register"  value="<?php echo $row['id_register']; ?>">
                                        </div>
                                    </div><!-- /.box-body -->

                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-success btn-flat"><i class="fa fa-check"></i> Approve</button>
                                    </div>
                                </form>
                            </div><!-- /.box -->			

                                   
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                </div><!--/.col (right) -->
            </div>   <!-- /.row -->
            </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->
        
        <script>alert('Please create SAP Master Data and input ID Vendor for this Vendor!');</script>


        <!-- jQuery 2.0.2 
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
        -->
        <script src="../../jquery-2/jquery.min.js"></script>
        <!-- jQuery UI 1.10.3 -->
        <script src="../../js/jquery-ui-1.10.3.min.js" type="text/javascript"></script>
        <!-- Bootstrap -->
        <script src="../../js/bootstrap.min.js" type="text/javascript"></script>
        <!-- Morris.js charts 
        <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
        -->
        <script src="../../css/raphael/raphael-min.js"></script>
        <script src="../../js/plugins/morris/morris.min.js" type="text/javascript"></script>
        <!-- Sparkline -->
        <script src="../../js/plugins/sparkline/jquery.sparkline.min.js" type="text/javascript"></script>
        <!-- jvectormap -->
        <script src="../../js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js" type="text/javascript"></script>
        <script src="../../js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script>
        <!-- fullCalendar -->
        <script src="../../js/plugins/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
        <!-- jQuery Knob Chart -->
        <script src="../../js/plugins/jqueryKnob/jquery.knob.js" type="text/javascript"></script>
        <!-- daterangepicker -->
        <script src="../../js/plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
        <!-- Bootstrap WYSIHTML5 -->
        <script src="../../js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
        <!-- iCheck -->
        <script src="../../js/plugins/iCheck/icheck.min.js" type="text/javascript"></script>

        <!-- AdminLTE App -->
        <script src="../../js/AdminLTE/app.js" type="text/javascript"></script>
        
        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
        <script src="../../js/AdminLTE/dashboard.js" type="text/javascript"></script>
    </body>
</html>