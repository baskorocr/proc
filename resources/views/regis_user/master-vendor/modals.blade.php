<div class="modal fade" id="create-vendor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">>
    <div class="modal-dialog">
    
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Create Vendor </h4>
            </div>
            <div class="modal-body">
               <form role=form name="myForm" id="myForm"  action="{{route('api.regis-user.create.vendor')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="box-body">
                                    
                                
                                    <div class="form-group">
                                        <label>Nama Vendor</label>
                                        <input type="text" class="form-control" placeholder="Vendor Name, PT" id="nm_vendor" name="nm_vendor" value="" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Alias</label>
                                        <input type="text" class="form-control" id="allias" placeholder="(ex. AMPJKT)" name="allias" value="" >
                                    </div>
                                    <div class="form-group">
                                        <label>Street </label>
                                        <input type="text" class="form-control" placeholder="Jakarta 89"  id="street" name="street" value="" >
                                    </div>
                                    </div><!-- /.box-body -->
                                    <div class="box-footer"> 
                                        <button type="submit" id="edit-projmaster" name="edit-projmaster" class="btn btn-primary"><i class="fa fa-plus"></i> Create</button>
                                    </div>
                                </form>
        </div>
      
    </div>
  </div>
  
</div>

 