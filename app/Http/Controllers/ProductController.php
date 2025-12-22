<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    // Alur search dimulai dari user mengirimkan keyword melalui parameter URL search.
        // Parameter tersebut ditangkap oleh Request $request di controller.
        // Jika parameter search ada dan tidak kosong, maka controller menambahkan kondisi WHERE ke query produk untuk mencari data berdasarkan kolom name atau description menggunakan operator LIKE.
        
    // Halaman Katalog (Include Pencarian & Sorting)
    
    public function index(Request $request)
    {
        $query = Product::query();

        // 1. Logic SEARCH
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // 2. Logic SORTING
        if ($request->has('sort')) {
            if ($request->sort == 'price_asc') {
                $query->orderBy('price', 'asc');
            } elseif ($request->sort == 'price_desc') {
                $query->orderBy('price', 'desc');
            } else {
                $query->latest(); // Newest
            }
        } else {
            $query->latest();
        }

        // Pagination 12
        $products = $query->paginate(12)->withQueryString();

        return view('products.index', compact('products'));
    }

    // Detail Produk
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }
}