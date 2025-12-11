@extends('layouts.auth') 

@section('title', 'Admin Dashboard')

@section('content')
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark">Dashboard Overview</h2>
            <p class="text-muted">Selamat datang kembali, Admin.</p>
        </div>
        </div>

    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary mb-3 border-0 shadow-sm h-100">
                <div class="card-body">
                    <h6 class="card-title text-uppercase opacity-75">Total Users</h6>
                    <p class="card-text display-6 fw-bold">{{ $stats['total_users'] }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success mb-3 border-0 shadow-sm h-100">
                <div class="card-body">
                    <h6 class="card-title text-uppercase opacity-75">Revenue</h6>
                    <p class="card-text fs-3 fw-bold">Rp {{ number_format($stats['total_revenue']) }}</p>
                    <small class="opacity-75">Total pendapatan</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning mb-3 border-0 shadow-sm h-100">
                <div class="card-body">
                    <h6 class="card-title text-uppercase opacity-75 text-dark">Pending Orders</h6>
                    <p class="card-text display-6 fw-bold text-dark">{{ $stats['pending_orders'] }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-dark mb-3 border-0 shadow-sm h-100">
                <div class="card-body">
                    <h6 class="card-title text-uppercase opacity-75">Total Products</h6>
                    <p class="card-text display-6 fw-bold">{{ $stats['total_products'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold">Recent Orders</h5>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-dark btn-sm">View All Orders</a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Order ID</th>
                            <th>Customer</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th class="text-end pe-4">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentOrders as $order)
                        <tr>
                            <td class="ps-4 fw-bold">#{{ $order->id }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-light rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 35px; height: 35px;">
                                        {{ substr($order->user->name, 0, 1) }}
                                    </div>
                                    {{ $order->user->name }}
                                </div>
                            </td>
                            <td>Rp {{ number_format($order->total_amount) }}</td>
                            <td>
                                @php
                                    $badges = [
                                        'pending' => 'warning', 'paid' => 'info', 'processing' => 'primary',
                                        'shipped' => 'primary', 'done' => 'success', 'cancelled' => 'danger'
                                    ];
                                    $color = $badges[$order->status] ?? 'secondary';
                                @endphp
                                <span class="badge bg-{{ $color }} rounded-pill px-3">
                                    {{ strtoupper($order->status) }}
                                </span>
                            </td>
                            <td class="text-muted small">{{ $order->created_at->diffForHumans() }}</td>
                            <td class="text-end pe-4">
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-dark">Manage</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">Belum ada pesanan masuk.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection