
<div class="btn-group" role="group" aria-label="list">

    <a href="{{route('regis-user.master-pdauser.edit.pdauser',['id' => $data->id])}}" title="Ubah Data"class="btn btn-success btn-sm" ><i class="fas fa-edit"></i> Edit</button>
    
    <a href="#{{md5($data->id)}}" onclick="deleteProject('{{route('regis-user.master-pdauser.delete.pdauser',['id' => $data->id])}}','{{$data->id}}')" title="Hapus" class="btn btn-danger btn-sm" ><i class="fas fa-trash"></i> Delete</button>

</div>