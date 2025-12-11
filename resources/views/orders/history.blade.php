@extends('layouts.auth')
@section('title', 'Order History')
@section('content')
<div class="container mt-5 pt-5">
    <h2 class="fw-bold mb-4">RIWAYAT PESANAN</h2>
    @foreach($orders as $order)
    <div class="card mb-3 border-0 shadow-sm">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-1">Order #{{ $order->id }}</h5>
                    <small class="text-muted">{{ $order->created_at->format('d M Y') }}</small>
                    <span class="badge bg-{{ $order->status == 'pending' ? 'warning' : ($order->status == 'done' ? 'success' : 'primary') }} ms-2">
                        {{ strtoupper($order->status) }}
                    </span>
                </div>
                <div class="text-end">
                    <p class="fw-bold mb-1">Rp {{ number_format($order->total_amount) }}</p>
                    <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-outline-dark">Detail</a>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection