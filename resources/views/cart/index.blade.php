@extends('layouts.auth')

@section('title', 'Shopping Cart')

@section('content')
<div class="container mt-5 pt-5">
    <h2 class="mb-4 fw-bold">SHOPPING CART</h2>

    @if($cartItems->count() > 0)
        <div class="row">
            <div class="col-md-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        @foreach($cartItems as $item)
                            <div class="d-flex align-items-center mb-3 border-bottom pb-3">
                                <img src="https://placehold.co/80x80/e0e0e0/000000" class="rounded me-3">
                                <div class="flex-grow-1">
                                    <h5 class="mb-0">{{ $item->product->name }}</h5>
                                    <small class="text-muted">Rp {{ number_format($item->product->price) }} x {{ $item->qty }}</small>
                                </div>
                                <div class="text-end">
                                    <p class="fw-bold mb-1">Rp {{ number_format($item->product->price * $item->qty) }}</p>
                                    <form action="{{ route('cart.destroy', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Remove</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm bg-light">
                    <div class="card-body">
                        <h5 class="fw-bold">Order Summary</h5>
                        <hr>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Subtotal</span>
                            <span class="fw-bold">Rp {{ number_format($subtotal) }}</span>
                        </div>
                        <div class="d-grid">
                            <a href="{{ route('checkout.create') }}" class="btn btn-dark">CHECKOUT NOW</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-5">
            <h4>Keranjang kamu kosong nih.</h4>
            <a href="{{ route('home') }}" class="btn btn-dark mt-3">Belanja Sekarang</a>
        </div>
    @endif
</div>
@endsection