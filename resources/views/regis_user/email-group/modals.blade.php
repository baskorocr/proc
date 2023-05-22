<div class="modal fade" id="create-email" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
    
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Create Email Group</h4>
            </div>
            <div class="modal-body">
                <form role=form name="myForm" id="myForm"  action="{{route('api.regis-user.create.email')}}" method="post" enctype="multipart/form-data">
                                @csrf
                    {{-- <input type="hidden" name="id" value ="<?php echo $email->id; ?>"> --}}
                    <div class="box-body">
                        <div class="form-group">
                            <label>Departement Code</label>
                            <input type="text" class="form-control" id="dept_code" name="dept_code" placeholder="ex. PROC" value="" required>
                        </div>
                        <div class="form-group">
                            <label>Abbreviation (SAP PO Creator) </label>
                            <input type="text" class="form-control" id="abrev" name="abrev" value="" placeholder="ex. PRO" required>
                        </div>
                        <div class="form-group">
                            <label>Departement Description </label>
                            <input type="text" class="form-control" id="dept_desc" name="dept_desc" value="" placeholder="ex. Procurement" required>
                        </div>
                        {{-- <div class="form-group">
                            <label>Status Active</label>
                            <select name="active" class="form-control">
                                <option value="A">Active</option>
                                <option  value="N">Non-Active</option>
                            </select>
                        </div> --}}
                        </div><!-- /.box-body -->
                        <div class="box-footer"> 
                            <button type="submit" id="edit-projmaster" name="edit-projmaster" class="btn btn-primary"><i class="fa fa-pencil-square-o"></i> Create</button>
                        </div>
                                </form>
        </div>
      
    </div>
  </div>
  
</div>

  