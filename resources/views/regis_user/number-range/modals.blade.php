<div class="modal fade" id="create-number-range" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">>
    <div class="modal-dialog">
    
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Create Number Range </h4>
            </div>
            <div class="modal-body">
                <form role=form name="myForm" id="myForm"  action="{{route('api.regis-user.create.number')}}" method="post" enctype="multipart/form-data">
                                @csrf
               
                <div class="box-body">
                    <div class="form-group">
                        <label>Document Type</label>
                         <select class="form-control selectpicker" name="doc_type" data-live-search="true" focused required>
                            <option value="iso" >iso</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Document Year </label>
                        <input type="text" class="form-control" id="doc_year" name="doc_year" value="" placeholder="ex. {{date('Y')}}" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Low Number</label>
                        <input type="text" class="form-control" placeholder="ex. 00000" id="num_low" name="num_low" value="" required>
                    </div>
                    <div class="form-group">
                        <label>High Number</label>
                        <input type="text" class="form-control" id="num_high" placeholder="ex. 99999" name="num_high" value="">
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

 