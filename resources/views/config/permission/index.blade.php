@extends('layouts.main')
@section('title',"Permission ")
@section('content')
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Permission</h1>
        <nav>
            <ol class="breadcrumb">
               {{--  <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{route('monitoring.delivery')}}">Settings</a></li> --}}
                <li class="breadcrumb-item active">Permission</li>
            </ol>
        </nav>
        </div><!-- End Page Title -->
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row mt-3">
                                <div class="col-md-3 col-xs-12">
                                    <div class="row">
                                         <div class="col-12">
                                            <a href="{{route('config.permission.create')}}" class="btn btn-primary btn-block"> <i class="fas fa-plus"></i> Add Permission</a>
                                         </div>

                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive mt-3">
                                <table  class="table table-bordered table-striped " id="detail-permission">
                                    <thead>
                                        <th>Permission</th>
                                        <th>Description</th>
                                        <th>URL</th>
                                        <th>Parent Name</th>
                                        <th>Action</th>
                                        
                                    </thead>
                                    <tbody>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
        @endsection
        @section('javascript')
        <script>
         $('#detail-permission').DataTable({
        "order": [[ 0, "ASC" ]],
        processing: true,
        serverSide: true,
        autoWidth:false,
        "language": {
        "processing": "<i class='fa fa-spinner fa-spin fa-1x'></i> Sedang mengambil data..."
        },
        ajax: "{{ route('api.perm.datatables')}}",
        columns: [
                {
                data: 'name',
                name: 'name'
                },{
                data: 'description',
                name: 'description'
                },
                {
                data: 'url',
                name: 'url'
                },
                {
                data: 'parent_name',
                name: 'parent_name'
                },
                {
                data: 'action',
                name: 'action'
                },
            ]
            });

         function deleteAct(url,id)
        {
            Swal.fire({
                  title: '',
                  html: 'All reference data will be deleted. Are you sure want to delete this data <b>['+id+']</b>?',
                  // showDenyButton: true,
                  showCancelButton: true,
                  confirmButtonText: 'Confirm',
                  denyButtonText: `Cancel`,
                }).then((result) => {
                  /* Read more about isConfirmed, isDenied below */
                  if (result.isConfirmed) {
                    window.location = url;
                  }
                })
            }
        </script>
        @endsection