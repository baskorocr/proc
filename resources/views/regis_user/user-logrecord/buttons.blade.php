
<div class="btn-group" role="group" aria-label="list">
    
    <a href="#{{md5($data->id)}}" onclick="deleteProject('{{route('regis-user.user-logrecord.delete.logrecord',['id' => $data->id])}}','{{$data->id}}')" title="Block" class="btn btn-danger" >Block</button>

</div>