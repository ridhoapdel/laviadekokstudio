<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; // <--- Jangan lupa import Model

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->paginate(12); 
        return view('products.index', compact('products'));
    }

    // Halaman Detail Produk
    public function show(Product $product)
    {
        // Laravel otomatis nyari produk berdasarkan ID (Route Model Binding)
        return view('products.show', compact('product'));
    }
}