@extends('layouts.main')
@section('title', 'Add Part')

@section('content')
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Add Part</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('parts.index') }}">Part</a></li>
                <li class="breadcrumb-item active">Add</li>
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

                        <form action="{{ route('parts.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="idPart" class="form-label">Part ID</label>
                                <input type="text" name="idPart" class="form-control @error('idPart') is-invalid @enderror" value="{{ old('idPart') }}"
                                    required>
                                @error('idPart')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="part_name" class="form-label">Part Name</label>
                                <input type="text" name="part_name" class="form-control @error('part_name') is-invalid @enderror" value="{{ old('part_name') }}"
                                    required>
                                @error('part_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="spek_material" class="form-label">Material Specification</label>
                                <textarea name="spek_material" class="form-control @error('spek_material') is-invalid @enderror" rows="3">{{ old('spek_material') }}</textarea>
                                @error('spek_material')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="photo" class="form-label">Part Image</label>
                                <input type="file" name="photo" class="form-control @error('photo') is-invalid @enderror" accept="image/*">
                                <small class="text-muted">Allowed formats: JPG, JPEG, PNG. Max size: 2MB</small>
                                @error('photo')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-save"></i>
                                Save</button>
                            <a href="{{ route('parts.index') }}" class="btn btn-secondary btn-sm">Cancel</a>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </section>
</main>
@endsection