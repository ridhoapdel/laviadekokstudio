@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<div class="card auth-card">
    <div class="auth-header">
        <h4 class="mb-0">LAVIADE STUDIO</h4>
        <small>Please login to continue</small>
    </div>
    <div class="card-body p-4">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Email Address</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-black">LOGIN</button>
        </form>

        <div class="text-center mt-3">
            <small>Belum punya akun? <a href="{{ route('register') }}" class="text-decoration-none text-dark fw-bold">Daftar disini</a></small>
        </div>
    </div>
</div>
@endsection