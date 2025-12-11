<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            'image' => 'required|image',
            'description' => 'required'
        ]);

        $path = $request->file('image')->store('products', 'public');

        Product::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'price' => $request->price,
            'stock' => $request->stock,
            'description' => $request->description,
            'image' => $path
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Produk ditambahkan');
    }

    // ... Method edit, update, destroy mirip, gw persingkat biar muat:
    public function edit(Product $product) {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product) {
        $data = $request->validate([
            'name' => 'required', 'category_id' => 'required', 
            'price' => 'required', 'stock' => 'required', 'description' => 'required'
        ]);

        if($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);
        return redirect()->route('admin.products.index');
    }

    public function destroy(Product $product) {
        $product->delete();
        return back();
    }
}