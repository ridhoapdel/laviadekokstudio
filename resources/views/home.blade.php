@extends('layouts.auth')

@section('title', 'Laviade Studio - Home')

@section('content')

@if($campaigns->count() > 0)
    <div id="campaignCarousel" class="carousel slide mb-5 shadow-sm" data-bs-ride="carousel">
        <div class="carousel-indicators">
            @foreach($campaigns as $key => $campaign)
                <button type="button" data-bs-target="#campaignCarousel" data-bs-slide-to="{{ $key }}" class="{{ $key == 0 ? 'active' : '' }}" aria-current="true"></button>
            @endforeach
        </div>

        <div class="carousel-inner rounded">
            @foreach($campaigns as $key => $campaign)
            <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                <a href="{{ $campaign->redirect_url ?? '#' }}">
                    <img src="{{ asset('storage/' . $campaign->banner_path) }}" 
                         class="d-block w-100" 
                         alt="{{ $campaign->title }}" 
                         style="height: 400px; object-fit: cover;">
                    
                    <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded p-2">
                        <h5 class="fw-bold">{{ $campaign->title }}</h5>
                    </div>
                </a>
            </div>
            @endforeach
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#campaignCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#campaignCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
@else
    <div class="bg-dark text-white text-center py-5 mb-5 rounded">
        <h1 class="fw-bold">LAVIADE STUDIO</h1>
        <p class="lead">Premium Streetwear Collection</p>
    </div>
@endif

<div class="container mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold border-start border-4 border-dark ps-3">NEW ARRIVALS</h3>
        <a href="{{ route('products.index') }}" class="btn btn-outline-dark btn-sm">View All</a>
    </div>

    <div class="row">
        @foreach($products as $product)
        <div class="col-md-3 col-6 mb-4">
            <div class="card h-100 border-0 shadow-sm product-card">
                <div class="position-relative overflow-hidden">
                    <img src="{{ asset('storage/' . $product->image) }}" 
                         class="card-img-top" 
                         alt="{{ $product->name }}"
                         style="height: 300px; object-fit: cover;">
                         
                    @if($product->stock <= 0)
                        <div class="position-absolute top-0 start-0 w-100 h-100 bg-white bg-opacity-75 d-flex align-items-center justify-content-center">
                            <span class="badge bg-danger fs-6">SOLD OUT</span>
                        </div>
                    @endif
                </div>

                <div class="card-body text-center">
                    <h6 class="card-title fw-bold text-truncate">{{ $product->name }}</h6>
                    <p class="text-muted small mb-2">{{ $product->category->name ?? 'Uncategorized' }}</p>
                    <h5 class="fw-bold text-dark">Rp {{ number_format($product->price) }}</h5>
                    
                    <a href="{{ route('products.show', $product->id) }}" class="btn btn-dark w-100 mt-2">
                        View Detail
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

@endsection