@extends('layouts.auth')
@section('title', 'Checkout')
@section('content')
<div class="container mt-5 pt-5">
    <h2 class="fw-bold mb-4">CHECKOUT</h2>
    <div class="row">
        <div class="col-md-7">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="fw-bold">Alamat Pengiriman</h5>
                    <form action="{{ route('checkout.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Nama Penerima</label>
                            <input type="text" class="form-control" value="{{ Auth::user()->name }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alamat Lengkap</label>
                            <textarea name="address" class="form-control" rows="3" required placeholder="Jalan, No Rumah, Kelurahan..."></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nomor WhatsApp/HP</label>
                            <input type="number" name="phone" class="form-control" required placeholder="08xxxxx">
                        </div>
                        <button type="submit" class="btn btn-dark w-100 py-2">CONFIRM ORDER</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="card bg-light border-0">
                <div class="card-body">
                    <h5 class="fw-bold">Ringkasan Order</h5>
                    <hr>
                    @foreach($cartItems as $item)
                        <div class="d-flex justify-content-between mb-2">
                            <span>{{ $item->product->name }} (x{{ $item->qty }})</span>
                            <span>Rp {{ number_format($item->product->price * $item->qty) }}</span>
                        </div>
                    @endforeach
                    <hr>
                    <div class="d-flex justify-content-between fw-bold fs-5">
                        <span>Total</span>
                        <span>Rp {{ number_format($subtotal) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection