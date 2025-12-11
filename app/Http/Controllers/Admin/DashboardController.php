<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Statistik (Yang lama)
        $stats = [
            'total_users' => User::where('role', 'user')->count(),
            'total_products' => Product::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'total_revenue' => Order::where('status', 'done')->sum('total_amount'),
        ];

        // 2. Ambil 5 Order Terbaru (INI YANG BARU)
        $recentOrders = Order::with('user')
                             ->latest()
                             ->take(5)
                             ->get();

        // Kirim $stats DAN $recentOrders ke view
        return view('admin.dashboard', compact('stats', 'recentOrders'));
    }
}
