<?php
    include "data-model/my-query.php";
?>

        
        <h3 class="box-title">Vendor Registration List</h3>
                        
            <div class="input-group">
                <input type="text" name="table_search" class="form-control input-sm pull-right" style="width: 150px; margin-top: 20px;" placeholder="Search"/>
                    <div class="input-group-btn">
                        <button class="btn btn-sm btn-default" style="margin-top: 20px; margin-right: 10px;"><i class="fa fa-search"></i></button>
                    </div>
            </div>                        
                                    
                                       
            <div class="box-body table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Vendor Name</th>
                        <th>Sales Person</th>
                        <th>Contact Number</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>                     
                    </thead>
                    <tbody>       
                    <?php
                                //PHP TAG

                                    $query_exec = get_vendor_reg();
                                    
                                    $no=1;
                            
                                    while ($row = mysqli_fetch_assoc($query_exec)) {
                                
                                        echo "<tr>";
                                        echo "    <td>".$no."</td>";
                                        echo "    <td>".$row['vendor_nm']."</td>";
                                        echo "    <td>".$row['sales_person']."</td>";
                                        echo "    <td>".$row['contact_num']."</td>";
                                        echo "    <td>".$row['mail']."</td>";
                                        echo "    <td>
                                                        <a href='vendor-registration-approval.php?id_reg=".$row['id_register']."' class='btn btn-flat btn-sm btn-success' data-toggle='tooltip' title='approve'>
                                                        <i class='fa fa-check'></i></a>
                                                        <a href='vendor-registration-approval.php?id_reg=".$row['id_register']."' class='btn btn-flat btn-sm btn-danger' data-toggle='tooltip' title='delete'>
                                                        <i class='fa fa-trash-o'></i></a>
                                                  </td>";
                                        echo "</tr>";
                                
                                        $no++;

                                    }   
                                ?>              
                    </tbody>  
                </table>
                                   
                </div>

        <!-- jQuery 2.0.2
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
         -->
        <script src="../../jquery-2/jquery.min.js"></script>
        <!-- Bootstrap -->
        <script src="../../js/bootstrap.min.js" type="text/javascript"></script>
        <!-- DATA TABES SCRIPT -->
        <script src="../../js/plugins/datatables-2/jquery.dataTables.js" type="text/javascript"></script>
        <script src="../../js/plugins/datatables-2/dataTables.bootstrap.js" type="text/javascript"></script>
        <!-- AdminLTE App -->
        <script src="../../js/AdminLTE/app.js" type="text/javascript"></script>

       