
<div class="btn-group" role="group" aria-label="notify">

    <a href="{{route('doc-iso.master-notify.edit.notify',['id' => $data->id])}}" title="Ubah Data"class="btn btn-success btn-sm" ><i class="fas fa-edit"></i> Edit</button>
    
    <a href="#{{md5($data->id)}}" onclick="deleteProject('{{route('doc-iso.master-notify.delete.notify',['id' => $data->id])}}','{{$data->id}}')" title="Hapus" class="btn btn-danger btn-sm" ><i class="fas fa-trash"></i> Delete</button>

</div>