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
                                <div class="box-header">
                                    <h3 class="box-title"> Your Company Data</h3>
                                </div><!-- /.box-header -->
                                <!-- form start -->
                                <form role="form">
                                    <div class="box-body">
                                        
                                            <!--<label for="exampleInputEmail1">Id Vendor</label>-->
                                            <input type="hidden" class="form-control" id="id_vendor" name="id_vendor" value="<?php echo $row['id_vendor']; ?>" readonly>
                                        
										<div class="form-group">
                                            <label for="exampleInputEmail1">Company Name</label>
                                            <input type="text" class="form-control" id="vendor_nm" name="vendor_nm" value="<?php echo $row['vendor_nm']; ?>">
                                        </div>
										<div class="form-group">
                                            <label for="exampleInputEmail1">Sales Person-1</label>
                                            <input type="text" class="form-control" id="sales_person_1" name="sales_person_1" placeholder="Your name (Mr./Mss.)" value="<?php echo $row['sales_person_1']; ?>" required>
                                        </div>
										<div class="form-group">
                                            <label for="exampleInputEmail1">Sales Person-2 (If exsisted)</label>
                                            <input type="text" class="form-control" id="sales_person_2" name="sales_person_2"  placeholder="Your name (Mr./Mss.)" value="<?php echo $row['sales_person_2']; ?>">
                                        </div>
										<div class="form-group">
                                            <label for="exampleInputEmail1">Telephone</label>
                                            <input type="text" class="form-control" id="contact_num" name="contact_num"  placeholder="Contact number (ex. +6281 98120 12098)" value="<?php echo $row['contact_num']; ?>" required>
                                        </div>
										<div class="form-group">
                                            <label for="exampleInputEmail1">Email</label>
                                            <input type="email" class="form-control" id="mail" name="mail"  placeholder="(ex. your_email@domain.com)" value="<?php echo $row['mail']; ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Street</label>
                                            <input type="text" class="form-control" id="street" name="street"  placeholder="Ex. Jln. Angasana Raya Blok A9 No 8 Delta Silicon I" value="<?php echo $row['street']; ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">City</label>
                                            <input type="text" class="form-control" id="city" name="city"  placeholder="Ex. Cikarang" value="<?php echo $row['city']; ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Post Code</label>
                                            <input type="text" class="form-control" id="postcode" name="post_code"  placeholder="Ex. 51336" value="<?php echo $row['postcode']; ?>" required>
                                        </div>
                                    </div><!-- /.box-body -->

                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-save"></i>  Save</button>
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