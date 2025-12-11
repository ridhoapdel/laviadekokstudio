@extends('layouts.auth')

@section('title', 'My Wishlist')

@section('content')
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">MY WISHLIST</h2>
        <a href="{{ route('products.index') }}" class="btn btn-outline-dark btn-sm">Continue Shopping</a>
    </div>

    @if($wishlists->count() > 0)
        <div class="row">
            @foreach($wishlists as $item)
            <div class="col-md-3 col-6 mb-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="position-relative">
                        <img src="{{ asset('storage/' . $item->product->image) }}" class="card-img-top" alt="{{ $item->product->name }}">
                        <form action="{{ route('wishlist.destroy', $item->product->id) }}" method="POST" class="position-absolute top-0 end-0 p-2">
                            @csrf @method('DELETE')
                            <button class="btn btn-light btn-sm rounded-circle shadow-sm" title="Remove">✕</button>
                        </form>
                    </div>
                    <div class="card-body text-center">
                        <h6 class="fw-bold mb-1">{{ $item->product->name }}</h6>
                        <p class="text-muted mb-3">Rp {{ number_format($item->product->price) }}</p>
                        <a href="{{ route('products.show', $item->product->id) }}" class="btn btn-dark btn-sm w-100">View Product</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-5 bg-light rounded">
            <h3>Wishlist kamu kosong</h3>
            <p class="text-muted">Simpan barang yang kamu suka di sini.</p>
            <a href="{{ route('products.index') }}" class="btn btn-dark mt-3">Jelajahi Produk</a>
        </div>
    @endif
</div>
@endsection