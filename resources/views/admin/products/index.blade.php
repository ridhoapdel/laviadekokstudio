@extends('layouts.auth')

@section('title', 'Manage Products')

@section('content')
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold">Manage Products</h3>
            <p class="text-muted">Kelola daftar produk, harga, dan stok.</p>
        </div>
        <a href="{{ route('admin.products.create') }}" class="btn btn-dark">
            + Add New Product
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Image</th>
                            <th>Product Name</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th class="text-end pe-4">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                        <tr>
                            <td class="ps-4">
                                @php
                                    // Cek apakah string gambar dimulai dengan 'http' (berarti URL)
                                    $isUrl = \Illuminate\Support\Str::startsWith($product->image, 'http');
                                    $imageSrc = $isUrl ? $product->image : asset('storage/' . $product->image);
                                @endphp
                                
                                <img src="{{ $imageSrc }}" 
                                     class="rounded border" width="50" height="50" style="object-fit: cover;"
                                     onerror="this.onerror=null; this.src='https://placehold.co/50'">
                            </td>
                            <td>
                                <span class="fw-bold">{{ $product->name }}</span>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border">{{ $product->category->name ?? 'None' }}</span>
                            </td>
                            <td>Rp {{ number_format($product->price) }}</td>
                            <td>
                                @if($product->stock <= 0)
                                    <span class="badge bg-danger">Habis</span>
                                @else
                                    {{ $product->stock }} Unit
                                @endif
                            </td>
                            <td class="text-end pe-4">
                                <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-warning me-1">
                                    Edit
                                </a>
                                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus produk ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                Belum ada produk. Klik tombol Add New Product.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-4 d-flex justify-content-center">
        {{ $products->links() }}
    </div>
</div>
@endsection