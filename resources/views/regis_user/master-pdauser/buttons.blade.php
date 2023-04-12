
<div class="btn-group" role="group" aria-label="list">

    <a href="{{route('regis-user.master-pdauser.edit.pdauser',['id' =>$data->_id])}}" title="Ubah Data"class="btn btn-primary btn-sm" ><i class="fas fa-edit"></i> Edit</button>
    
    <a href="#{{md5($data->id)}}" onclick="deleteProject('{{route('regis-user.master-pdauser.delete.pdauser',['id' => $data->_id])}}','{{$data->_id}}')" title="Hapus" class="btn btn-danger btn-sm" ><i class="fas fa-trash"></i> Delete</button>

</div>