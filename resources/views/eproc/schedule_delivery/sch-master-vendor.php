<div class="box-header with-border">
   <h3 class="box-title">Delivery Schedule Vendor</h3>
</div>
<hr style="margin-top: 1px;">

<!-- form start -->
<form role=form name="myForm" id="myForm" onSubmit="return validateForm()" action="home.php?<?php echo token(); ?>mnu=schvdrview<?php echo token2(); ?>" method="post" enctype="multipart/form-data">

    <div class="box-body">

        <!-- Period -->
        <div class="row">

            <div class="form-group col-sm-2">
                <label for="vendor">Period</label>
                <input type="text" name="period" placeholder="example: 07.2018" class="form-control">
            </div>

        </div> <!-- row -->

        <!-- Material -->
        <div class="row">

            <!-- from -->
            <div class="form-group col-sm-5">
                <label for="vendor">Material</label>
                <div class="input-group input-group-sm">
                    <select class="selectpicker" name="materialfrom" data-live-search="true" required>
                        <option value="A2004010100130000">A2004010100130000 - CLIP HARNESS (MK4)  50103-KEHA-9011HI00</option>
                        <option value="A2006160102040000">A2006160102040000</option>
                    </select>
                </div>
            </div>

            <!-- to -->
            <div class="form-group col-sm-5">
                <label for="vendor">to Material</label>
                <div class="input-group input-group-sm">
                    <select class="selectpicker" name="materialto" data-live-search="true" required>
                        <option value="A2004010100130000">A2004010100130000 - CLIP HARNESS (MK4)  50103-KEHA-9011HI00</option>
                        <option value="A2006160102040000">A2006160102040000</option>
                    </select>
                </div>
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