<div class="box-header">
    <h3 class="box-title">Upload New Project by Engineering</h3>
</div>

<form role=form name="myForm" id="myForm" onSubmit="return validateForm()" action="" method="post" enctype="multipart/form-data">

     
    </br>

            <?php
                
                function reArrayFiles($file)
                {
                    $file_ary = array();
                    $file_count = count($file['name']);
                    $file_key = array_keys($file);
                   
                    for($i=0;$i<$file_count;$i++)
                    {
                        foreach($file_key as $val)
                        {
                            $file_ary[$i][$val] = $file[$val][$i];
                        }
                    }
                    return $file_ary;
                }

                $file = $_FILES['doc'];

                if(!empty($file))
                {
                    $file_desc = reArrayFiles($file);
            ?>
            
            <table class="table table-bordered table-striped table-hover">
                <th>#</th>
                <th>Nama Dokumen</th>
                <th>Jenis Dokumen</th>
                <th>Cek</th>

                <?php

                    include "func_project.php";

                    $i=1;
                    foreach($file_desc as $val)
                    {
                ?>

                    <tr>
                        <td><?php echo $i++.'.';?></td>
                        <td>
                            <label for="exampleInputFile"><?php print_r($val['name']); ?></label>
                        </td>
                        <td>
                            
                            <select width="100%">
                            <?php
                                $query_exec = get_doc_lib_list();
                                while ($row = mysqli_fetch_assoc($query_exec)) {
                                    echo "<option>".$row['doc_name']."</option>";
                                }
                            ?>
                            </select>

                        </td>
                        <td><input type="checkbox" name="cekbox"></td>
                    </tr>

            <?php
                    }
            ?>

            </table>

            <?php

                }
            ?>
            
    <?php
        
        /*
        <div class="progress xs">
        <div class="progress-bar progress-bar-aqua" style="width: 30%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
        </div>
        </div>
        */
        if (isset($_POST['prev']))
        {
             
    ?>
        <div class="box-footer">
            <button type="submit" class="btn btn-primary"><i class="fa fa-upload"></i> Upload</button>
            <input type="hidden" name="upload_data">
        </div>

    <?php

        } elseif(empty($_POST)) {

    ?>
        <input type="file" name="doc[]" multiple>
        </br>

        <label for="exampleInputEmail1">Project Name</label>
        <input type="text" class="form-control " name="project_nm" placeholder="Project Name" value="<?php echo $_POST['project_nm']?>" autofocus required> 

        <div class="box-footer">
            <button type="submit" name="btn" class="btn btn-primary"><i class="fa fa-eye"></i> Preview</button>
            <input type="hidden" name="prev">
        </div>

    <?php
        } elseif(isset($_POST['upload_data'])){

            echo "<script>alert('data uploaded!'); window.location.href = 'home.php?mnu=upldrawing';</script>";
        /*
            check checked file
                if no file checked then
                    notif no file checked
                else
            
            check project name
                if exist then 
                    notif project exist
                elseif notexist then
                    create folder name based on project name in server's local-directory
                    create sequence project id on db and path of file in server's local-directory
                    upload checked file in current folder with standardize name
                    show progress bar
                end if.
        */


        } 

    ?>


</form>