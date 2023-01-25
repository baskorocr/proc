
<form name="myForm" action="{{route('monitoring.delivery.detail.material',['manifest' => $data->manifest])}}" method="post" enctype="multipart/form-data" target="_blank">
    {{-- <input type="hidden" name="mf" value="" readonly='true'> --}}
    <button type="submit" name="mfmat" class="btn-success"  data-toggle="" title="material detail {{$data->manifest}}"><i class="fa fa-sitemap"></i></button>
</form>
<form name="myForm1" action="{{route('monitoring.delivery.detail.kanban',['manifest' => $data->manifest])}}" method="post" enctype="multipart/form-data" target="_blank">
    {{-- <input type="hidden" name="mf" value="" readonly='true'> --}}
    <button type="submit" name="mfkan" class="btn-primary" data-toggle="" title="kanban detail {{$data->manifest}}"><i class="fa fa-files-o"></i></button>
</form>
            