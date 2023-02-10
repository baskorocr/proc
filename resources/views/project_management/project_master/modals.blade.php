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

  <div class="modal fade" id="assignDetailModal" role="dialog">
    <div class="modal-dialog">
    
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
               
                <h4 class="modal-title">Assign Project to Product</h4>
            </div>
            <div class="modal-body">
                <form role=form name="assign-project-form" id="assign-project-form" onSubmit="" action="" method="post" enctype="multipart/form-data">
            @csrf
                     <div class="form-group">
                        <label>Choose Project</label>
                            <select  style="width: 100%;" class="form-control option-select2" id="id_project_assign" name="id_project" required>
                               @foreach($project ?? '' as $p)
                               <option value="{{$p->id_project}}">{{$p->proj_num}} - {{$p->nm_project}}</option>
                               @endforeach
                            </select>
                    </div>  

                    <div class="form-group">
                        <label>Assign Product</label>
                            <select multiple style="width: 100%;"  class="form-control  option-select2" id="id_product_assign" name="id_product[]" required>
                               @foreach($product as $p)
                               <option value="{{$p->id_product}}">{{$p->nm_product}}</option>
                               @endforeach
                            </select>
                    </div>  

                    <div class="modal-footer">
                        <button type="submit" name="submit-assign" class="btn btn-primary"><i class="fas fa-check-square-o"></i> Assign</button>
                    </div>
        
                </form>
        </div>
      
    </div>
  </div>
  
</div>