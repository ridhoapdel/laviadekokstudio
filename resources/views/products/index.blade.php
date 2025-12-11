@extends('layouts.auth')

@section('title', 'Catalog Products')

@section('content')
<div class="container mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold border-start border-4 border-dark ps-3">ALL COLLECTION</h2>
        
        <div class="dropdown">
            <button class="btn btn-outline-dark btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                Sort By
            </button>
            <ul class="dropdown-menu border-0 shadow">
                <li><a class="dropdown-item" href="#">Newest</a></li>
                <li><a class="dropdown-item" href="#">Price: Low to High</a></li>
            </ul>
        </div>
    </div>

    @if($products->count() > 0)
        <div class="row">
            @foreach($products as $product)
            <div class="col-md-3 col-6 mb-4">
                <div class="card h-100 border-0 shadow-sm product-card">
                    
                    <div class="position-relative overflow-hidden">
                        <a href="{{ route('products.show', $product->id) }}">
                            <img src="{{ asset('storage/' . $product->image) }}" 
                                 class="card-img-top" 
                                 alt="{{ $product->name }}"
                                 style="height: 300px; object-fit: cover;">
                        </a>
                        
                        @if($product->stock <= 0)
                            <div class="position-absolute top-0 start-0 w-100 h-100 bg-white bg-opacity-75 d-flex align-items-center justify-content-center">
                                <span class="badge bg-danger fs-6">SOLD OUT</span>
                            </div>
                        @endif
                    </div>

                    <div class="card-body text-center">
                        <h6 class="card-title fw-bold text-truncate">
                            <a href="{{ route('products.show', $product->id) }}" class="text-decoration-none text-dark">
                                {{ $product->name }}
                            </a>
                        </h6>
                        <p class="text-muted small mb-2">{{ $product->category->name ?? 'Collection' }}</p>
                        <h5 class="fw-bold text-dark">Rp {{ number_format($product->price) }}</h5>
                        
                        <a href="{{ route('products.show', $product->id) }}" class="btn btn-dark w-100 mt-2 btn-sm">
                            View Detail
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $products->links() }}
        </div>

    @else
        <div class="text-center py-5 bg-light rounded">
            <h3>Produk Sedang Kosong</h3>
            <p class="text-muted">Admin belum menambahkan produk baru.</p>
            <a href="{{ route('home') }}" class="btn btn-dark mt-3">Kembali ke Home</a>
        </div>
    @endif
</div>
@endsection