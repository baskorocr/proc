 <div class="modal fade" id="create-part" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">>
    <div class="modal-dialog">
    
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Create Part</h4>
            </div>
            <div class="modal-body">
                <form role=form name="myForm" id="create-part-form"  action="" method="post" enctype="multipart/form-data">
                    <?php $num =  Numbering::generateAuto(new \App\Models\Part(),"id_part", 10, 10, 1, "42"); ?>
                    
                        @if(auth()->user()->role == 'admin')

                            <div class="form-group">
                                        <label>ID Part</label>
                                        <input type="text" class="form-control" value='{{$num}}' disabled="true">
                                  </div>
                        @endif
                 
                        @csrf
                    <input type="hidden" id="id_part" name="id_part" value ="{{$num}}">

                    <div class="form-group">
                        <label>Part Number</label>
                        <input type="text" class="form-control" id="part_num" name="part_num" placeholder="Part Number" required>
                    </div>

                    <div class="form-group">
                        <label>Part Name</label>
                        <input type="text" class="form-control" id="nm_part" name="nm_part" placeholder="Part Name" focused required> 
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
               
                <h4 class="modal-title">Assign Part to Product</h4>
            </div>
            <div class="modal-body">
                <form role=form name="assign-part-form" id="assign-part-form" onSubmit="" action="" method="post" enctype="multipart/form-data">
            @csrf
                     <div class="form-group">
                        <label>Choose Part</label>
                            <select  style="width: 100%;" class="form-control option-select2" id="id_part_assign" name="id_part_assign" required>
                               @foreach($parts as $p)
                               <option value="{{$p->id_part}}">{{$p->nm_part}}</option>
                               @endforeach
                            </select>
                    </div>  

                    <div class="form-group">
                        <label>Assign Document</label>
                            <select multiple style="width: 100%;"  class="form-control  option-select-doc" id="id_doc_assign" name="id_doc_assign[]" required>
                            
                               @foreach($doc as $d)
                               <option value="{{$d->id_doc_part}}">{{$d->nm_doc_part}} 
                                    ( @if ($d->doc_required == "M") 
                                            Mandatory
                                        @elseif ($d->doc_required == "Y")
                                           Required
                                        @elseif ($d->doc_required== "N")
                                            Not-required
                                        @endif )</option>
                               @endforeach
                            </select>
                    </div>  

                    <div class="modal-footer">
                        <button type="submit" name="submit-assign" class="btn btn-primary"><i class="fas fa-check-square"></i> Assign</button>
                    </div>
        
                </form>
        </div>
      
    </div>
  </div>
  
</div>