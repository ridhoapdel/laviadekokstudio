<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'category_id' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'description' => 'required',
            // Gambar bisa file ATAU string (url)
            'image' => 'nullable|image|max:2048', 
            'image_url' => 'nullable|url'
        ]);

        // Logic Gambar: Prioritas File Upload -> Kalau gak ada, baru cek URL -> Kalau gak ada, pake default
        $imagePath = 'products/default.jpg'; // Gambar default

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        } elseif ($request->filled('image_url')) {
            $imagePath = $request->image_url; // Simpan URL mentah
        }

        Product::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'price' => $request->price,
            'stock' => $request->stock,
            'description' => $request->description,
            'image' => $imagePath
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan');
    }

    // 2. UPDATE PRODUK
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required',
            'category_id' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'description' => 'required',
            'image' => 'nullable|image|max:2048',
            'image_url' => 'nullable|url'
        ]);

        $data = $request->except(['image', 'image_url', '_token', '_method']);

        // Cek apakah user upload gambar baru?
        if ($request->hasFile('image')) {
            // Hapus gambar lama KECUALI kalau gambar lama itu URL atau default
            if ($product->image && !Str::startsWith($product->image, 'http') && $product->image !== 'products/default.jpg') {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        } 
        // Kalau gak upload file, cek apakah dia masukin URL baru?
        elseif ($request->filled('image_url')) {
             $data['image'] = $request->image_url;
        }

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diupdate');
    }

    // 3. HAPUS PRODUK
    public function destroy(Product $product)
    {
        // Hapus gambar dari storage kalau bukan URL
        if ($product->image && !Str::startsWith($product->image, 'http') && $product->image !== 'products/default.jpg') {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();
        return back()->with('success', 'Produk dihapus');
    }
}