@extends('layouts.main')
@section('title', "Edit Proses")
@section('content')
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Edit Proses</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('proses.index') }}">Proses</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body pt-3">
                        <form action="{{ route('proses.update', $proses->_id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="name" class="form-label">Proses Name</label>
                                <input type="text" class="form-control @error('proses_name') is-invalid @enderror" id="name"
                                    name="proses_name" value="{{ old('proses_name', $proses->proses_name) }}" required>
                                @error('proses_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-success">
                                <i class="fa fa-save"></i> Update
                            </button>
                            <a href="{{ route('proses.index') }}" class="btn btn-secondary">
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