<?php
    include "data-model/my-query.php";
?>

<div class="box-header">
    <h3 class="box-title">Document Part</h3>   

    <div class="pull-right box-tools">
        <!-- button with a dropdown -->
        <div class="btn-group">
            <a href="#" class="text-muted" data-toggle="dropdown"><i class="fa fa-gear"></i></a>
            <ul class="dropdown-menu pull-right" role="menu">
                <li><a href="home.php?mnu=newass"><i class="fa fa-plus-square"></i>Create Document</a></li>
            </ul>
        </div>
    </div><!-- /. tools -->   

</div><!-- /.box-header -->


<form role=form name="myForm" id="myForm" onSubmit="return validateForm()" action="home.php?mnu=crproj" method="post" enctype="multipart/form-data">

    <div class="box-body">
       
        <!-- select -->
        <div class="form-group">
            <label>Nama Part</label>
            <select class="form-control" name="project_stat">
                <option>xcv8r2</option>
                <option>asdmas902</option>
                <option>anala928</option>
            </select>
        </div>


    <div class="box-body table-responsive">                        
        <table id="example2" class="table table-bordered table-striped table-hover">                      
                                    
            <thead>
                <tr>
                    <th>#</th>
                    <th>Check</th>
                    <th>Document</th>
                </tr>
            </thead>
            <tbody>                            
                <tr>
                    <td>1</td>
                    <td><input type="checkbox"/></td>
                    <td>QIS</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td><input type="checkbox"/></td>
                    <td>Drawing</td>
                </tr>  
            </tbody>
        </table>
    </div>


    </div><!-- /.box-body -->

    <div class="box-footer">
        <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Confirm</button>
    </div>
        
</form>
                        

        
        <!-- jQuery 2.0.2 -->
        <script src="../jquery/jquery.min.js"></script>
        <!-- Bootstrap -->
        <script src="../js/bootstrap.min.js" type="text/javascript"></script>
        <!-- DATA TABES SCRIPT -->
        <script src="../js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
        <script src="../js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
        <!-- AdminLTE App -->
        <script src="../js/AdminLTE/app.js" type="text/javascript"></script>

    </body>
</html>