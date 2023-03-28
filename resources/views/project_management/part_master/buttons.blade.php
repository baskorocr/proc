
<div class="btn-group" role="group" aria-label="ProjAct">

    <a href="{{route('project.management.master.edit.part',['id' => $data->id_part])}}" title="Ubah Data"class="btn btn-primary btn-sm" ><i class="fas fa-edit"></i> Edit</button>
    
    <a href="#{{md5($data->id_part)}}" onclick="deleteProject('{{route('project.management.master.delete.part',['id' => $data->id_part])}}','{{$data->id_part}}')" title="Hapus" class="btn btn-danger btn-sm" ><i class="fas fa-trash"></i> Delete</button>

</div>