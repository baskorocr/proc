@extends('layouts.main')
@section('title', "Asset Type List")
@section('content')
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Asset Type</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">Asset Type</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div class="card">
                    <div class="card-body">
                        <a href="{{ route('asset-types.create') }}" class="btn btn-primary btn-sm mt-3 mb-3">
                            <i class="fa fa-plus"></i> Add Asset Type
                        </a>
                        <div class="table-responsive">
                            <table class="table table-bordered nowrap table-striped table-sm" id="asset-type-table">
                                <thead>
                                    <tr>
                                        <th><i class="fa fa-list"></i></th>
                                        <th>Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($assetTypes as $assetType)

                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $assetType->name }}</td>
                                        <td>
                                            <a href="{{ route('asset-types.edit', $assetType->id) }}"
                                                class="btn btn-warning btn-sm">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <form action="{{ route('asset-types.destroy', $assetType->id) }}"
                                                method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
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
                        </div><!-- End Table -->
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection

@section('javascript')
<script>
$(document).ready(function() {
    $('#asset-type-table').DataTable({
        autoWidth: false,
        language: {
            processing: "<i class='fa fa-spinner fa-spin'></i> Sedang memuat data..."
        }
    });
});
</script>
@endsection