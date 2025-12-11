@extends('layouts.auth')

@section('title', 'Order Detail #' . $order->id)

@section('content')
<div class="container mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-0">ORDER #{{ $order->id }}</h2>
            <small class="text-muted">Detail transaksi kamu</small>
        </div>
        <a href="{{ route('orders.history') }}" class="btn btn-outline-dark btn-sm">
            &larr; Back to History
        </a>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="mb-0 fw-bold">Items Ordered</h5>
                </div>
                <div class="card-body">
                    @foreach($order->orderItems as $item)
                    <div class="d-flex align-items-center border-bottom pb-3 mb-3 last:border-0">
                        <a href="{{ route('products.show', $item->product->id) }}">
                            <img src="{{ asset('storage/' . $item->product->image) }}" 
                                 alt="{{ $item->product->name }}" 
                                 class="rounded me-3 border" 
                                 style="width: 80px; height: 80px; object-fit: cover;">
                        </a>
                        
                        <div class="flex-grow-1">
                            <h6 class="fw-bold mb-1">
                                <a href="{{ route('products.show', $item->product->id) }}" class="text-decoration-none text-dark">
                                    {{ $item->product->name }}
                                </a>
                            </h6>
                            <div class="text-muted small">
                                Size: <span class="badge bg-light text-dark border">{{ $item->size ?? 'All Size' }}</span> 
                                <span class="mx-1">|</span>
                                Qty: {{ $item->qty }}
                            </div>
                        </div>
                        
                        <div class="text-end">
                            <p class="fw-bold mb-0">Rp {{ number_format($item->price_at_checkout * $item->qty) }}</p>
                            <small class="text-muted">@ Rp {{ number_format($item->price_at_checkout) }}</small>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Order Summary</h5>
                    
                    <div class="mb-3 p-3 bg-light rounded text-center">
                        <small class="text-muted d-block mb-1">Status Pesanan</small>
                        @php
                            $badges = [
                                'pending' => 'warning',
                                'paid' => 'info',
                                'processing' => 'primary',
                                'shipped' => 'primary',
                                'done' => 'success',
                                'cancelled' => 'danger'
                            ];
                            $color = $badges[$order->status] ?? 'secondary';
                        @endphp
                        <span class="badge bg-{{ $color }} fs-5 px-4 py-2">
                            {{ strtoupper($order->status) }}
                        </span>
                    </div>

                    <ul class="list-group list-group-flush mb-3">
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span class="text-muted small">Tanggal Order</span>
                            <span class="fw-bold">{{ $order->created_at->format('d M Y') }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span class="text-muted small">Nomor Resi</span>
                            <span class="fw-bold font-monospace">{{ $order->resi_number ?? '-' }}</span>
                        </li>
                    </ul>

                    <div class="mb-4">
                        <h6 class="fw-bold border-bottom pb-2">Alamat Pengiriman</h6>
                        <p class="mb-0 fw-bold">{{ Auth::user()->name }}</p>
                        <p class="mb-1 text-muted small">{{ $order->phone }}</p>
                        <p class="small text-secondary bg-light p-2 rounded mt-2">
                            {{ $order->address }}
                        </p>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-bold text-muted">TOTAL BAYAR</span>
                        <span class="fw-bold fs-4 text-dark">Rp {{ number_format($order->total_amount) }}</span>
                    </div>
                </div>
            </div>

            <a href="https://wa.me/628123456789" target="_blank" class="btn btn-success w-100 fw-bold shadow-sm">
                <i class="bi bi-whatsapp"></i> Hubungi Admin
            </a>
        </div>
    </div>
</div>
@endsection