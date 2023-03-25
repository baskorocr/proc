
<div class="btn-group" role="group" aria-label="ProjAct">

    <a href="{{route('project.management.master.edit.product',['id' => $data->id_product])}}" title="Ubah Data"class="btn btn-primary btn-sm" ><i class="fas fa-edit"></i> Edit</button>
    
    <a href="#{{md5($data->id_product)}}" onclick="deleteProject('{{route('project.management.master.delete.product',['id' => $data->id_product])}}','{{$data->id_product}}')" title="Hapus" class="btn btn-danger btn-sm" ><i class="fas fa-trash"></i> Delete</button>

</div>