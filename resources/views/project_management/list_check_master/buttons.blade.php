
<div class="btn-group" role="group" aria-label="ProjAct">

    <a href="{{route('project.management.master.edit.part',['id' => $data->id_check])}}" title="Ubah Data" class="btn btn-primary" ><i class="fas fa-edit"></i> Edit</button>
    
    {{-- <a href="#{{md5($data->id_check)}}" onclick="deleteProject('{{route('project.management.master.delete.part',['id' => $data->id_check])}}','{{$data->id_check}}')" title="Hapus" class="btn btn-danger" ><i class="fas fa-trash"></i></button> --}}

</div>