<?php
/**
 * Copyright (c) 2017. Don't copy or use the source code without author permission for comercial purpose(s)
 */

    include "project-mgt-query.php";
    include "project-mgt-func.php";
    include "../lib/function.php";
    include_once "../conn/conn.php";
?>

<div class="box-header">
    <h3 class="box-title">Modify Document Check List Parameters</h3>

    <div class="pull-right box-tools">
        <!-- button with a dropdown -->
        <div class="btn-group">
            <a href="#" data-toggle="dropdown"><i class="fa fa-bars"></i></a>
            <ul class="dropdown-menu pull-right" role="menu">
                <li><a href="home.php?<?php echo token(); ?>mnu=listcheckmaster<?php echo token2(); ?>"><i class="fa fa-table"></i>Doc List Check Data</a></li>
            </ul>
        </div>
    </div><!-- /. tools -->   
</div><!-- /.box-header -->
<hr style="margin-top: 1px;">

<form role=form name="myForm" id="myForm" onSubmit="return validateForm()" action="" method="post" enctype="multipart/form-data">

    <div class="box-body">

        <!-- select -->
       <div class="form-group">
            <label>Choose Document</label>
                <select class="form-control selectpicker" name="id_doc" data-live-search="true" required>
                    <?php
                                    
                        $query_exec1 =  get_all_doc_data();

                        while ($row1 = mysqli_fetch_assoc($query_exec1)) {
                            $tp = $row1['doc_type'];
                            $rq = $row1['doc_required'];

                            if ($rq == "M") {
                                $req = "Mandatory style='color: #00cc00;'";
                            } elseif ($rq == "Y"){
                                $req = "Required";
                            } elseif ($rq == "N"){
                                $req = "Not-required style='color: #ff8000;'";
                            }

                            echo "<option data-subtext=".$tp."-".$req." required value=".$row1['id_doc_part'].">".$row1['nm_doc_part']."</option>";
                        }
                                    
                    ?>
                </select>
                <button type="submit" id="view-data" name="view-data" class="btn btn-success btn-flat"><i class="fa fa-search"></i> View</button>
       </div>
    </div><!-- /.box-body -->
</form>

<form role=form name="myForm1" id="myForm1" onSubmit="return validateForm()" action="" method="post" enctype="multipart/form-data">
<?php

    if(isset($_POST['view-data'])){

        $id_doc_part = $_POST['id_doc'];
?>

<div class="box box-primary">
    <div class="box-header">
        <?php
            $query_exec2 = get_all_check_doc_data_by_id2($id_doc_part);
            $row1 = mysqli_fetch_assoc($query_exec2);
        ?>
        <h3 class="box-title">
            <?php echo $row1['nm_doc_part'];?>
        </h3>
        <div class="box-tools pull-right">
            <a class="btn btn-default" data-widget="collapse" data-toggle="collapse" data-target="#body-collapse"><i class="fa fa-minus"></i></a>
        </div>
    </div>

        <div class="box-body">
            <hr style="margin-top: 5px;">
        </div>
    <div id="body-collapse">
        <input type="hidden" name="id_doc" value="<?php echo $id_doc_part; ?>">

        <div class="box-body table-responsive">
            <table id="example2" class="table table-bordered table-striped">

                <thead>
                <tr>
                    <th>No</th>
                    <th>Check Parameters </th>
                    <th>Last Change Date</th>
                    <th>Last Changed by</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>

            <?php
                $no =1;
                $query_exec2 = get_all_check_doc_data_by_id($id_doc_part);
                while ($row1 = mysqli_fetch_assoc($query_exec2)) {
            ?>

                <tr>
                    <td><?php echo $no++;?></td>
                    <td><?php echo $row1['check_params'];?></td>
                    <td><?php echo $row1['modify_date'];?></td>
                    <td><?php echo $row1['nm_user'];?></td>
                    <td align="center">
                        <a href="home.php?mnu=listcheckedit&id=<?php echo $row1['id_check']; ?>" data-toggle='tooltip' title='edit' class="btn bg-blue"><i class='fa fa-pencil-square-o'></i> Edit</button>
                        </a>
                <!--
                 <a href='project_mgt/act-project-mgt.php?act=del&mod=partmaster&id_part=<?php echo $row['id_part']; ?>' data-toggle='tooltip' title='delete' onclick="return confirm('Are you sure want to delete this data?')" class='btn-flat btn-danger'>
                            <i class='fa fa-trash-o'></i> Delete
                        </a>
                 -->
                    </td>
                </tr>
        <?php

        } //while ($row1 = mysqli_fetch_assoc($query_exec2)

    }//if(isset($_POST['view-data']))
