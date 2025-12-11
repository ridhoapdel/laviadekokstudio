@extends('layouts.auth')
@section('content')
<div class="container mt-5">
    <h3>Incoming Orders</h3>
    <table class="table table-striped mt-3">
        <thead><tr><th>ID</th><th>User</th><th>Total</th><th>Status</th><th>Action</th></tr></thead>
        <tbody>
            @foreach($orders as $o)
            <tr>
                <td>#{{ $o->id }}</td>
                <td>{{ $o->user->name }}</td>
                <td>{{ number_format($o->total_amount) }}</td>
                <td><span class="badge bg-secondary">{{ $o->status }}</span></td>
                <td><a href="{{ route('admin.orders.show', $o->id) }}" class="btn btn-sm btn-dark">Manage</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection