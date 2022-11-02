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
                $foreign_id = "210000";
                //$foreign_id = $_GET['foreign_id'];
                $query_exec = get_vendor_by_id($foreign_id);
                $row = mysqli_fetch_assoc($query_exec);
            
            ?> 
                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <!-- left column -->
                        <div class="col-xs-12">
                            <!-- general form elements -->
                            <div class="box">
                                <!-- form start -->
                                
                                    <div class="box-body">
                                        
                                        <?php
                                            include("vm/preview-rpt.php");
                                        ?>

                                    </div><!-- /.box-body -->                               
                            </div><!-- /.box -->
							
							
                            

                                   
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                </div><!--/.col (right) -->
            </div>   <!-- /.row -->
            </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->
        <!-- jQuery 2.0.2 
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
        -->
        <script src="../../jquery-2/jquery.min.js"></script>
        <!-- Bootstrap -->
        <script src="../../js/bootstrap.min.js" type="text/javascript"></script>
        <!-- AdminLTE App -->
        <script src="../../js/AdminLTE/app.js" type="text/javascript"></script>
    </body>
</html>