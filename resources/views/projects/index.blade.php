@extends('layouts.main')
@section('title', "Project List")
@section('content')
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Projects</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">Projects</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div class="card">
                    <div class="card-body">
                        <a href="{{ route('projects.create') }}" class="btn btn-primary btn-sm mt-3 mb-3">
                            <i class="fa fa-plus"></i> Add Project
                        </a>
                        <div class="table-responsive">
                            <table class="table table-bordered nowrap table-striped table-sm" id="project-table">
                                <thead>
                                    <tr>
                                        <th><i class="fa fa-list"></i></th>
                                        <th>Project Name</th>
                                        <th>Customer</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($projects as $project)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $project->name_project }}</td>
                                        <td>{{ $project->customer ? $project->customer->name : 'N/A' }}</td>
                                        <td>
                                            <a href="{{ route('projects.edit', $project->_id) }}"
                                                class="btn btn-warning btn-sm">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-danger btn-sm btn-delete" 
                                                data-id="{{ $project->_id }}" 
                                                data-url="{{ route('projects.destroy', $project->_id) }}">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div><!-- End Table -->
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection

@section('javascript')
<script>
$(document).ready(function() {
    var table = $('#project-table').DataTable({
        autoWidth: false,
        language: {
            processing: "<i class='fa fa-spinner fa-spin'></i> Sedang memuat data..."
        }
    });
    
    // AJAX Delete
    $(document).on('click', '.btn-delete', function() {
        if(!confirm('Are you sure?')) return;
        
        var url = $(this).data('url');
        var btn = $(this);
        
        $.ajax({
            url: url,
            type: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if(response.success) {
                    table.row(btn.closest('tr')).remove().draw(false);
                    alert(response.message);
                }
            },
            error: function() {
                alert('Error deleting project');
            }
        });
    });
});
</script>
@endsection