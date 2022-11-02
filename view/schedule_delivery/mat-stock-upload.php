<div class="box-header with-border">
   <h3 class="box-title">Create / Update F/G Stock</h3>
</div>
<hr style="margin-top: 1px;">

<!-- form start -->
<form role=form name="myForm" id="myForm" onSubmit="return validateForm()" action="" method="post" enctype="multipart/form-data">

    <div class="box-body">

        <!-- Period -->
        <div class="row">

            <div class="form-group col-sm-2">
                <label for="vendor">Period</label>
                <input type="text" name="period" placeholder="example: 07.2018" class="form-control">
            </div>

        </div> <!-- row -->

        <!-- File -->
        <div class="row">

            <div class="form-group col-sm-2">
                <label for="vendor">Data</label>
                <input type='file' id='file' name='doc[]' accept='.xls' <?php echo $dis_btn; ?> onchange='ValidateSize(this)' > <!-- id='<?php echo $id_doc_part; ?>' -->
                <p class='help-block' id ="information">
            </div>


        </div> <!-- row -->

    </div> <!--  box body -->

    <div class="box-footer">
        <button type="submit" class="btn btn-success"><i class="fa fa-check-circle"></i></button>
    </div> <!-- box footer -->

</form><!-- form end -->


<!-- jQuery 2.0.2
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
        -->
<script src="../jquery-2/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="../js/bootstrap.min.js" type="text/javascript"></script>
<!-- AdminLTE App -->
<script src="../js/AdminLTE/app.js" type="text/javascript"></script>