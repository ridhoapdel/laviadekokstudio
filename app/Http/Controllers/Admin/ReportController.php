<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Wajib import DB
use App\Models\Order;
use App\Models\OrderItem;

class ReportController extends Controller
{
    public function index()
    {
        // 1. Laporan Pendapatan Bulanan (Untuk Grafik)
        // Mengelompokkan total uang masuk berdasarkan Bulan-Tahun
        $revenueData = Order::select(
            DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"),
            DB::raw('SUM(total_amount) as total_revenue'),
            DB::raw('COUNT(id) as total_transaction')
        )
        ->where('status', '!=', 'pending') // Hanya hitung yg sudah bayar/selesai
        ->groupBy('month')
        ->orderBy('month', 'asc')
        ->get();

        // 2. Laporan Produk Terlaris (Top 5)
        $bestSellers = OrderItem::select('product_id', DB::raw('SUM(qty) as total_sold'))
            ->with('product') // Eager load biar nama produk keambil
            ->groupBy('product_id')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get();

        return view('admin.reports.index', compact('revenueData', 'bestSellers'));
    }
}