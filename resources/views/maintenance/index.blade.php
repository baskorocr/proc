@extends('layouts.main')

@section('title', 'Asset List')

@section('content')
<main id="main" class="main">

    <!-- Page Title & Breadcrumb -->
    <div class="pagetitle">
        <h1>Assets</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">Assets</li>
            </ol>
        </nav>
    </div>

    <!-- Main Section -->
    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <!-- Success Message -->
                @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif

                <!-- Summary Cards -->
                <div class="row gy-4 mb-4">
                    <div class="col-md-6 col-xl-4">
                        <div class="card text-center h-100 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">Total Assets Needing Maintenance</h5>
                                <h3 class="text-primary">{{ $count }}</h3>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-xl-4">
                        <div class="card text-center h-100 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">Total Assets</h5>
                                <h3 class="text-success">{{ $countTotal }}</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Assets Needing Maintenance Table -->
                

                <!-- Other Recent Assets Table -->
            

                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title">Other Recent Assets</h5>
                            <div>
                                
                                <a href="{{ route('mt-asset.export') }}" class="btn btn-success btn-sm">
                                    <i class="fa fa-file-excel"></i> Export Excel
                                </a>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-sm" id="recent-assets-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Asset No</th>
                                        <th>Vendor</th>
                                        <th>Part</th>
                                       
                                        <th>Dies</th>
                                        <th>Process</th>
                                        <th>Quantity</th>
                                        <th>Moving Type</th>
                                        <th>Next Maintenance</th>
                                        <th>status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($assetsRecent as $asset)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $asset->no_assets ?? '-' }}</td>
                                        <td>{{ optional( $asset->vendor)->nm_vendor ?? '-' }}</td>

                                        <td>{{ $asset->part->part_name ?? '-' }}</td>
                                       
                                        <td>{{ (!empty($asset->dies) && $asset->dies !== 'nan') ? $asset->dies : '-' }}</td>
                                        <td>
                                            @php
                                                $prosesNames = [];
                                                if(is_array($asset->proses_id)) {
                                                    foreach($asset->proses_id as $pid) {
                                                        $p = \App\Models\masterData\Proses::find($pid);
                                                        if($p) $prosesNames[] = $p->proses_name;
                                                    }
                                                } elseif($asset->proses_id) {
                                                    $p = \App\Models\masterData\Proses::find($asset->proses_id);
                                                    if($p) $prosesNames[] = $p->proses_name;
                                                }
                                            @endphp
                                            {{ !empty($prosesNames) ? implode(', ', $prosesNames) : '-' }}
                                        </td>
                                        <td>{{ $asset->jumlah }}</td>
                           
                                   
                                        <td>
                                            @if($asset->scheduleKunjungans && $asset->scheduleKunjungans->moving_type)
                                                @php
                                                    $movingTypeLabel = [
                                                        'slow_moving' => '<span class="badge bg-info">Slow Moving</span>',
                                                        'standar_moving' => '<span class="badge bg-primary">Standar Moving</span>',
                                                        'fast_moving' => '<span class="badge bg-warning">Fast Moving</span>',
                                                    ];
                                                @endphp
                                                {!! $movingTypeLabel[$asset->scheduleKunjungans->moving_type] ?? '<span class="badge bg-secondary">-</span>' !!}
                                            @else
                                                <span class="badge bg-secondary">-</span>
                                            @endif
                                        </td>
                                        <td>{{ optional($asset->scheduleKunjungans)->waktu_kunjungan }}</td>


                                      
                                      

                                        <td>
                                            @php
                                                $latestMt = $asset->maintenances ? $asset->maintenances->sortByDesc('created_at')->first() : null;
                                                $isPending = $latestMt && $latestMt->status == 0;
                                            @endphp

                                            @if($isPending)
                                                <span class="badge bg-warning">Menunggu Approval</span>
                                            @elseif($asset->scheduleKunjungans && $asset->scheduleKunjungans->waktu_kunjungan)
                                                @php
                                                    $waktuKunjungan = \Carbon\Carbon::parse($asset->scheduleKunjungans->waktu_kunjungan);
                                                @endphp
                                                @if($waktuKunjungan->isToday() || $waktuKunjungan->isPast())
                                                    <span class="badge bg-danger">Maintenance Segera</span>
                                                @else
                                                    <span class="badge bg-success">Terjadwal</span>
                                                @endif
                                            @else
                                                <span class="badge bg-secondary">Belum Dijadwalkan</span>
                                            @endif
                                        </td>
                                        <td>
                                            @php
                                                $latestMaintenance = $asset->maintenances ? $asset->maintenances->sortByDesc('created_at')->first() : null;
                                                $hasSchedule = $asset->scheduleKunjungans && $asset->scheduleKunjungans->waktu_kunjungan;
                                                $waktuKunjungan = $hasSchedule ? \Carbon\Carbon::parse($asset->scheduleKunjungans->waktu_kunjungan) : null;
                                                $isOverdue = $waktuKunjungan && ($waktuKunjungan->isToday() || $waktuKunjungan->isPast());
                                            @endphp

                                            @php
                                                $isPendingAction = $latestMaintenance && $latestMaintenance->status == 0;
                                            @endphp

                                            @php
                                                $isRejected = $latestMaintenance && $latestMaintenance->status == 1;
                                            @endphp

                                            {{-- Tombol Maintenance: muncul saat Maintenance Segera, hide jika pending/rejected --}}
                                            @if($hasSchedule && $isOverdue && !$isRejected)
                                                @if($isPendingAction)
                                                    <button type="button" class="btn btn-sm btn-secondary" disabled>
                                                        Menunggu Approval
                                                    </button>
                                                @else
                                                    <button type="button" class="btn btn-sm btn-primary btn-maintenance" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#maintenanceUploadModal"
                                                            data-asset-status="{{ 0 }}"
                                                            data-asset-id="{{ $asset->no_assets }}"
                                                            data-asset-no="{{ $asset->no_assets }}"
                                                            data-vendor-id="{{ $asset->vendor_id }}">
                                                        Maintenance
                                                    </button>
                                                @endif
                                            @endif

                                            {{-- Tombol Upload ulang: muncul saat maintenance ditolak --}}
                                            @if($isRejected)
                                                <button type="button" class="btn btn-sm btn-primary btn-maintenance" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#maintenanceUploadModal"
                                                    data-asset-status="{{ 1 }}"
                                                    data-asset-id="{{ $asset->no_assets }}"
                                                    data-asset-no="{{ $asset->no_assets }}"
                                                    data-vendor-id="{{ $asset->vendor_id }}">
                                                    Upload ulang
                                                </button>
                                            @endif

                                            {{-- Tombol Reschedule: muncul saat ada jadwal (Terjadwal atau Maintenance Segera) --}}
                                            @if($hasSchedule)
                                                <button type="button" class="btn btn-sm btn-warning btn-reschedule" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#rescheduleModal"
                                                        data-id="{{ $asset->scheduleKunjungans->id }}"
                                                        data-asset="{{ $asset->no_assets }}"
                                                        data-waktu="{{ $asset->scheduleKunjungans->waktu_kunjungan }}"
                                                        data-moving-type="{{ $asset->scheduleKunjungans->moving_type ?? '' }}">
                                                    Reschedule
                                                </button>
                                            @else
                                                {{-- Tombol Schedule: muncul saat belum dijadwalkan --}}
                                                <button type="button" class="btn btn-sm btn-success btn-reschedule" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#rescheduleModal"
                                                        data-id=""
                                                        data-asset="{{ $asset->no_assets }}"
                                                        data-waktu=""
                                                        data-moving-type="">
                                                    Schedule
                                                </button>
                                            @endif
                                        </td>
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

    <!-- Photo Preview Modal -->
    <div class="modal fade" id="photoModal" tabindex="-1" aria-labelledby="photoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <img id="modal-photo" src="" alt="Preview Photo" class="img-fluid rounded">
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Reschedule -->
<div class="modal fade" id="rescheduleModal" tabindex="-1" aria-labelledby="rescheduleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('kunjungan.reschedule') }}" method="POST">
            @csrf
            <input type="hidden" name="kunjungan_id" id="modal_kunjungan_id">
            <input type="hidden" name="asset_id" id="modal_asset_id">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="rescheduleModalLabel">Reschedule Kunjungan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="new_waktu_kunjungan" class="form-label">Reschedule</label>
                        <input type="datetime-local" class="form-control" id="new_waktu_kunjungan" name="new_waktu_kunjungan" required>
                    </div>
                    <div class="mb-3">
                        <label for="moving_type" class="form-label">Moving Type</label>
                        <select class="form-select" id="moving_type" name="moving_type" required>
                            <option value="">-- Pilih Moving Type --</option>
                            <option value="slow_moving">Slow Moving</option>
                            <option value="standar_moving">Standar Moving</option>
                            <option value="fast_moving">Fast Moving</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Save Changes</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>


  
  
    
    <!-- Modal: Upload File Maintenance -->
    <div class="modal fade" id="maintenanceUploadModal" tabindex="-1" aria-labelledby="maintenanceUploadModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('maintenance.upload') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="asset_id" id="upload_asset_id">
                <input type="hidden" name="status" id="status">
                <input type="hidden" name="vendor_id" id="upload_vendor_id">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="maintenanceUploadModalLabel">Upload File Maintenance</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Asset No:</strong> <span id="upload_asset_no"></span></p>
                        
                        <div class="mb-3">
                            <label for="maintenance_file" class="form-label">Upload File (PDF)</label>
                            <input type="file" class="form-control" name="maintenance_file" id="maintenance_file" 
                                   accept=".pdf" required>
                            <div class="form-text">File yang diizinkan: PNG dan PDF (maksimal 10MB)</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi (Opsional)</label>
                            <textarea class="form-control" name="description" id="description" rows="3" 
                                      placeholder="Tambahkan deskripsi maintenance..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" id="btn-upload-submit">Upload File</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</main>
