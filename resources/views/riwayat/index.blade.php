@extends('layouts.main')
@section('title', "Riwayat Pemindahan Asset")
@section('content')
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Riwayat Pemindahan Asset</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">Riwayat Pemindahan</li>
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
                                        <th>User</th>
                                        <th>Status Awal (Vendor)</th>
                                        <th>Status Akhir (Vendor)</th>
                                        <th>Bukti Pemindahan</th>
                                        <th>Waktu Pemindahan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($riwayats as $riwayat)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $riwayat->no_assets }}</td>
                                        <td>{{ optional($riwayat->user)->nm_user ?? '-' }}</td>
                                        <td>{{ optional($riwayat->statusAwalVendor)->nm_vendor ?? '-' }}</td>
                                        <td>{{ optional($riwayat->statusAkhirVendor)->nm_vendor ?? '-' }}</td>
                                        <td>

                                            @if(is_array($riwayat->bukti) && count($riwayat->bukti) > 0)
                                            @foreach($riwayat->bukti as $file)
                                            <a href="{{ asset('storage/bukti/' . $file) }}" target="_blank"
                                                class="btn btn-sm btn-outline-primary mb-1">
                                                Lihat Bukti
                                            </a><br>
                                            @endforeach
                                            @elseif(is_string($riwayat->bukti) && $riwayat->bukti !== '')
                                            <a href="{{ asset('storage/bukti/' . $riwayat->bukti) }}" target="_blank"
                                                class="btn btn-sm btn-outline-primary">
                                                Lihat Bukti
                                            </a>
                                            @else
                                            <span class="text-muted">Tidak Ada</span>
                                            @endif
                                        </td>
                                        <td>{{ $riwayat->created_at->format('d-m-Y H:i') }}</td>
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
    $('#riwayat-table').DataTable({
        autoWidth: false,
        language: {
            processing: "<i class='fa fa-spinner fa-spin'></i> Loading..."
        }
    });
});
</script>
@endsection