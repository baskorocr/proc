@extends('layouts.main')
@section('title', "Asset List")
@section('content')
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Assets</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">Assets</li>
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
                
                @if($errors->has('import'))
                <div class="alert alert-danger">
                    <strong>Import Errors:</strong>
                    <ul class="mb-0">
                        @foreach($errors->get('import') as $errorList)
                            @if(is_array($errorList))
                                @foreach($errorList as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            @else
                                <li>{{ $errorList }}</li>
                            @endif
                        @endforeach
                    </ul>
                </div>
                @endif
                
                @if($errors->has('excel_file'))
                <div class="alert alert-danger">
                    {{ $errors->first('excel_file') }}
                </div>
                @endif

                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mt-3 mb-3">
                            <div>
                                <a href="{{ route('assetsPart.create') }}" class="btn btn-primary btn-sm">
                                    <i class="fa fa-plus"></i> Add Asset
                                </a>
                                <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#importModal">
                                    <i class="fa fa-upload"></i> Import Excel
                                </button>
                                <button type="button" class="btn btn-info btn-sm" id="exportExcel">
                                    <i class="fa fa-download"></i> Export Excel
                                </button>
                                <button type="button" class="btn btn-danger btn-sm" id="bulkDeleteBtn" style="display:none;">
                                    <i class="fa fa-trash"></i> Delete Selected
                                </button>
                            </div>
                            <div>
                                <form action="{{ route('assetsPart.index') }}" method="GET" class="d-flex gap-2">
                                    <input type="text" name="search" class="form-control form-control-sm" 
                                           placeholder="Search..." value="{{ request('search') }}" style="width: 250px;">
                                    <button type="submit" class="btn btn-primary btn-sm">
                                        <i class="fa fa-search"></i>
                                    </button>
                                    @if(request('search'))
                                    <a href="{{ route('assetsPart.index') }}" class="btn btn-secondary btn-sm">
                                        <i class="fa fa-times"></i>
                                    </a>
                                    @endif
                                </form>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered nowrap table-striped table-sm" id="assets-table">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" id="selectAll"></th>
                                        <th><i class="fa fa-list"></i></th>
                                        <th>No. Asset</th>
                                        <th>Vendor</th>
                                        <th>Customer</th>
                                        <th>Project</th>
                                        <th>Owner</th>
                                        <th>Part ID</th>
                                        <th>Part Name</th>
                                        <th>Dies</th>
                                        <th>Process</th>
                                        <th>Cavity</th>
                                        <th>Machine</th>
                                        <th>Quantity</th>
                                        <th>Part Photo</th>
                                        <th>Action</th>
                                    </tr>

                                </thead>
                                <tbody>
                                    @foreach($assets as $asset)
                              
                                    <tr>
                                        <td><input type="checkbox" class="asset-checkbox" value="{{ $asset->_id }}"></td>
                                        <td>{{ ($assets->currentPage() - 1) * $assets->perPage() + $loop->iteration }}</td>
                                        <td>{{ $asset->no_assets }}</td>
                                     
                                        <td>{{ optional($asset->vendor)->nm_vendor ?? '-' }}</td>
                                        <td>{{ $asset->project && $asset->project->customer ? $asset->project->customer->name : '-' }}</td>
                                        <td>{{ optional($asset->project)->name_project }}</td>
                                        

                                        <td>{{ optional($asset->pemilik)->name_pemilik }}</td>
                                        <td>{{ optional($asset->part)->idPart }}</td>
                                        <td>{{ optional($asset->part)->part_name ?? $asset->idPart }}</td>
                                   
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
                                        
                                        <td>{{ (!empty($asset->Cavity) && $asset->Cavity !== 'nan') ? $asset->Cavity : '-' }}</td>
                                        <td>{{ $asset->machine }}</td>
                                        <td>{{ $asset->jumlah }}</td>
                                        <td>
                                            @if(!empty($asset->part->photo))
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#photoModal"
                                                data-photo="{{ asset('storage/parts/' . $asset->part->photo) }}">
                                                <img src="{{ asset('storage/parts/' . $asset->part->photo) }}"
                                                    alt="Part Photo" style="max-width: 60px; max-height: 60px;"
                                                    class="img-thumbnail">
                                            </a>
                                            @else
                                            <span class="text-muted">No Photo</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('assetsPart.edit', $asset->_id) }}{{ request()->getQueryString() ? '?' . request()->getQueryString() : '' }}"
                                                class="btn btn-warning btn-sm">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                           
                                      

                                            <a href="#" class="btn btn-info btn-sm btn-move" data-bs-toggle="modal"
                                                data-bs-target="#moveModal" data-no="{{ $asset->no_assets }}"
                                                data-owner="{{ $asset->pemilik->_id ?? '' }}"
                                                data-ownername="{{ $asset->pemilik->name_pemilik ?? '-' }}"
                                                data-statusawal="{{ optional($asset->vendor)->id_vendor}}"
                                                data-vendor="{{ optional($asset->vendor)->id }}"
                                                data-jumlah="{{ $asset->jumlah }}">
                                                <i class="fa fa-exchange-alt"></i> Move
                                            </a>
                                            <form action="{{ route('assetsPart.destroy', $asset->_id) }}"
                                                method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                @if(request('page'))
                                                    <input type="hidden" name="page" value="{{ request('page') }}">
                                                @endif
                                                @if(request('search'))
                                                    <input type="hidden" name="search" value="{{ request('search') }}">
                                                @endif
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
                            
                            {{-- Pagination Links --}}
                            {{-- <div class="d-flex justify-content-end mt-3">
                                {{ $assets->links() }}
                            </div> --}}
                        </div><!-- End Table -->
                        
                        {{-- Pagination Links --}}
                        <div class="d-flex justify-content-end mt-3">
                            {{ $assets->links() }}
                        </div>
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

    {{-- Move Modal --}}
    {{-- Move Modal --}}
    <div class="modal fade" id="moveModal" tabindex="-1" aria-labelledby="moveModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form id="moveForm" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Ganti Vendor Asset</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        {{-- Hidden Fields --}}
                        <input type="hidden" id="asset_no" name="no_assets">
                        <input type="hidden" id="old_vendor_id" name="old_vendor_id">

                        {{-- Informasi Pemilik (Read-only opsional) --}}
                        <div class="mb-3">
                            <label for="current_owner" class="form-label">Pemilik</label>
                            <input type="text" id="current_owner" class="form-control" readonly>
                        </div>

                        {{-- Pilih Vendor Baru --}}
                        <div class="mb-3">
                            <label for="new_vendor_id" class="form-label">Vendor Baru</label>
                            <select name="new_vendor_id" id="new_vendor_id" class="form-select" required>
                                <option disabled selected>-- Pilih Vendor --</option>
                                @foreach($vendors as $vendor)
                                <option value="{{ $vendor->id_vendor }}">{{ $vendor->nm_vendor }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Jumlah (readonly) --}}
                        <div class="mb-3">
                            <label for="jumlah" class="form-label">Jumlah</label>
                            <input type="number" name="jumlah" id="jumlah" class="form-control" readonly>
                        </div>

                        {{-- Bukti Pemindahan --}}
                        <div class="mb-3">
                            <label for="bukti_pemindahan" class="form-label">Bukti Pemindahan</label>
                            <input type="file" name="bukti_pemindahan" id="bukti_pemindahan" class="form-control"
                                accept="image/*,application/pdf" required>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Simpan</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Import Modal --}}
    <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form action="{{ route('assetsPart.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Import Assets from Excel</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="excel_file" class="form-label">Excel File</label>
                            <input type="file" name="excel_file" id="excel_file" class="form-control" 
                                   accept=".xlsx,.xls" required>
                            <div class="form-text">
                                Maximum file size: 20MB. Only .xlsx and .xls files are allowed.
                            </div>
                        </div>
                        
                        <div class="alert alert-info">
                            <strong>Excel Template Format:</strong><br>
                            <small>Download template: <a href="{{ asset('template_eproc.xlsx') }}" class="text-decoration-none">template_eproc.xlsx</a></small><br><br>
                            <strong>Required Columns:</strong><br>
                            Column A: No Asset (e.g., 8200002222)<br>
                            Column B: Vendor ID <strong>(required, e.g., 102141)</strong><br>
                            Column C: Project Name (e.g., D26)<br>
                            Column D: Part ID <strong>(required, e.g., A4ADMD55MBR0009S)</strong><br>
                            Column E: Proses1 <strong>(required, e.g., BLANK)</strong><br>
                            Column F: Proses2 (optional, e.g., FORMING)<br>
                            Column G: Proses3 (optional, e.g., PIERCING)<br>
                            ... (you can add more proses columns)<br>
                            Column X: Dies (e.g., 1)<br>
                            Column X+1: Mesin (e.g., 160)<br>
                            Column X+2: Quantity (e.g., 1)<br>
                            Column X+3: Cavity (e.g., 1)<br>
                            Column X+4: Owner Name (optional, e.g., 1)<br><br>
                            <strong>Important:</strong> Proses1 is required, Proses2, Proses3, etc are optional. Dies column must contain numeric value.
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">
                            <i class="fa fa-upload"></i> Import
                        </button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


