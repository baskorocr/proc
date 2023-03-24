<div class="modal fade" id="create-menu-list" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">>
    <div class="modal-dialog">
    
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Create Menu List </h4>
            </div>
            <div class="modal-body">
                <form role=form name="myForm" id="create-list-form"  action="{{route('api.regis-user.create.list')}}" method="post" enctype="multipart/form-data">
                    <?php $num =  Numbering::generateAuto(new \App\Models\Project(),"menu_name", 10, 10, 1, "44"); ?>
                    
                        <!-- @if(auth()->user()->role == 'admin')

                            <div class="form-group">
                                        <label>Menu Name</label>
                                        <input type="text" class="form-control" value='{{$num}}' disabled="true">
                                  </div>
                        @endif
                 

                    <input type="hidden" id="menu_name" name="menu_name" value ="{{$num}}"> -->

                    <div class="form-group">
                        <label>Menu Name</label>
                        <input type="text" class="form-control" id="menu_name" name="menu_name" placeholder="Menu Name" required>
                    </div>
                    @csrf
                    <div class="form-group">
                        <label>Menu Object</label>
                        <input type="text" class="form-control" id="menu_object" name="menu_object" placeholder="Menu Object" required>
                    </div>
                    <div class="form-group">
                        <label> Object Path</label>
                        <input type="text" class="form-control" id="object__path" name="object__path" placeholder="Object Path" required>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" name="submit-add" class="btn btn-primary"><i class="fas fa-check-square"></i> Create</button>
                    </div>
        
                </form>
        </div>
      
    </div>
  </div>
  
</div>

 