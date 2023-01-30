 <div class="modal fade" id="create-doc" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">>
    <div class="modal-dialog">
    
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Create Document</h4>
            </div>
                <form role=form name="myForm" id="create-doc-form"  action="" method="post" enctype="multipart/form-data">
            <div class="modal-body">
                
                     <?php 
                        $id_doc = Numbering::generateAuto(new \App\Models\DocPart(),"id_doc_part", 10, 10, 1, "43");
                    ?>

                    <div class="form-group"> <!-- change get updatet user id -->
                        <label>ID Document</label>
                        <input type="text" class="form-control" value ="<?php echo $id_doc; ?>" disabled="true">
                        <input type="hidden" id="id_doc" name="id_doc" value ="<?php echo $id_doc; ?>">
                    </div>

                    <div class="form-group">
                        <label>Nama Document</label>
                        <input type="text" class="form-control" id="nm_doc" name="nm_doc" placeholder="Document Name" focused required> 
                    </div> 

                    <div class="form-group">
                        <label>Tipe Document</label>
                        <select class="form-control selectpicker" id="doc_type" name="doc_type" required>
                            <option value="P">Doc for Procurement </option>
                            <option value="V">Doc for Vendor </option>
                        </select>
                    </div>  

                    <!--
                    <div class="form-group">
                        <input type="checkbox" class="form-control" id="doc_required" name="doc_required" value="Y"> 
                        <label>Required Document</label>
                    </div>
                    -->

                    <div class="form-group">
                        <label>Requirement Type</label>
                        <select class="form-control selectpicker" id="doc_required" name="doc_required" required>
                            <option value="M" style='color: #00cc00;'>Mandatory </option>
                            <option value="Y">Required </option>
                            <option value="N" style='color: #ff8000;'>Not required</option>
                        </select>
                    </div>
        
        </div>
        <div class="modal-footer">
                        <button type="submit" name="submit-assign" class="btn btn-primary"><i class="fas fa-check-square"></i> Simpan</button>
                    </div>
                </form>
      
    </div>
  </div>
  
</div>
