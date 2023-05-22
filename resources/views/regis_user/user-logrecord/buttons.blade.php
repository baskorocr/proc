
<div class="btn-group" role="group" aria-label="list">
    
    <a href="#{{md5($data->id)}}" onclick="blockuser('{{route('regis-user.user-logrecord.delete.logrecord',['id' => @$data->id])}}','{{@$data->user->username}}')" title="Block" class="btn btn-danger" ><i class="fas fa-minus-circle"></i> Block</button>

</div>