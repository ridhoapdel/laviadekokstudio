<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\CheckoutController;

use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\ProductController as AdminProduct;
use App\Http\Controllers\Admin\OrderController as AdminOrder;
use App\Http\Controllers\Admin\CampaignController as AdminCampaign;
use App\Http\Controllers\Admin\ReportController as AdminReport;

/* Web Routes (clothStudio) */

// 1. halaman public
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

// 2. halaman authentication
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'postLogin']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'postRegister']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// 3. halaman user (harus login yh)
Route::middleware(['auth'])->group(function () {
    // wishlist
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/add/{product}', [WishlistController::class, 'store'])->name('wishlist.store');
    Route::delete('/wishlist/remove/{product}', [WishlistController::class, 'destroy'])->name('wishlist.destroy');

    // cart
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product}', [CartController::class, 'store'])->name('cart.store');
    Route::patch('/cart/update/{cart}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{cart}', [CartController::class, 'destroy'])->name('cart.destroy');

    // checkout
    Route::get('/checkout', [CheckoutController::class, 'create'])->name('checkout.create');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/orders/history', [CheckoutController::class, 'history'])->name('orders.history');
    Route::get('/orders/{order}', [CheckoutController::class, 'show'])->name('orders.show');
});

// -4. halaman admin (harus login admin dan & role admin)
// middleware
Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {
    
    // dashboard
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');

    // kelola produk (CRUD)
    Route::resource('products', AdminProduct::class);
    
    // kelola campaign
    Route::resource('campaigns', AdminCampaign::class);

    // monitoring transaksi
    Route::get('/orders', [AdminOrder::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [AdminOrder::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}/status', [AdminOrder::class, 'updateStatus'])->name('orders.updateStatus');

    // laporamn
    Route::get('/reports', [AdminReport::class, 'index'])->name('reports.index');
});