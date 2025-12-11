@extends('layouts.auth')

@section('title', 'Add Campaign')

@section('content')
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">Add New Campaign</h3>
        <a href="{{ route('admin.campaigns.index') }}" class="btn btn-outline-dark btn-sm">Back</a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form action="{{ route('admin.campaigns.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Campaign Title</label>
                    <input type="text" name="title" class="form-control" placeholder="Contoh: Ramadhan Sale" required>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Start Date</label>
                        <input type="date" name="start_date" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">End Date</label>
                        <input type="date" name="end_date" class="form-control" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Banner Image</label>
                    <input type="file" name="banner_path" class="form-control" accept="image/*" required>
                    <div class="form-text">Format: JPG, PNG. Ukuran disarankan: 1200x400 px.</div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Redirect URL (Optional)</label>
                    <input type="url" name="redirect_url" class="form-control" placeholder="https://...">
                    <div class="form-text">Link halaman ketika banner diklik (opsional).</div>
                </div>

                <button type="submit" class="btn btn-dark w-100 py-2 fw-bold">SAVE CAMPAIGN</button>
            </form>
        </div>
    </div>
</div>
@endsection