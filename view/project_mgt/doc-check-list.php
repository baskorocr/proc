<?php
    include "project-mgt-query.php";
    include "project-mgt-func.php";
    include "../lib/function.php";
?>

<div class="box-header">
    <h3 class="box-title">Assign Document Check List Paramter</h3>

    <div class="pull-right box-tools">
        <!-- button with a dropdown -->
        <div class="btn-group">
            <a href="#" data-toggle="dropdown"><i class="fa fa-bars"></i></a>
            <ul class="dropdown-menu pull-right" role="menu">
                 <li><a href="home.php?<?php echo token(); ?>mnu=addlistcheckdoc<?php echo token2(); ?>" data-toggle="modal" data-backdrop="static" data-keyboard="false">
                        <i class="fa fa-retweet"></i>Modify Doc Check List</a>
                </li>
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
                                    
                        $query_exec1 =  get_unassigned_doc_data();

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
        </div>            

    </div><!-- /.box-body -->
        
<body>

<?php
if (isset($_POST['submit_val'])) {
    if ($_POST['check_params']) {

        $id_doc_part = $_POST['id_doc'];
        $id_user    = $_SESSION['id_user'];

        foreach ( $_POST['check_params'] as $key=>$params ) {
            $check_params = mysql_real_escape_string($params);
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
            text: "Success assign check list to document",
            type: "success",
            customClass: \'swal-wide\',
            allowOutsideClick: false
        })
            .then(function() {
            window.location = (\'home.php?mnu=listcheckmaster\');
        });
        
        </script>
        ';
        
    } 

//echo "<i><h2><strong>" . count($_POST['check_params']) . "</strong> List Added</h2></i>";
 //mysql_close();
}
?>

<?php //if (!isset($_POST['submit_val'])) { ?>
   
    <div class="box box-primary">
    <div class="box-body">
        <div id="container">
            <p id="add_field"><a href="#"><span><button type="button" class="btn btn-default" ><i class="fa fa-plus-circle"></i> &nbsp;Add List Check </button></span></a></p>
        </div>
    </div>
    </div>

     <div class="box-footer">
        <button type="submit" class="btn btn-primary" id="submit-val" name="submit_val" >
            <i class="fa fa-check-square-o"></i>Assign
        </button>
    </div>
    
</form>
<?php //} ?>
<script src="../jquery/jquery.min.js"></script>

<script type="text/javascript">

    var counter = 0;
    $(function(){
        $('p#add_field').click(function(){
        counter += 1;
            $('#container').append(
                '<div id="div_' + counter + '">' +
                    '<label>Check Parameter No. ' + counter + '</label><br />' +
                    '<input id="field_' + counter + '" name="check_params[]' + '" type="text" class="form-control" />' +
                    '<button type="button" class="btn btn-danger btn-flat btn-sm" onClick=removeDiv("div_' + counter + '"); >' +
                    '<i class="fa fa-minus-circle"></i> &nbsp;Remove </button>' +
                '</div>' +
                '<br>');
        });
    });

    function removeDiv(x) {
        var elem = document.getElementById(x);
        elem.parentNode.removeChild(elem);
        //elem.style.display = 'none';
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

    </body>
</html>