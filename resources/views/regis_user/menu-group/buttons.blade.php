
<div class="btn-group" role="group" aria-label="group">

    <a href="{{route('regis-user.menu-group.edit.group',['id' => $data->id])}}" title="Ubah Data"class="btn btn-primary btn-sm" ><i class="fas fa-edit"></i> Edit</button>
    
    <a href="#{{md5($data->id)}}" onclick="deleteProject('{{route('regis-user.menu-group.delete.group',['id' => $data->id])}}','{{$data->id}}')" title="Hapus" class="btn btn-danger btn-sm" ><i class="fas fa-trash"></i> Delete</button>

</div>