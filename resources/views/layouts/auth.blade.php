<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Laviade Studio')</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        /* --- GLOBAL STYLE --- */
        body { 
            font-family: 'Inter', sans-serif; 
            background-color: #f8f9fa;
            /* Padding top biar konten gak ketutup navbar fixed */
            padding-top: 80px; 
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* --- NAVBAR STYLE --- */
        .navbar-brand { font-weight: 800; letter-spacing: -0.5px; font-size: 1.5rem; }
        .nav-link { font-weight: 500; color: #333; }
        .nav-link:hover { color: #000; font-weight: 600; }
        
        /* --- FOOTER STYLE --- */
        .footer { margin-top: auto; background: #000; color: #fff; padding: 40px 0; }

        /* --- AUTH PAGE STYLE (INI YANG KEMARIN HILANG) --- */
        .auth-card { 
            max-width: 400px; 
            margin: 50px auto; 
            border-radius: 10px; 
            box-shadow: 0 4px 6px rgba(0,0,0,0.1); 
            background: #fff;
        }
        .auth-header { 
            background-color: #000; 
            color: #fff; 
            border-radius: 10px 10px 0 0; 
            padding: 20px; 
            text-align: center; 
        }
        .btn-black { background-color: #000; color: #fff; width: 100%; border: none; }
        .btn-black:hover { background-color: #333; color: #fff; }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ Auth::check() && Auth::user()->role === 'admin' ? route('admin.dashboard') : route('home') }}">
                {{ Auth::check() && Auth::user()->role === 'admin' ? 'LAVIADMIN.' : 'LAVIADE.' }}
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    @auth
                        @if(Auth::user()->role === 'admin')
                            <li class="nav-item"><a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('admin.products.index') }}">Products</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('admin.orders.index') }}">Orders</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('admin.campaigns.index') }}">Campaigns</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('admin.reports.index') }}">Reports</a></li>
                        @endif

                        @if(Auth::user()->role === 'user')
                            <li class="nav-item"><a class="nav-link" href="{{ route('products.index') }}">Catalog</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('orders.history') }}">My Orders</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('wishlist.index') }}">Wishlist</a></li>
                        @endif
                    @else
                        <li class="nav-item"><a class="nav-link" href="{{ route('products.index') }}">Catalog</a></li>
                    @endauth
                </ul>

                <ul class="navbar-nav ms-auto align-items-center">
                    @auth
                        @if(Auth::user()->role === 'user')
                        <li class="nav-item me-3">
                            <a href="{{ route('cart.index') }}" class="btn btn-outline-dark position-relative border-0">
                                <i class="bi bi-cart"></i> <span class="d-none d-lg-inline">Cart</span>
                            </a>
                        </li>
                        @endif
                        
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle fw-bold" href="#" role="button" data-bs-toggle="dropdown">
                                {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end border-0 shadow">
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item ms-2">
                            <a class="btn btn-dark btn-sm px-4 rounded-pill" href="{{ route('register') }}">Register</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mb-5">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mt-3 border-0 shadow-sm" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mt-3 border-0 shadow-sm" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>

    <footer class="footer text-center">
        <div class="container">
            <h5 class="fw-bold mb-1">LAVIADE STUDIO</h5>
            <p class="small text-muted mb-0">© 2025 Cloth Studio Project.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>