?>
                </tbody>
            </table>
        </div><!-- /.box-body -->
    </div>
</div>

<body>


<?php
if (isset($_POST['submit_val'])) {
    if ($_POST['check_params']) {

        $id_doc_part = $_POST['id_doc'];
        $id_user    = $_SESSION['id_user'];
		$conn = get_connection();
		
        foreach ( $_POST['check_params'] as $key=>$params ) {
            $check_params = mysqli_real_escape_string($conn,$params);
            //$query = mysql_query("INSERT INTO my_hobbies (hobbies) VALUES ('$values')", $connection );

            //add data to doc_check_list
            insert_doc_check_list($id_doc_part, $check_params, $id_user);
        }

        //update doc_part assigned status
        update_doc_checklist_assign($id_doc_part, $id_user);

        /*
        echo"
        <script>window.alert('Success assign check list to document');
            window.location=('home.php?mnu=listcheckmaster')
        </script>";
        */

        echo '
        <script>
        swal({
            title: "Success!",
            text: "Success modify assign check list to document",
            type: "success",
            customClass: \'swal-wide\',
            allowOutsideClick: false
        })
            .then(function() {
            window.location = (\'home.php?mnu=listcheckmaster\');
        });
        
        </script>
        ';
        
    } //if ($_POST['check_params'])

//echo "<i><h2><strong>" . count($_POST['check_params']) . "</strong> List Added</h2></i>";
 //mysql_close();

}//if (isset($_POST['submit_val']))
?>

<?php if (isset($_POST['view-data'])) { ?>
   
    <div class="box box-primary">
        <div class="box-body">
            <div id="container">
                <p id="add_field"><a href="#">
                <span><button type="button" class="btn btn-default" ><i class="fa fa-plus-circle"></i> &nbsp;Add List Check </button></span></a>
                </p>
            </div>
        </div>
    </div>

     <div class="box-footer">
        <button type="submit" class="btn btn-primary" id="submit-val" name="submit_val" >
            <i class="fa fa-retweet"></i> Modify
        </button>
    </div>
    
</form>
<?php } //if (isset($_POST['view-data'])) ?>

<script src="../jquery-2/jquery.min.js"></script>

<script type="text/javascript">

    var counter = 0;
    $(function(){
        $('p#add_field').click(function(){
        counter += 1;
            $('#container').append(
                '<div id="diva_' + counter + '">' +
                    '<label>Addition Check Parameter No. ' + counter + '</label><br />' +
                    '<input id="field_' + counter + '" name="check_params[]' + '" type="text" class="form-control" />' +
                    '<button type="button" class="btn btn-danger btn-flat btn-sm" onClick=removeDiv("diva_' + counter + '"); >' +
                    '<i class="fa fa-minus-circle"></i> &nbsp;Remove </button>' +
                '</div>' +
                '<br>');
        });
    });

    function removeDiv(x) {
        var elem = document.getElementById(x);
            elem.parentNode.removeChild(elem);
        return false;
    }

</script>

<!-- jQuery 2.0.2 -->
<script src="../jquery-2/jquery.min.js"></script>
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
            "bLengthChange": false,
            "bFilter": true,
            "bSort": true,
            "bInfo": true,
            "bAutoWidth": false
        });
    });
</script>
    </body>
</html>