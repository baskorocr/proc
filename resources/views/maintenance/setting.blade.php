@extends('layouts.main')
@section('title', 'Setting Maintenance')
@section('content')
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Setting Maintenance</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('mt-asset.index') }}">Maintenance</a></li>
                <li class="breadcrumb-item active">Setting</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-6">
                @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Interval Maintenance Berdasarkan Moving Type</h5>
                        <form method="POST" action="{{ route('mt-asset.setting.update') }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-bold">Interval Slow Moving (bulan)</label>
                                <input type="number" class="form-control" name="interval_slow_moving"
                                    value="{{ old('interval_slow_moving', $intervalSlowMoving) }}" min="1" max="24" required>
                                <small class="text-muted">Berlaku untuk asset dengan kategori Slow Moving</small>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Interval Standar Moving (bulan)</label>
                                <input type="number" class="form-control" name="interval_standar_moving"
                                    value="{{ old('interval_standar_moving', $intervalStandarMoving) }}" min="1" max="24" required>
                                <small class="text-muted">Berlaku untuk asset dengan kategori Standar Moving</small>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Interval Fast Moving (bulan)</label>
                                <input type="number" class="form-control" name="interval_fast_moving"
                                    value="{{ old('interval_fast_moving', $intervalFastMoving) }}" min="1" max="24" required>
                                <small class="text-muted">Berlaku untuk asset dengan kategori Fast Moving</small>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Simpan
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
