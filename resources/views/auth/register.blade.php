@extends('layouts.auth')

@section('title', 'Register')

@section('content')
<div class="card auth-card border-0 shadow-sm">
    <div class="auth-header">
        <h4 class="mb-0 fw-bold">JOIN LAVIADE</h4>
        <small class="text-white-50">Create your account</small>
    </div>
    <div class="card-body p-4">
        
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0 ps-3">
                    @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
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
                <div class="input-group">
                    <input type="password" name="password" id="reg_pass" class="form-control border-end-0" required>
                    <span class="input-group-text bg-white border-start-0" style="cursor: pointer;" onclick="togglePassword('reg_pass', 'icon-reg')">
                        <i class="bi bi-eye" id="icon-reg"></i>
                    </span>
                </div>
                <div class="form-text">Minimal 6 karakter.</div>
            </div>

            <div class="mb-4">
                <label class="form-label">Confirm Password</label>
                <div class="input-group">
                    <input type="password" name="password_confirmation" id="reg_conf" class="form-control border-end-0" required>
                    <span class="input-group-text bg-white border-start-0" style="cursor: pointer;" onclick="togglePassword('reg_conf', 'icon-conf')">
                        <i class="bi bi-eye" id="icon-conf"></i>
                    </span>
                </div>
            </div>

            <button type="submit" class="btn btn-black py-2 fw-bold">REGISTER</button>
        </form>

        <div class="text-center mt-3">
            <small>Sudah punya akun? <a href="{{ route('login') }}" class="text-decoration-none text-dark fw-bold">Login disini</a></small>
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