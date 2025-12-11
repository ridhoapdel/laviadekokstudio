@extends('layouts.auth')

@section('title', 'Register')

@section('content')
<div class="card auth-card">
    <div class="auth-header">
        <h4 class="mb-0">JOIN LAVIADE</h4>
        <small>Create your account</small>
    </div>
    <div class="card-body p-4">
        
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Full Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Email Address</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
                <div class="form-text">Minimal 6 karakter.</div>
            </div>
            <div class="mb-3">
                <label class="form-label">Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-black">REGISTER</button>
        </form>

        <div class="text-center mt-3">
            <small>Sudah punya akun? <a href="{{ route('login') }}" class="text-decoration-none text-dark fw-bold">Login disini</a></small>
        </div>
    </div>
</div>
@endsection