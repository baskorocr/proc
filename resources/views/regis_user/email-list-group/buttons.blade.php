
<div class="btn-group" role="group" aria-label="group">

    <a href="{{route('regis-user.email-list-group.edit.listemail',['id' => $data->id])}}" title="Ubah Data" class="btn btn-success" ><i class="fas fa-edit"></i></button>
    
    <a href="#{{md5($data->id)}}" onclick="deleteProject('{{route('regis-user.email-list-group.delete.listemail',['id' => $data->id])}}','{{$data->id}}')" title="Hapus" class="btn btn-danger" ><i class="fas fa-trash"></i></button>

</div>