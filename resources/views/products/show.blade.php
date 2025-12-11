@extends('layouts.auth')

@section('title', $product->name)

@section('content')
<div class="container mt-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none text-muted">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products.index') }}" class="text-decoration-none text-muted">Products</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card border-0 shadow-sm overflow-hidden">
                <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid w-100" alt="{{ $product->name }}" style="object-fit: cover;">
            </div>
        </div>

        <div class="col-md-6">
            <div class="ps-md-4">
                <h1 class="fw-bold display-6 mb-2">{{ $product->name }}</h1>
                <h3 class="fw-bold text-dark mb-3">Rp {{ number_format($product->price) }}</h3>
                
                <p class="text-muted mb-4" style="line-height: 1.8;">
                    {{ $product->description }}
                </p>

                <form action="{{ route('cart.store', $product->id) }}" method="POST">
                    @csrf
                    
                    @if($product->stock > 0)
                        <div class="mb-4">
                            <label class="fw-bold mb-2">Select Size</label>
                            <div class="d-flex gap-2">
                                @foreach(['S', 'M', 'L', 'XL'] as $size)
                                <input type="radio" class="btn-check" name="size" id="size{{ $size }}" value="{{ $size }}" required>
                                <label class="btn btn-outline-dark px-4" for="size{{ $size }}">{{ $size }}</label>
                                @endforeach
                            </div>
                            @error('size') <small class="text-danger">Harap pilih ukuran dulu!</small> @enderror
                        </div>

                        <div class="mb-4" style="width: 150px;">
                            <label class="fw-bold mb-2">Quantity</label>
                            <div class="input-group">
                                <button type="button" class="btn btn-outline-dark" onclick="decrementQty()">-</button>
                                <input type="number" name="qty" id="qtyInput" class="form-control text-center border-dark" value="1" min="1" max="{{ $product->stock }}" readonly>
                                <button type="button" class="btn btn-outline-dark" onclick="incrementQty()">+</button>
                            </div>
                        </div>

                        <div class="mt-2 mb-4 p-2 bg-light rounded small text-muted d-inline-block">
                            <i class="me-1">📦</i> Stok tersedia: <strong id="stockDisplay">{{ $product->stock }}</strong> unit
                        </div>

                    @else
                        <div class="alert alert-secondary mb-4 text-center py-4">
                            <h4 class="alert-heading fw-bold mb-0">SOLD OUT</h4>
                            <p class="mb-0">Maaf, stok produk ini sedang habis.</p>
                        </div>
                    @endif

                    <hr class="mb-4">

                    <div class="d-flex gap-2 align-items-center">
                        @if($product->stock > 0)
                            @auth
                                <button type="submit" name="action" value="add_cart" class="btn btn-dark py-3 px-4 flex-grow-1 fw-bold">
                                    ADD TO CART
                                </button>
                                
                                <button type="submit" name="action" value="buy_now" class="btn btn-outline-dark py-3 px-4 flex-grow-1 fw-bold">
                                    BUY NOW
                                </button>
                            @else
                                <a href="{{ route('login', ['redirect' => url()->current()]) }}" class="btn btn-dark w-100 py-3 fw-bold">
                                    LOGIN TO BUY
                                </a>
                            @endauth
                        @else
                            <button type="button" class="btn btn-secondary w-100 py-3 fw-bold disabled" disabled>
                                STOK HABIS
                            </button>
                        @endif

                        @auth
                        <a href="#" onclick="event.preventDefault(); document.getElementById('wishlist-form-{{ $product->id }}').submit();" 
                           class="btn btn-light border py-3 px-3" title="Add to Wishlist">
                            ❤️
                        </a>
                        @endauth
                    </div>
                </form>
                @auth
                <form id="wishlist-form-{{ $product->id }}" action="{{ route('wishlist.store', $product->id) }}" method="POST" class="d-none">
                    @csrf
                </form>
                @endauth
            </div>
        </div>
    </div>
</div>

<script>
    function incrementQty() {
        let input = document.getElementById('qtyInput');
        let maxStock = parseInt(input.getAttribute('max'));
        let currentValue = parseInt(input.value);

        if (currentValue < maxStock) {
            input.value = currentValue + 1;
        } else {
            alert('Maksimal stok tercapai!');
        }
    }

    function decrementQty() {
        let input = document.getElementById('qtyInput');
        let currentValue = parseInt(input.value);

        if (currentValue > 1) {
            input.value = currentValue - 1;
        }
    }
</script>
@endsection