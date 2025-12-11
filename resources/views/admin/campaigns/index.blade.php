@extends('layouts.auth')

@section('title', 'Manage Campaigns')

@section('content')
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Manage Campaigns</h3>
        <a href="{{ route('admin.campaigns.create') }}" class="btn btn-dark">+ Add Campaign</a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Banner</th>
                        <th>Title</th>
                        <th>Duration</th>
                        <th>Status</th>
                        <th class="text-end pe-4">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($campaigns as $campaign)
                    <tr>
                        <td class="ps-4">
                            <img src="{{ asset('storage/' . $campaign->banner_path) }}" 
                                 class="rounded" width="100" style="object-fit: cover;">
                        </td>
                        <td class="fw-bold">{{ $campaign->title }}</td>
                        <td class="small text-muted">
                            {{ \Carbon\Carbon::parse($campaign->start_date)->format('d M') }} - 
                            {{ \Carbon\Carbon::parse($campaign->end_date)->format('d M Y') }}
                        </td>
                        <td>
                            @if(now()->between($campaign->start_date, $campaign->end_date))
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-secondary">Inactive</span>
                            @endif
                        </td>
                        <td class="text-end pe-4">
                            <form action="{{ route('admin.campaigns.destroy', $campaign->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus promo ini?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">Belum ada campaign promo.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection