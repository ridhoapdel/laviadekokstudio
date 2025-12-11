@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<div class="card auth-card border-0 shadow-sm">
    <div class="auth-header">
        <h4 class="mb-0 fw-bold">LAVIADE STUDIO</h4>
        <small class="text-white-50">Please login to continue</small>
    </div>
    <div class="card-body p-4">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0 ps-3">
                    @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf
            @if(request('redirect'))
                <input type="hidden" name="redirect" value="{{ request('redirect') }}">
            @endif

            <div class="mb-3">
                <label class="form-label">Email Address</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
            </div>
            
            <div class="mb-4">
                <label class="form-label">Password</label>
                <div class="input-group">
                    <input type="password" name="password" id="password" class="form-control border-end-0" required>
                    <span class="input-group-text bg-white border-start-0" style="cursor: pointer;" onclick="togglePassword('password', 'icon-pass')">
                        <i class="bi bi-eye" id="icon-pass"></i>
                    </span>
                </div>
            </div>

            <button type="submit" class="btn btn-black py-2 fw-bold">LOGIN</button>
        </form>

        <div class="text-center mt-3">
            <small>Belum punya akun? <a href="{{ route('register') }}" class="text-decoration-none text-dark fw-bold">Daftar disini</a></small>
        </div>
    </div>
</div>

<script>
    function togglePassword(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);
        
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        }
    }
</script>
@endsection