
<div class="btn-group" role="group" aria-label="Basic example">

    <a href="{{route('monitoring.delivery.detail.material',['manifest' => $data->manifest])}}" title="Detail Material {{$data->manifest}}" class="btn btn-success" target="_blank"><i class="fas fa-sitemap"></i></button>
    
    <a href="{{route('monitoring.delivery.detail.kanban',['manifest' => $data->manifest])}}" title="Detail Kanban {{$data->manifest}}" class="btn btn-primary" target="_blank"><i class="fas fa-file"></i></button>

</div>