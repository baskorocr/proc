@extends('layouts.main')
@section('title', 'Add Project')

@section('content')
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Add Project</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('projects.index') }}">Projects</a></li>
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

                        <form action="{{ route('projects.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="name_project" class="form-label">Project Name</label>
                                <input type="text" name="name_project" class="form-control" value="{{ old('name_project') }}"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label for="customer_id" class="form-label">Customer</label>
                                <select name="customer_id" class="form-select @error('customer_id') is-invalid @enderror" required>
                                    <option value="">Select Customer</option>
                                    @foreach($customers as $customer)
                                    <option value="{{ $customer->_id }}" {{ old('customer_id') == $customer->_id ? 'selected' : '' }}>
                                        {{ $customer->name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('customer_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-save"></i>
                                Save</button>
                            <a href="{{ route('projects.index') }}" class="btn btn-secondary btn-sm">Cancel</a>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </section>
</main>
@endsection