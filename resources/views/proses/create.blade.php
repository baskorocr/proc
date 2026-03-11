@extends('layouts.main')
@section('title', 'Add Proses')

@section('content')
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Add Proses</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('proses.index') }}">Proses</a></li>
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

                        <form action="{{ route('proses.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Proses Name</label>
                                <input type="text" name="proses_name" class="form-control" value="{{ old('proses_name') }}"
                                    required>
                            </div>

                            <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-save"></i>
                                Save</button>
                            <a href="{{ route('proses.index') }}" class="btn btn-secondary btn-sm">Cancel</a>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </section>
</main>
@endsection