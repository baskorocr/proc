@extends('layouts.main')
@section('title',"Roles ")
@section('content')
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Roles</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{route('monitoring.delivery')}}">Settings</a></li>
                <li class="breadcrumb-item active">Roles</li>
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
                                            <a href="{{route('config.role.add')}}" class="btn btn-primary btn-block"> <i class="fas fa-plus"></i> Add Role</a>
                                         </div>

                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive mt-3">
                                <table  class="table table-bordered table-stripped " id="detail-permission">
                                    <thead>
                                        <th>Role</th>
                                        <th>Description</th>
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
        ajax: "{{ route('api.role.datatables')}}",
        columns: [
                {
                data: 'name',
                name: 'name'
                },{
                data: 'description',
                name: 'description'
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