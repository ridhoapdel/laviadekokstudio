@extends('layouts.auth')

@section('title', 'Edit Campaign')

@section('content')
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">Edit Campaign</h3>
        <a href="{{ route('admin.campaigns.index') }}" class="btn btn-outline-dark btn-sm">Back</a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form action="{{ route('admin.campaigns.update', $campaign->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Campaign Title</label>
                    <input type="text" name="title" class="form-control" value="{{ $campaign->title }}" required>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Start Date</label>
                        <input type="date" name="start_date" class="form-control" value="{{ $campaign->start_date }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">End Date</label>
                        <input type="date" name="end_date" class="form-control" value="{{ $campaign->end_date }}" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Current Banner</label><br>
                    <img src="{{ asset('storage/' . $campaign->banner_path) }}" class="img-fluid rounded mb-2 border" style="max-height: 150px;">
                    
                    <label class="form-label d-block mt-2">Change Banner (Optional)</label>
                    <input type="file" name="banner_path" class="form-control" accept="image/*">
                    <div class="form-text">Biarkan kosong jika tidak ingin mengubah gambar.</div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Redirect URL (Optional)</label>
                    <input type="url" name="redirect_url" class="form-control" value="{{ $campaign->redirect_url }}">
                </div>

                <button type="submit" class="btn btn-warning w-100 py-2 fw-bold">UPDATE CAMPAIGN</button>
            </form>
        </div>
    </div>
</div>
@endsection