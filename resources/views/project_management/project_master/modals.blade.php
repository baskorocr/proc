 <div class="modal fade" id="create-project" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">>
    <div class="modal-dialog">
    
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Create Project</h4>
            </div>
            <div class="modal-body">
                <form role=form name="myForm" id="create-project-form"  action="" method="post" enctype="multipart/form-data">
                    <?php $num =  Numbering::generateAuto(new \App\Models\Project(),"id_project", 10, 10, 1, "44"); ?>
                    
                        @if(auth()->user()->role == 'admin')

                            <div class="form-group">
                                        <label>ID Project</label>
                                        <input type="text" class="form-control" value='{{$num}}' disabled="true">
                                  </div>
                        @endif
                 

                    <input type="hidden" id="id_project" name="id_project" value ="{{$num}}">

                    <div class="form-group">
                        <label>Project Number</label>
                        <input type="text" class="form-control" id="proj_num" name="proj_num" placeholder="Project Number" required>
                    </div>
                    @csrf
                    <div class="form-group">
                        <label>Nama Project</label>
                        <input type="text" class="form-control" id="nm_project" name="nm_project" placeholder="Project Name" required>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" name="submit-add" class="btn btn-primary"><i class="fas fa-check-square"></i> Create</button>
                    </div>
        
                </form>
        </div>
      
    </div>
  </div>
  
</div>