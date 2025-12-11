@extends('layouts.auth')
@section('title', 'Add Product')
@section('content')
<div class="container mt-5">
    <h3 class="fw-bold mb-4">Add New Product</h3>
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label>Product Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Category</label>
                    <select name="category_id" class="form-select" required>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Price</label>
                        <input type="number" name="price" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Stock</label>
                        <input type="number" name="stock" class="form-control" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label>Description</label>
                    <textarea name="description" class="form-control" rows="3" required></textarea>
                </div>
                <div class="mb-4">
                    <label>Image</label>
                    <input type="file" name="image" class="form-control" required>
                </div>
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Upload Image</label>
                        <input type="file" name="image" class="form-control">
                        <small class="text-muted">Upload dari komputer.</small>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">OR Image URL</label>
                        <input type="url" name="image_url" class="form-control" placeholder="https://...">
                        <small class="text-muted">Paste link gambar dari internet.</small>
                    </div>
                </div>
                <button class="btn btn-dark w-100">Save Product</button>
            </form>
        </div>
    </div>
</div>
@endsection