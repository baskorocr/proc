
<div class="box-header">
    <h3 class="box-title">File Master</h3>

    <div class="pull-right box-tools">
        <!--
        <div class="btn-group">
            <button href="#" class="text-muted bg-black" data-toggle="dropdown"><i class="fa fa-bars"></i></button>
            <ul class="dropdown-menu pull-right" role="menu">

                <li><a href="home.php?" data-toggle="modal" data-backdrop="static" data-keyboard="false">
                        <i class="fa fa-download"></i>Download Files</a>
                </li>
            </ul>
        </div>
        -->
    </div>

</div><!-- /.box-header -->

<hr style="margin-top: 1px;">

<div class="box-body table-responsive">

    <table id="example2" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Filename</th>
                <th>Download</th>
            </tr>
        </thead>
        <tbody>

    <?php

        $no = 1;
        $dir_iterator = new RecursiveDirectoryIterator("DATA/");
        $iterator = new RecursiveIteratorIterator($dir_iterator, RecursiveIteratorIterator::SELF_FIRST);

        foreach ($iterator as $file) {
            $string = explode(".", $file);
            if(count($string) > 1) {
                $data = $string[1];
            }

            $myfile = str_replace('DATA\\',"",$file);

            if ($data == "pdf" and strpos($file, '.pdf') !== false) {
                echo "
                    <tr>
                        <td>$no</td>
                        <td>$file</td>
                        <td>
                            <a href='DATA/view_data.php?p=$myfile' target='_blank' data-toggle='tooltip' title='click to download'>
                            <h4>
                                <span class='badge bg-green'>Download <i class='fa fa-download'></i></span>
                            </h4>
                            </a>
                        </td>
                    </tr>
                ";

                $no++;
            }//  if ($data == "pdf")

        }//foreach ($iterator as $file)

    ?>
        </tbody>
    </table>
</div>

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
