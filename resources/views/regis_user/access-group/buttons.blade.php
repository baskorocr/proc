
<div class="btn-group" role="group" aria-label="group">

    <a href="{{route('regis-user.access-group.edit.access',['id' => $data->id])}}" title="Ubah Data" class="btn btn-success" ><i class="fas fa-edit"></i></button>
    
    <a href="#{{md5($data->id)}}" onclick="deleteProject('{{route('regis-user.access-group.delete.access',['id' => $data->id])}}','{{$data->id}}')" title="Hapus" class="btn btn-danger" ><i class="fas fa-trash"></i></button>

</div>