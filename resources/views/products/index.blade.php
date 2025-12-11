@extends('layouts.auth')

@section('title', 'Catalog Products')

@section('content')
<div class="container mb-5">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4 gap-3">
        <div>
            <h2 class="fw-bold border-start border-4 border-dark ps-3 mb-0">ALL COLLECTION</h2>
            @if(request('search'))
                <small class="text-muted ms-3">Hasil pencarian: "<strong>{{ request('search') }}</strong>"</small>
            @endif
        </div>
        
        <div class="dropdown">
            <button class="btn btn-outline-dark dropdown-toggle" type="button" data-bs-toggle="dropdown">
                <i class="bi bi-filter"></i> Sort By
            </button>
            <ul class="dropdown-menu dropdown-menu-end border-0 shadow">
                <li>
                    <a class="dropdown-item {{ request('sort') == 'newest' ? 'active bg-dark' : '' }}" 
                       href="{{ request()->fullUrlWithQuery(['sort' => 'newest']) }}">Newest Arrival</a>
                </li>
                <li>
                    <a class="dropdown-item {{ request('sort') == 'price_asc' ? 'active bg-dark' : '' }}" 
                       href="{{ request()->fullUrlWithQuery(['sort' => 'price_asc']) }}">Price: Low to High</a>
                </li>
                <li>
                    <a class="dropdown-item {{ request('sort') == 'price_desc' ? 'active bg-dark' : '' }}" 
                       href="{{ request()->fullUrlWithQuery(['sort' => 'price_desc']) }}">Price: High to Low</a>
                </li>
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
                                 style="height: 300px; object-fit: cover;"
                                 onerror="this.onerror=null;this.src='https://placehold.co/300x300?text=No+Image';">
                        </a>
                        
                        @if($product->stock <= 0)
                            <div class="position-absolute top-0 start-0 w-100 h-100 bg-white bg-opacity-75 d-flex align-items-center justify-content-center">
                                <span class="badge bg-danger fs-6 rounded-pill px-3 py-2">SOLD OUT</span>
                            </div>
                        @endif
                    </div>

                    <div class="card-body text-center">
                        <h6 class="card-title fw-bold text-truncate">
                            <a href="{{ route('products.show', $product->id) }}" class="text-decoration-none text-dark">{{ $product->name }}</a>
                        </h6>
                        <p class="text-muted small mb-2">{{ $product->category->name ?? 'Collection' }}</p>
                        <h5 class="fw-bold text-dark">Rp {{ number_format($product->price) }}</h5>
                        
                        <a href="{{ route('products.show', $product->id) }}" class="btn btn-dark w-100 mt-2 btn-sm rounded-pill">View Detail</a>
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
            <h1 class="display-1 text-muted"><i class="bi bi-search"></i></h1>
            <h3>Produk tidak ditemukan.</h3>
            <a href="{{ route('products.index') }}" class="btn btn-dark mt-3 px-4 rounded-pill">Reset Catalog</a>
        </div>
    @endif
</div>
@endsection