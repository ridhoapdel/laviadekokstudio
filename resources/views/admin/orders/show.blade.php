@extends('layouts.auth')

@section('title', 'Manage Order #' . $order->id)

@section('content')
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">MANAGE ORDER #{{ $order->id }}</h2>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-dark btn-sm">Back to Dashboard</a>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold">Items Ordered</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr class="text-muted small">
                                    <th>Product</th>
                                    <th>Size</th>
                                    <th>Price</th>
                                    <th>Qty</th>
                                    <th class="text-end">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->orderItems as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset('storage/' . $item->product->image) }}" 
                                                 class="rounded me-2 border" 
                                                 style="width: 50px; height: 50px; object-fit: cover;">
                                            <span class="fw-bold">{{ $item->product->name }}</span>
                                        </div>
                                    </td>
                                    <td><span class="badge bg-light text-dark border">{{ $item->size }}</span></td>
                                    <td>Rp {{ number_format($item->price_at_checkout) }}</td>
                                    <td>{{ $item->qty }}</td>
                                    <td class="text-end fw-bold">Rp {{ number_format($item->price_at_checkout * $item->qty) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-light">
                                <tr>
                                    <td colspan="4" class="text-end fw-bold">GRAND TOTAL</td>
                                    <td class="text-end fw-bold fs-5 text-primary">Rp {{ number_format($order->total_amount) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold">Customer Info</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <small class="text-muted d-block">Nama</small>
                            <span class="fw-bold">{{ $order->user->name }}</span>
                        </div>
                        <div class="col-md-6 mb-3">
                            <small class="text-muted d-block">Email</small>
                            <span>{{ $order->user->email }}</span>
                        </div>
                        <div class="col-md-6 mb-3">
                            <small class="text-muted d-block">No HP / WA</small>
                            <span class="fw-bold">{{ $order->phone }}</span>
                            <a href="https://wa.me/{{ $order->phone }}" target="_blank" class="text-success text-decoration-none ms-2 small">
                                <i class="bi bi-whatsapp"></i> Chat WA
                            </a>
                        </div>
                        <div class="col-md-12">
                            <small class="text-muted d-block">Alamat Pengiriman</small>
                            <p class="mb-0 border p-2 rounded bg-light">{{ $order->address }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-dark text-white">
                <div class="card-header bg-transparent py-3 border-secondary">
                    <h5 class="mb-0 fw-bold text-white">Update Status</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <div class="mb-3">
                            <label class="form-label text-white-50">Order Status</label>
                            <select name="status" class="form-select">
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending (Menunggu Bayar)</option>
                                <option value="paid" {{ $order->status == 'paid' ? 'selected' : '' }}>Paid (Sudah Bayar)</option>
                                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing (Dikemas)</option>
                                <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped (Dikirim)</option>
                                <option value="done" {{ $order->status == 'done' ? 'selected' : '' }}>Done (Selesai)</option>
                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled (Batal)</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-white-50">Nomor Resi (Opsional)</label>
                            <input type="text" name="resi_number" class="form-control" placeholder="Masukkan resi JNE/JNT..." value="{{ $order->resi_number }}">
                            <div class="form-text text-white-50 small">Isi jika status "Shipped".</div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 fw-bold py-2">
                            UPDATE ORDER
                        </button>
                    </form>
                </div>
            </div>

            <div class="card border-0 shadow-sm mt-3">
                <div class="card-body">
                    <div class="mb-2">
                        <small class="text-muted">Tanggal Order</small>
                        <div class="fw-bold">{{ $order->created_at->format('d M Y, H:i') }}</div>
                    </div>
                    <div>
                        <small class="text-muted">Last Update</small>
                        <div class="fw-bold">{{ $order->updated_at->diffForHumans() }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection