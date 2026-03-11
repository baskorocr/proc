@extends('layouts.main')
@section('title', "Edit Part")
@section('content')
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Edit Part</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('parts.index') }}">Part</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-6">
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
                        
                        <form action="{{ route('parts.update', $part->idPart) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="idPart" class="form-label">Part ID</label>
                                <input type="text" class="form-control @error('idPart') is-invalid @enderror" id="idPart"
                                    name="idPart" value="{{ old('idPart', $part->idPart) }}" readonly>
                                @error('idPart')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="part_name" class="form-label">Part Name</label>
                                <input type="text" class="form-control @error('part_name') is-invalid @enderror" id="part_name"
                                    name="part_name" value="{{ old('part_name', $part->part_name) }}" required>
                                @error('part_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="spek_material" class="form-label">Material Specification</label>
                                <textarea class="form-control @error('spek_material') is-invalid @enderror" id="spek_material"
                                    name="spek_material" rows="3">{{ old('spek_material', $part->spek_material) }}</textarea>
                                @error('spek_material')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="photo" class="form-label">Part Image</label>
                                @if($part->photo)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/parts/' . $part->photo) }}" alt="{{ $part->part_name }}" class="img-thumbnail" style="max-height: 200px;">
                                </div>
                                @endif
                                <input type="file" name="photo" class="form-control @error('photo') is-invalid @enderror" accept="image/*">
                                <small class="text-muted">Allowed formats: JPG, JPEG, PNG. Max size: 2MB. Leave empty to keep current image.</small>
                                @error('photo')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-success">
                                <i class="fa fa-save"></i> Update
                            </button>
                            <a href="{{ route('parts.index') }}" class="btn btn-secondary">
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