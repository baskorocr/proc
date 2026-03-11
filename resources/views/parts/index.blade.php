@extends('layouts.main')
@section('title', "Part List")
@section('content')
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Part</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">Part</li>
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
                        <a href="{{ route('parts.create') }}" class="btn btn-primary btn-sm mt-3 mb-3">
                            <i class="fa fa-plus"></i> Add Part
                        </a>
                        <button type="button" class="btn btn-success btn-sm mt-3 mb-3" id="syncSapBtn">
                            <i class="fa fa-sync"></i> Sync from SAP
                        </button>
                        <div class="table-responsive">
                            <table class="table table-bordered nowrap table-striped table-sm" id="part-table">
                                <thead>
                                    <tr>
                                        <th><i class="fa fa-list"></i></th>
                                        <th>Part ID</th>
                                        <th>Part Name</th>
                                        <th>Material Specification</th>
                                        <th>Image</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($parts as $part)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $part->idPart }}</td>
                                        <td>{{ $part->part_name }}</td>
                                        <td>{{ $part->spek_material }}</td>
                                        <td>
                                            @if($part->photo)
                                            <img src="{{ asset('storage/parts/' . $part->photo) }}"
                                                alt="{{ $part->part_name }}" class="img-thumbnail"
                                                style="max-height: 50px;">
                                            @else
                                            <span class="text-muted">No image</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('parts.edit', $part->idPart) }}"
                                                class="btn btn-warning btn-sm">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <form action="{{ route('parts.destroy', $part->idPart) }}" method="POST"
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
    $('#part-table').DataTable({
        autoWidth: false,
        language: {
            processing: "<i class='fa fa-spinner fa-spin'></i> Sedang memuat data..."
        }
    });

    $('#syncSapBtn').click(function() {
        Swal.fire({
            title: 'Syncing Data',
            html: 'Mohon tunggu, sedang mengambil data dari SAP...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        $.ajax({
            url: '{{ route("parts.sync-sap") }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: response.message,
                    showConfirmButton: true
                }).then(() => {
                    location.reload();
                });
            },
            error: function(xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: xhr.responseJSON?.message || 'Terjadi kesalahan saat sync data',
                    showConfirmButton: true
                });
            }
        });
    });
});
</script>
@endsection