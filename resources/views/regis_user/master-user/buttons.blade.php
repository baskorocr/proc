
<div class="btn-group" role="group" aria-label="list">

    <a href="{{route('regis-user.master-user.edit.user',['id' => $data->id])}}" title="Ubah Data"class="btn btn-primary btn-sm" ><i class="fas fa-edit"></i> Edit</button>
    
    <a href="#{{$data->_id}}" onclick="deleteProject('{{route('regis-user.master-user.delete.user',['id' => $data->id])}}','{{$data->id}}')" title="Hapus" class="btn btn-danger btn-sm" ><i class="fas fa-trash"></i> Delete</button> 

    <a href="{{URL::to('regis-user/master-user/reset/'.$data->id)}}" onclick="return confirm('Reset Password?')" class="btn btn-success btn-sm" ><i class="fas fa-sync"></i> Reset Password</button>

</div>