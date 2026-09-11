@extends('layouts.main')
@section('title', 'Add Asset')

@section('content')
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Add Asset</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('assetsPart.index') }}">Assets</a></li>
                <li class="breadcrumb-item active">Add</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body pt-3">
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <form action="{{ route('assetsPart.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="no_assets" class="form-label">Asset Number</label>
                                    <input type="text" name="no_assets" class="form-control"
                                        value="{{ old('no_assets') }}">
                                </div>



                                <div class="col-md-6 mb-3">
                                    <label for="project_id" class="form-label">Project</label>
                                    <select name="project_id" class="form-control" required>
                                        <option value="">Select Project</option>
                                        @foreach($projects as $project)
                                        <option value="{{ $project->_id }}"
                                            {{ old('project_id') == $project->_id ? 'selected' : '' }}>
                                            {{ $project->name_project }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="vendor_id" class="form-label">Vendor</label>
                                    <select name="vendor_id" class="form-control">
                                        <option value="">Select Vendor</option>
                                        @if($vendors->count() > 0)
                                            @foreach($vendors as $vendor)
                                            <option value="{{ $vendor->id_vendor }}"
                                                {{ old('vendor_id') == $vendor->id_vendor ? 'selected' : '' }}>
                                                {{ $vendor->nm_vendor }}
                                            </option>
                                            @endforeach
                                        @else
                                            <option disabled>No vendors available</option>
                                        @endif
                                    </select>
                                    @if($vendors->count() == 0)
                                        <small class="text-muted">Vendor data could not be loaded</small>
                                    @endif
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="pemiliks_id" class="form-label">Owner</label>
                                    <select name="pemiliks_id" class="form-control">
                                        <option value="">Select Owner</option>
                                        @foreach($pemiliks as $pemilik)
                                        <option value="{{ $pemilik->_id }}"
                                            {{ old('pemiliks_id') == $pemilik->_id ? 'selected' : '' }}>
                                            {{ $pemilik->name_pemilik }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="idPart" class="form-label">Part</label>
                                    <select name="idPart" id="idPart" class="form-control" required>
                                        <option value="">Select Part</option>
                                        @foreach($parts as $part)
                                        <option value="{{ $part->idPart }}"
                                            {{ old('idPart') == $part->idPart ? 'selected' : '' }}>
                                            {{ $part->part_name }} ({{ $part->idPart }})
                                        </option>
                                        @endforeach
                                    </select>
                                    <small class="text-muted">Ketik untuk mencari part</small>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="proses_id"
                                        class="form-label d-flex justify-content-between align-items-center">
                                        <span>Process</span>
                                        <button type="button" class="btn btn-link btn-sm p-0" data-bs-toggle="modal"
                                            data-bs-target="#addProsesModal">
                                            + Tambahkan Proses
                                        </button>
                                    </label>
                                    <select name="proses_id[]" id="proses_id" class="form-control" multiple required>
                                        @foreach($proses as $p)
                                        <option value="{{ $p->_id }}">
                                            {{ $p->proses_name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <small class="text-muted">Ketik untuk mencari dan pilih multiple proses</small>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="dies" class="form-label">Dies</label>
                                    <input type="text" name="dies" class="form-control" value="{{ old('dies') }}">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="Cavity" class="form-label">Cavity</label>
                                    <input type="text" name="Cavity" class="form-control" value="{{ old('Cavity') }}">
                                </div>


                                <div class="col-md-6 mb-3">
                                    <label for="machine" class="form-label">Machine</label>
                                    <input type="text" name="machine" class="form-control" value="{{ old('machine') }}"
                                        required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="jumlah" class="form-label">Quantity</label>
                                    <input type="number" name="jumlah" class="form-control" value="{{ old('jumlah') }}"
                                        required>
                                </div>

                            </div>

                            <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-save"></i>
                                Save</button>
                            <a href="{{ route('assetsPart.index') }}" class="btn btn-secondary btn-sm">Cancel</a>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- Modal Tambah Proses -->
    <div class="modal fade" id="addProsesModal" tabindex="-1" aria-labelledby="addProsesModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('proses.store') }}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addProsesModalLabel">Tambah Proses</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="proses_name" class="form-label">Nama Proses</label>
                            <input type="text" class="form-control" id="proses_name" name="proses_name" required>
                        </div>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary btn-sm">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</main>
@endsection

@section('javascript')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    // Initialize Select2 for Part
    $('#idPart').select2({
        placeholder: 'Cari dan pilih part...',
        allowClear: true,
        width: '100%'
    });

    // Initialize Select2 for Process (multiple)
    $('#proses_id').select2({
        placeholder: 'Cari dan pilih proses...',
        allowClear: true,
        width: '100%'
    });
});
</script>
@endsection