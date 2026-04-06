@extends('layouts.main')
@section('title', "Riwayat Reschedule")
@section('content')
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Riwayat Reschedule</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('mt-asset.index') }}">Maintenance</a></li>
                <li class="breadcrumb-item active">Riwayat Reschedule</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('mt-asset.riwayat-reschedule') }}" method="GET" class="d-flex align-items-end gap-2 mt-3 mb-3">
                            <div>
                                <label class="form-label mb-1">Vendor</label>
                                <select name="vendor_id" class="form-select form-select-sm" style="width: 300px;">
                                    <option value="">-- Semua Vendor --</option>
                                    @foreach($vendors as $vendor)
                                    <option value="{{ $vendor->id_vendor }}" {{ request('vendor_id') == $vendor->id_vendor ? 'selected' : '' }}>
                                        {{ $vendor->nm_vendor }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-filter"></i> Filter</button>
                            @if(request('vendor_id'))
                            <a href="{{ route('mt-asset.riwayat-reschedule') }}" class="btn btn-secondary btn-sm"><i class="fa fa-times"></i> Reset</a>
                            @endif
                        </form>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-sm" id="reschedule-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>No. Asset</th>
                                        <th>Part Name</th>
                                        <th>Vendor</th>
                                        <th>Diubah Oleh</th>
                                        <th>Jadwal Lama</th>
                                        <th>Jadwal Baru</th>
                                        <th>Waktu Perubahan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($logs as $log)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $log->asset_id ?? '-' }}</td>
                                        <td>{{ optional($log->asset)->part ? $log->asset->part->part_name : '-' }}</td>
                                        <td>{{ optional($log->vendor)->nm_vendor ?? '-' }}</td>
                                        <td>{{ $log->user_name ?? '-' }}</td>
                                        <td>
                                            @php
                                                $old = $log->getRawOriginal('old_date') ?? $log->getAttributes()['old_date'] ?? null;
                                                if ($old instanceof \MongoDB\BSON\UTCDateTime) {
                                                    $old = $old->toDateTime()->format('d-m-Y H:i');
                                                } elseif ($old instanceof \Carbon\Carbon) {
                                                    $old = $old->format('d-m-Y H:i');
                                                } elseif (is_array($old) && isset($old['date'])) {
                                                    $old = \Carbon\Carbon::parse($old['date'])->format('d-m-Y H:i');
                                                } elseif (!is_string($old)) {
                                                    $old = '-';
                                                }
                                            @endphp
                                            {{ $old }}
                                        </td>
                                        <td>
                                            @php
                                                $new = $log->getRawOriginal('new_date') ?? $log->getAttributes()['new_date'] ?? null;
                                                if ($new instanceof \MongoDB\BSON\UTCDateTime) {
                                                    $new = $new->toDateTime()->format('d-m-Y H:i');
                                                } elseif ($new instanceof \Carbon\Carbon) {
                                                    $new = $new->format('d-m-Y H:i');
                                                } elseif (is_array($new) && isset($new['date'])) {
                                                    $new = \Carbon\Carbon::parse($new['date'])->format('d-m-Y H:i');
                                                } elseif (!is_string($new)) {
                                                    $new = '-';
                                                }
                                            @endphp
                                            {{ $new }}
                                        </td>
                                        <td>{{ $log->created_at ? $log->created_at->format('d-m-Y H:i') : '-' }}</td>
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
    $('#reschedule-table').DataTable({
        autoWidth: false,
        order: [[7, 'desc']],
        language: {
            processing: "<i class='fa fa-spinner fa-spin'></i> Loading..."
        }
    });
});
</script>
@endsection
