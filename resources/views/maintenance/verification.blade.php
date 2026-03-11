@extends('layouts.main')
@section('title', "Maintenance Verification")
@section('content')
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Maintenance Verification</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">Maintenance</li>
                <li class="breadcrumb-item active">Verification</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Maintenance Files for Verification</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered nowrap table-striped table-sm" id="verification-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Asset No</th>
                                        <th>Vendor</th>
                                        <th>Part</th>
                                        <th>Photo</th>
                                        <th>File Name</th>
                                        <th>Description</th>
                                        <th>Upload Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($maintenances as $maintenance)
                                  
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $maintenance->asset_no ?? '-' }}</td>
                                        <td>{{ optional($maintenance->vendor)->nm_vendor ?? '-' }}</td>
                                        <td>{{ optional($maintenance->asset->part)->part_name ?? '-' }}</td>
                                        <td>
                                            @if(optional($maintenance->asset->part)->photo)
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#photoModal"
                                                data-photo="{{ asset('storage/parts/' . $maintenance->asset->part->photo) }}">
                                                <img src="{{ asset('storage/parts/' . $maintenance->asset->part->photo) }}"
                                                    alt="photo" style="max-width: 60px; max-height: 60px;"
                                                    class="img-thumbnail">
                                            </a>
                                            @else
                                            <span class="text-muted">No Photo</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($maintenance->nama_file)
                                                <a href="{{ asset('storage/maintenance/' . $maintenance->nama_file) }}" 
                                                   target="_blank" class="text-primary">
                                                    {{ $maintenance->nama_file }}
                                                </a>
                                            @else
                                                <span class="text-muted">No File</span>
                                            @endif
                                        </td>
                                        <td>{{ $maintenance->deskripsi ?? '-' }}</td>
                                        <td>{{ $maintenance->created_at ? $maintenance->created_at->format('d/m/Y H:i') : '-' }}</td>
                                        <td>
                                            <div class="d-flex gap-1">
                                                <form method="POST" action="{{ route('maintenance.approve', $maintenance->_id) }}" class="d-inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn btn-success btn-sm" 
                                                        onclick="return confirm('Are you sure you want to approve this maintenance record?')">
                                                        <i class="fa fa-check"></i>
                                                    </button>
                                                </form>
                                                <button type="button" class="btn btn-danger btn-sm" 
                                                    data-bs-toggle="modal" data-bs-target="#rejectModal-{{ $maintenance->_id }}">
                                                    <i class="fa fa-times"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="9" class="text-center text-muted">
                                            <i class="bi bi-inbox"></i> No maintenance files pending verification
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div><!-- End Table -->
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Photo Modal --}}
    <div class="modal fade" id="photoModal" tabindex="-1" aria-labelledby="photoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <img id="modal-photo" src="" alt="Preview Photo" class="img-fluid rounded">
                </div>
            </div>
        </div>
    </div>

    {{-- Reject Modals --}}
    @foreach($maintenances as $maintenance)
    <div class="modal fade" id="rejectModal-{{ $maintenance->_id }}" tabindex="-1" aria-labelledby="rejectModalLabel-{{ $maintenance->_id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="rejectModalLabel-{{ $maintenance->_id }}">Reject Maintenance Record</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('maintenance.reject', $maintenance->_id) }}">
                    <div class="modal-body">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="reason-{{ $maintenance->_id }}" class="form-label">Reason for Rejection <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="reason-{{ $maintenance->_id }}" name="reason" rows="4" 
                                placeholder="Please provide a reason for rejecting this maintenance record..." required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Reject</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach



</main>
@endsection

@section('javascript')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize DataTable
    const table = document.getElementById('verification-table');
    const hasData = {{ count($maintenances) > 0 ? 'true' : 'false' }};
    
    if (table && typeof DataTable !== 'undefined' && hasData) {
        var dataTable = new DataTable(table, {
            autoWidth: false,
            order: [[7, 'desc']],
            columnDefs: [{ orderable: false, targets: [4,8] }],
            language: { processing: "<i class='fa fa-spinner fa-spin'></i> Loading..." }
        });
    }

    // Photo Modal Handler
    const photoModal = document.getElementById('photoModal');
    if (photoModal) {
        photoModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const photo = button.getAttribute('data-photo');
            const modalPhoto = document.getElementById('modal-photo');
            if (modalPhoto && photo) {
                modalPhoto.src = photo;
            }
        });
    }
});
</script>
@endsection
