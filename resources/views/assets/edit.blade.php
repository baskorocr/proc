@extends('layouts.main')
@section('title', "Edit Asset")
@section('content')
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Edit Asset</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('assetsPart.index') }}">Assets</a></li>
                <li class="breadcrumb-item active">Edit</li>
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

                        <form action="{{ route('assetsPart.update', $asset->_id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            {{-- Hidden fields to preserve pagination and search --}}
                            @if(request('page'))
                                <input type="hidden" name="page" value="{{ request('page') }}">
                            @endif
                            @if(request('search'))
                                <input type="hidden" name="search" value="{{ request('search') }}">
                            @endif
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="no_assets" class="form-label">Asset Number</label>
                                    <input type="text" name="no_assets" class="form-control"
                                        value="{{ old('no_assets', $asset->no_assets) }}">
                                </div>



                                <div class="col-md-6 mb-3">
                                    <label for="project_id" class="form-label">Project</label>
                                    <select name="project_id" class="form-control" required>
                                        <option value="">Select Project</option>
                                        @foreach($projects as $project)
                                        <option value="{{ $project->_id }}"
                                            {{ old('project_id', $asset->project_id) == $project->_id ? 'selected' : '' }}>
                                            {{ $project->name_project }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="vendor_id" class="form-label">Vendor</label>
                                    <select name="vendor_id" class="form-control">
                                        <option value="">Select Vendor</option>
                                        @foreach($vendors as $vendor)
                                        <option value="{{ $vendor->id_vendor }}"
                                            {{ old('vendor_id', $asset->vendor_id) == $vendor->id_vendor ? 'selected' : '' }}>
                                            {{ $vendor->nm_vendor }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="pemiliks_id" class="form-label">Owner</label>
                                    <select name="pemiliks_id" class="form-control">
                                        <option value="">Select Owner</option>
                                        @foreach($pemiliks as $pemilik)
                                        <option value="{{ $pemilik->_id }}"
                                            {{ old('pemiliks_id', $asset->pemiliks_id) == $pemilik->_id ? 'selected' : '' }}>
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
                                            {{ old('idPart', $asset->idPart) == $part->idPart ? 'selected' : '' }}>
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
                                        <option value="{{ $p->_id }}"
                                            {{ (is_array(old('proses_id', $asset->proses_id)) && in_array($p->_id, old('proses_id', $asset->proses_id))) ? 'selected' : '' }}>
                                            {{ $p->proses_name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <small class="text-muted">Ketik untuk mencari dan pilih multiple proses</small>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="dies" class="form-label">Dies</label>
                                    <input type="text" name="dies" class="form-control" value="{{ old('dies', $asset->dies) }}">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="Cavity" class="form-label">Cavity</label>
                                    <input type="text" name="Cavity" class="form-control" value="{{ old('Cavity', $asset->Cavity) }}">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="machine" class="form-label">Machine</label>
                                    <input type="text" name="machine" class="form-control"
                                        value="{{ old('machine', $asset->machine) }}" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="jumlah" class="form-label">Quantity</label>
                                    <input type="number" name="jumlah" class="form-control"
                                        value="{{ old('jumlah', $asset->jumlah) }}" required>
                                </div>

                                
                                
                            </div>

                            <button type="submit" class="btn btn-success btn-sm">
                                <i class="fa fa-save"></i> Update
                            </button>
                            <a href="{{ route('assetsPart.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fa fa-arrow-left"></i> Back
                            </a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
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