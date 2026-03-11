@extends('layouts.main')
@section('title', "Riwayat Maintenance Asset")
@section('content')
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Riwayat Maintenance Asset</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('mt-asset.index') }}">Maintenance</a></li>
                <li class="breadcrumb-item active">Riwayat</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive mt-3">
                            <table class="table table-bordered table-striped table-sm" id="riwayat-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>No. Asset</th>
                                        <th>Part Name</th>
                                        <th>Vendor</th>
                                        <th>File Maintenance</th>
                                        <th>Deskripsi</th>
                                        <th>Status</th>
                                        <th>Waktu Upload</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($maintenances as $maintenance)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $maintenance->asset_no }}</td>
                                        <td>{{ optional($maintenance->asset->part)->part_name ?? '-' }}</td>
                                        <td>{{ optional($maintenance->vendor)->nm_vendor ?? '-' }}</td>
                                        <td>
                                            @if($maintenance->nama_file)
                                            <a href="{{ asset('storage/maintenance/' . $maintenance->nama_file) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-file-earmark-pdf"></i> Lihat File
                                            </a>
                                            @else
                                            <span class="text-muted">Tidak Ada</span>
                                            @endif
                                        </td>
                                        <td>{{ $maintenance->deskripsi ?? '-' }}</td>
                                        <td>
                                            @if($maintenance->status == 0)
                                            <span class="badge bg-warning">Pending</span>
                                            @elseif($maintenance->status == 2)
                                            <span class="badge bg-success">Approved</span>
                                            @else
                                            <span class="badge bg-secondary">-</span>
                                            @endif
                                        </td>
                                        <td>{{ $maintenance->created_at ? $maintenance->created_at->format('d-m-Y H:i') : '-' }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
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
    $('#riwayat-table').DataTable({
        autoWidth: false,
        order: [[7, 'desc']],
        language: {
            processing: "<i class='fa fa-spinner fa-spin'></i> Loading..."
        }
    });
});
</script>
@endsection
