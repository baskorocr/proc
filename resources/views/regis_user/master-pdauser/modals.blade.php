<div class="modal fade" id="create-master-pdauser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
    
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Create PDA User </h4>
            </div>
            <div class="modal-body">
               <form role=form name="myForm" id="myForm"  action="{{route('api.regis-user.create.pdauser')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="box-body">
                                    <div class="form-group">
                                        <label>ID / NPK</label>
                                        <input type="text" class="form-control" placeholder="111157283" id="id" name="id" value="" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Full Name </label>
                                        <input type="text" class="form-control" id="full_name" name="full_name" placeholder="ex. Hidrian Oma Suharman" value="" placeholder=" > Year" required>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>Username Login</label>
                                        <input type="text" class="form-control" placeholder="User PDA Login" id="username" name="username" value="" required>
                                    </div>
                                    <div class="form-group">
                                        <label>PIN</label>
                                        <input type="password"  class="form-control" placeholder="ex. {{rand(111111,999999)}}" id="pin" name="pin" value="">
                                    </div>
                                    <div class="form-group">
                                        <label>Confirm PIN</label>
                                        <input type="password" class="form-control" placeholder="Confirm PIN" id="pin_confirm" name="pin_confirm" value="">
                                    </div>
                                    </div><!-- /.box-body -->
                                    <div class="box-footer"><hr>
                                        <button type="submit" id="edit-projmaster" name="edit-projmaster" class="btn btn-primary"><i class="fa fa-pencil-square-o"></i> Create</button>
                                    </div>
                                </form>
        </div>
      
    </div>
  </div>
  
</div>

 