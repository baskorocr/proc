<div class="modal fade" id="create-email" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">>
    <div class="modal-dialog">
    
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Create Email List Group</h4>
            </div>
            <div class="modal-body">
                <form role=form name="myForm" id="myForm"  action="{{route('api.regis-user.create.listemail')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="box-body">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="text" class="form-control" id="mail" name="mail" placeholder="ex. osa.maliki@dp.dharmap.com" value="" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Departement</label>
                                        <select name="dept_code" style="width: 100%;"  id="dept_code" class="form-control option-select2">
                                                <option></option>
                                            @foreach($dept as $d)
                                                <option value="{{$d->dept_code}}">[{{$d->dept_code}}] {{$d->dept_desc}}</option>
                                            @endforeach
                                        </select>
                                        {{-- <input type="text" class="form-control" id="dept_code" name="dept_code" value="<?php echo $listemail->dept_code ?>" placeholder="Departement" required> --}}
                                    </div>
                                    <div class="form-group">
                                        <label>Email Holder Name </label>
                                        <input type="text" class="form-control" id="name" placeholder="ex. Osa Maliki" name="name" value="" placeholder="" required>
                                    </div>
                                    {{-- <div class="form-group">
                                        <label>Status Active</label>
                                        <select name="active" class="form-control">
                                            <option  value="A">Active</option>
                                            <option  value="N">Non-Active</option>
                                        </select>
                                    </div> --}}
                                    </div><!-- /.box-body -->
                                    <div class="box-footer"> 
                                        <button type="submit" id="edit-projmaster" name="edit-projmaster" class="btn btn-primary"><i class="fa fa-plus"></i> Create</button>
                                    </div>
                                </form>
        </div>
      
    </div>
  </div>
  
</div>
