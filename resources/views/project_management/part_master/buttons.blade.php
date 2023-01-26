
<div class="btn-group" role="group" aria-label="ProjAct">

    <a href="{{route('project.management.master.edit.part',['id' => $data->id_part])}}" title="Ubah Data" class="btn btn-success" ><i class="fas fa-edit"></i></button>
    
    <a href="#{{md5($data->id_part)}}" onclick="deleteProject('{{route('project.management.master.delete.part',['id' => $data->id_part])}}','{{$data->id_part}}')" title="Hapus" class="btn btn-danger" ><i class="fas fa-trash"></i></button>

</div>