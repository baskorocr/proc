
<div class="btn-group" role="group" aria-label="ProjAct">

    <a href="{{route('project.management.master.edit.project',['id' => $data->id_project])}}" title="Ubah Data"class="btn btn-success btn-sm" ><i class="fas fa-edit"></i> Edit</button>
    
    <a href="#{{md5($data->id_project)}}" onclick="deleteProject('{{route('project.management.master.delete.project',['id' => $data->id_project])}}','{{$data->id_project}}')" title="Hapus" class="btn btn-danger btn-sm" ><i class="fas fa-trash"></i> Delete</button>

</div>