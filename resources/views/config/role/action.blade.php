<div class="btn-group" role="group" aria-label="btnPermission">
  {{-- <a  href="" type="button" class="btn btn-primary"><i class="fas fa-eye"></i></a> --}}
  <a  href="{{route('config.role.edit',['id' => $data->_id])}}" type="button" class="btn btn-warning"><i class="fas fa-edit"></i></a>
  <a onclick="deleteAct('{{route('config.role.delete',['id' => $data->_id])}}','{{$data->name}}')" href="#{{$data->id}}"  type="button" class="btn btn-danger"><i class="fas fa-trash"></i></a>
</div>