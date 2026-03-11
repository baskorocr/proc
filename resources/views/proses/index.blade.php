@extends('layouts.main')
@section('title', "Proses List")
@section('content')
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Proses</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">Proses</li>
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
                        <a href="{{ route('proses.create') }}" class="btn btn-primary btn-sm mt-3 mb-3">
                            <i class="fa fa-plus"></i> Add Proses
                        </a>
                        <div class="table-responsive">
                            <table class="table table-bordered nowrap table-striped table-sm" id="proses-table">
                                <thead>
                                    <tr>
                                        <th><i class="fa fa-list"></i></th>
                                        <th>Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($proses as $pro)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $pro->proses_name }}</td>
                                        <td>
                                            <a href="{{ route('proses.edit', $pro->_id) }}"
                                                class="btn btn-warning btn-sm">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <form action="{{ route('proses.destroy', $pro->_id) }}" method="POST"
                                                style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Are you sure?')">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
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
    $('#proses-table').DataTable({
        autoWidth: false,
        language: {
            processing: "<i class='fa fa-spinner fa-spin'></i> Sedang memuat data..."
        }
    });
});
</script>
@endsection