</main>
@endsection

@section('javascript')
<script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
<script>
$(document).ready(function() {
    // Initialize DataTables
    var table = $('#assets-table').DataTable({
        autoWidth: false,
        paging: false,
        info: false,
        searching: false,
        language: {
            processing: "<i class='fa fa-spinner fa-spin'></i> Loading..."
        },
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excelHtml5',
                text: 'Export',
                className: 'd-none',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]
                },
                filename: 'assets_' + new Date().getTime()
            }
        ]
    });
    
    // Export to Excel
    $('#exportExcel').on('click', function() {
        table.button(0).trigger();
    });
    
    $('#photoModal').on('show.bs.modal', function(event) {
        const photo = $(event.relatedTarget).data('photo');
        $('#modal-photo').attr('src', photo);
    });

    $('#moveModal').on('show.bs.modal', function(event) {
        const button = $(event.relatedTarget);
        const no = button.data('no');
        const ownerId = button.data('owner');
        const ownerName = button.data('ownername');
        const jumlah = button.data('jumlah');
        const oldVendorId = button.data('statusawal');
        const newVendorId = button.data('vendor');

        $('#asset_no').val(no);
        $('#old_vendor_id').val(oldVendorId);
        $('#new_vendor_id').val(newVendorId);
        $('#jumlah').val(jumlah);
        $('#current_owner').val(ownerName);

        const url = '{{ route("assetsPart.move", ":no") }}'.replace(':no', no);
        $('#moveForm').attr('action', url);
    });

    // Select All Checkbox
    $('#selectAll').on('change', function() {
        $('.asset-checkbox').prop('checked', this.checked);
        toggleBulkDeleteBtn();
    });

    // Individual Checkbox
    $('.asset-checkbox').on('change', function() {
        toggleBulkDeleteBtn();
    });

    function toggleBulkDeleteBtn() {
        const checkedCount = $('.asset-checkbox:checked').length;
        if (checkedCount > 0) {
            $('#bulkDeleteBtn').show();
        } else {
            $('#bulkDeleteBtn').hide();
        }
    }

    // Bulk Delete
    $('#bulkDeleteBtn').on('click', function() {
        const selectedIds = [];
        $('.asset-checkbox:checked').each(function() {
            selectedIds.push($(this).val());
        });

        if (selectedIds.length === 0) {
            Swal.fire('Error', 'Please select assets to delete', 'error');
            return;
        }

        Swal.fire({
            title: 'Are you sure?',
            text: `You will delete ${selectedIds.length} asset(s)`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete them!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ route("assetsPart.bulkDelete") }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        ids: selectedIds
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire('Deleted!', response.message, 'success').then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire('Error', response.message, 'error');
                        }
                    },
                    error: function(xhr) {
                        Swal.fire('Error', 'Failed to delete assets', 'error');
                    }
                });
            }
        });
    });
});
</script>
@endsection