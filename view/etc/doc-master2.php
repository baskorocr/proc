<?php
    include "data-model/query.php";
?>

<div class="box-header">
    <h3 class="box-title">Document Master</h3>   

    <div class="pull-right box-tools">
        <!-- button with a dropdown -->
        <div class="btn-group">
            <a href="#" class="text-muted" data-toggle="dropdown"><i class="fa fa-gear"></i></a>
            <ul class="dropdown-menu pull-right" role="menu">
                <li><a href="home.php?mnu=prodmstrupld"><i class="fa fa-upload"></i>Upload Document</a></li>
                <li><a href="#addModal" data-toggle="modal" data-backdrop="static" data-keyboard="false">
                    <i class="fa fa-plus-square"></i>Add Document</a>
                </li>
            </ul>
        </div>
    </div><!-- /. tools -->   

</div><!-- /.box-header -->

<div class="box-body table-responsive">                        
    <table id="example2" class="table table-bordered table-striped table-hover">                      
                                
        <thead>
            <tr>
                <th>#</th>
                <th>ID Doc</th>
                <th>Doc Name</th>
                <th>Last Change Date</th>
                <th>Last Change By</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody> 
            <tr>
                <td>1</td>
                <td>DOC000001</td>
                <td>QIS</td>
                <td>08.08.2017</td>
                <td>HIDRIAN</td>
                <td><small class='label label-success'> Active</small></td>
                <td align="center">
                    <button class='btn-flat btn-primary'><i class='fa fa-pencil'></i> Edit</button>
                    <button class='btn-flat btn-danger'><i class='fa fa-trash-o'></i> Delete</button>
                </td>
            </tr>
            <tr>
                <td>2</td>
                <td>DOC000002</td>
                <td>DRAWING</td>
                <td>08.09.2017</td>
                <td>HIDRIAN</td>
                <td><small class='label label-success'> Active</small></td>
                <td align="center">
                    <button class='btn-flat btn-primary'><i class='fa fa-pencil'></i> Edit</button>
                    <button class='btn-flat btn-danger'><i class='fa fa-trash-o'></i> Delete</button>
                </td>
            </tr>
                                  
           <?php
                //PHP TAG
                /*
                $no =1;
                $query_exec = get_all_vendor_data();

                while ($row = mysql_fetch_assoc($query_exec)) {
                    echo "    <tr>";
                    echo "        <td>".$no++."</td>";
                    echo "        <td>".$row['id_vendor']."</td>";
                    echo "        <td>".$row['vendor_nm']."</td>";
                    echo "        <td>".$row['vendor_nm']."</td>";
                    echo "        <td>".$row['vendor_nm']."</td>";
                    echo "        <td align='center'><small class='label label-success'> New Project</small></td>"; //label-danger if not active
                    echo "        <td>
                                    <a href='vendor-registration-approval.php?id_reg=".$row['id_register']."' class='btn btn-flat btn-sm btn-primary' data-toggle='tooltip' title='approve'>
                                    <i class='fa fa-pencil  '></i></a>
                                    
                                    <a href='vendor-registration-approval.php?id_reg=".$row['id_register']."' class='btn btn-flat btn-sm btn-danger' data-toggle='tooltip' title='delete'>
                                    <i class='fa fa-trash-o'></i></a>
                                  </td>";
                    echo "    </tr>";
                    
                }   
                */
            ?>                               
        </tbody>
    </table>
</div><!-- /.box-body -->
                        
<div class="container">
  
  <!-- UPLOAD MODAL -->
  <div class="modal fade" id="addModal" role="dialog">
    <div class="modal-dialog">
    
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Assignment >> Create Project</h4>
            </div>
            <div class="modal-body">
                <form role=form name="myForm" id="myForm" onSubmit="return validateForm()" action="home.php?mnu=crproj" method="post" enctype="multipart/form-data">
                    
                    <!--
                    <div class="col-lg-10">

                    </div>
                    -->

                    <div class="form-group">
                        <label>Nama Project</label>
                        <input type="text" class="form-control" id="project_nm" name="project_nm" placeholder="Project Name">
                    </div>
                    
                    <div class="form-group">
                         <label class="control-label">Opsi Project</label>
                         <select name="project_stat" class="form-control selectpicker" data-live-search="true">
                            <option>NEW PROJECT</option>
                            <option>MASS PRO</option>
                            <option>MULTI SOURCING</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Status Project</label>
                        <select  multiple  class="form-control selectpicker" name="project_stat" data-live-search="true">
                            <option>NEW PROJECT</option>
                            <option>MASS PRO</option>
                            <option>MULTI SOURCING</option>
                        </select>
                    </div>
        
                </form>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-check"></i> Confirm</button>
            </div>
        </div>
      
    </div>
  </div>
  
</div>
        
        <!-- jQuery 2.0.2 -->
        <script src="../jquery/jquery.min.js"></script>
        <!-- Bootstrap -->
        <script src="../js/bootstrap.min.js" type="text/javascript"></script>
        <!-- DATA TABES SCRIPT -->
        <script src="../js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
        <script src="../js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
        <!-- AdminLTE App -->
        <script src="../js/AdminLTE/app.js" type="text/javascript"></script>

        <!-- page script -->
        <script type="text/javascript">
            $(function() {
                $("#example1").dataTable();
                $('#example2').dataTable({
                    "bPaginate": true,
                    "bLengthChange": true,
                    "bFilter": true,
                    "bSort": true,
                    "bInfo": true,
                    "bAutoWidth": false
                });
            });
        </script>

    </body>
</html>