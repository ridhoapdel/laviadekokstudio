@extends('layouts.auth')
@section('title', 'Edit Product')
@section('content')
<div class="container mt-5">
    <h3 class="fw-bold mb-4">Edit Product</h3>
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="mb-3">
                    <label>Product Name</label>
                    <input type="text" name="name" class="form-control" value="{{ $product->name }}" required>
                </div>
                <div class="mb-3">
                    <label>Category</label>
                    <select name="category_id" class="form-select" required>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Price</label>
                        <input type="number" name="price" class="form-control" value="{{ $product->price }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Stock</label>
                        <input type="number" name="stock" class="form-control" value="{{ $product->stock }}" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label>Description</label>
                    <textarea name="description" class="form-control" rows="3" required>{{ $product->description }}</textarea>
                </div>
                <div class="mb-4">
                    <label>Current Image</label><br>
                    <img src="{{ asset('storage/'.$product->image) }}" width="100" class="mb-2 rounded">
                    <input type="file" name="image" class="form-control">
                    <small class="text-muted">Kosongkan jika tidak ingin mengubah gambar.</small>
                </div>
                <div class="mb-4">
                    <label class="form-label fw-bold">Current Image</label><br>
                    @php
                        $isUrl = \Illuminate\Support\Str::startsWith($product->image, 'http');
                        $src = $isUrl ? $product->image : asset('storage/'.$product->image);
                    @endphp
                    <img src="{{ $src }}" width="100" class="mb-2 rounded border">
                    
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <label class="small text-muted">Ganti dengan Upload File</label>
                            <input type="file" name="image" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="small text-muted">ATAU Ganti dengan URL</label>
                            <input type="url" name="image_url" class="form-control" placeholder="https://..." value="{{ $isUrl ? $product->image : '' }}">
                        </div>
                    </div>
                </div>
                <button class="btn btn-warning w-100">Update Product</button>
            </form>
        </div>
    </div>
</div>
@endsection