@endsection

@section('javascript')
<script>
    $(document).ready(function () {
        $('#old-assets-table, #recent-assets-table').DataTable({
            autoWidth: false,
            language: {
                processing: "<i class='fa fa-spinner fa-spin'></i> Loading..."
            }
        });

        // Tampilkan preview foto
        $('#photoModal').on('show.bs.modal', function (event) {
            const img = $(event.relatedTarget);
            const photo = img.data('photo');
            $('#modal-photo').attr('src', photo);
        });

        // Isi data modal kunjungan
        $('.btn-schedule').on('click', function () {
            const id = $(this).data('id');
            const no = $(this).data('no');
            const part = $(this).data('part');
        

            $('#modal_asset_id').val(id);
            $('#modal_asset_no').text(no);
            $('#modal_part_name').text(part);
        
        });
        
        // Handle maintenance upload modal
        $(document).on('click', '.btn-maintenance', function () {
            const assetId = $(this).data('asset-id');
            const assetNo = $(this).data('asset-no');
            const vendorId = $(this).data('vendor-id');
            const status = $(this).data('asset-status');

            $('#status').val(status);
            $('#upload_asset_id').val(assetId);
            $('#upload_asset_no').text(assetNo);
            $('#upload_vendor_id').val(vendorId);
        });

        // Disable button upload saat submit agar tidak double klik
        $('#maintenanceUploadModal form').on('submit', function () {
            var btn = $('#btn-upload-submit');
            btn.prop('disabled', true).text('Uploading...');
        });
        $(document).on('click', '.btn-reschedule', function () {
            var kunjunganId = $(this).data('id');
            var waktuKunjungan = $(this).data('waktu');
            var assetId = $(this).data('asset');
            var movingType = $(this).data('moving-type');

            $('#modal_kunjungan_id').val(kunjunganId);
            $('#modal_asset_id').val(assetId);
            $('#new_waktu_kunjungan').val(waktuKunjungan);
            $('#moving_type').val(movingType);
        });
    });
</script>
@endsection
