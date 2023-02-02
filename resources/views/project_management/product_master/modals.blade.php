 <div class="modal fade" id="create-product" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">>
    <div class="modal-dialog">
    
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Create Product</h4>
            </div>
            <div class="modal-body">
                <form role=form name="myForm" id="create-product-form"  action="" method="post" enctype="multipart/form-data">
                    <?php $num =  Numbering::generateAuto(new \App\Models\Product(),"id_product", 10, 10, 1, "41"); ?>
                    
                        @if(auth()->user()->role == 'admin')

                            <div class="form-group">
                                        <label>ID Product</label>
                                        <input type="text" class="form-control" value='{{$num}}' disabled="true">
                                  </div>
                        @endif
                 
                        @csrf
                    <input type="hidden" id="id_product" name="id_product" value ="{{$num}}">

                    <div class="form-group">
                        <label>Product Number</label>
                        <input type="text" class="form-control" id="prod_num" name="prod_num" placeholder="Product Number" required>
                    </div>

                    <div class="form-group">
                        <label>Product Name</label>
                        <input type="text" class="form-control" id="nm_product" name="nm_product" placeholder="Product Name" focused required> 
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
                <form role=form name="assign-product-form" id="assign-product-form" onSubmit="" action="" method="post" enctype="multipart/form-data">
            @csrf
                     <div class="form-group">
                        <label>Choose Product</label>
                            <select  style="width: 100%;" class="form-control option-select2" id="id_product_assign" name="id_project" required>
                               @foreach($product as $p)
                               <option value="{{$p->id_product}}">{{$p->nm_product}}</option>
                               @endforeach
                            </select>
                    </div>  

                    <div class="form-group">
                        <label>Assign Part</label>
                            <select multiple style="width: 100%;"  class="form-control  option-select2" id="id_part_assign" name="id_product[]" required>
                               @foreach($parts as $p)
                               <option value="{{$p->id_part}}">{{$p->nm_part}}</option>
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