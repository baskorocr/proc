
<div class="btn-group" role="group" aria-label="list">

    <a href="{{route('regis-user.master-vendor.edit.vendor',['id' => $data->id])}}" title="Ubah Data" class="btn btn-success" ><i class="fas fa-edit"></i></button>
    
    <a href="#{{md5($data->id)}}" onclick="deleteProject('{{route('regis-user.master-vendor.delete.vendor',['id' => $data->id])}}','{{$data->id}}')" title="Hapus" class="btn btn-danger" ><i class="fas fa-trash"></i></button>

</div>