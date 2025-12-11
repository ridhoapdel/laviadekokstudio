@extends('layouts.auth')

@section('title', 'Sales Report')

@section('content')
<div class="container mt-5">
    <h3 class="mb-4 fw-bold">Sales Report</h3>

    <div class="row">
        <div class="col-md-7 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold">Monthly Revenue</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Month</th>
                                <th>Transactions</th>
                                <th class="text-end">Revenue</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($revenueData as $data)
                            <tr>
                                <td>{{ \Carbon\Carbon::createFromFormat('Y-m', $data->month)->format('F Y') }}</td>
                                <td>{{ $data->total_transaction }} Orders</td>
                                <td class="text-end fw-bold text-success">
                                    Rp {{ number_format($data->total_revenue) }}
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="3" class="text-center">No data available</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-5 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold">Top 5 Best Sellers</h5>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        @forelse($bestSellers as $item)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <span class="badge bg-dark rounded-circle me-3">{{ $loop->iteration }}</span>
                                <div>
                                    <h6 class="mb-0 fw-bold">{{ $item->product->name }}</h6>
                                    <small class="text-muted">Total Sold</small>
                                </div>
                            </div>
                            <span class="fs-5 fw-bold">{{ $item->total_sold }}</span>
                        </li>
                        @empty
                        <li class="list-group-item text-center py-4 text-muted">No sales data yet.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection