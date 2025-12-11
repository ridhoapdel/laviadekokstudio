<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Product;

class CartController extends Controller
{
    // 1. Tampilkan Keranjang
    public function index()
    {
        // Ambil keranjang user login + data produknya
        $cartItems = Cart::where('user_id', Auth::id())
                            ->with('product') 
                            ->get();

        // Hitung Subtotal (Harga x Qty)
        $subtotal = $cartItems->sum(function($item) {
            return $item->product->price * $item->qty;
        });

        return view('cart.index', compact('cartItems', 'subtotal'));
    }

    // 2. Tambah ke Keranjang (Logic Baru)
    public function store(Request $request, Product $product)
    {
        // 1. Validasi: Ukuran & Quantity WAJIB
        $request->validate([
            'size' => 'required|string',
            'qty' => 'required|integer|min:1|max:' . $product->stock, // Gaboleh lebih dari stok
        ]);

        // 2. Cek Produk Duplikat
        $existingCart = Cart::where('user_id', Auth::id())
                            ->where('product_id', $product->id)
                            ->where('size', $request->size)
                            ->first();

        if ($existingCart) {
            // Cek dulu, kalau ditambah qty baru apakah melebihi stok?
            if (($existingCart->qty + $request->qty) > $product->stock) {
                return back()->with('error', 'Stok tidak cukup untuk menambah jumlah ini.');
            }

            // Kalau aman, update qty
            $existingCart->qty += $request->qty;
            $existingCart->save();
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'qty' => $request->qty, // Ambil dari input user
                'size' => $request->size
            ]);
        }

        // 3. Action Redirect
        if ($request->input('action') === 'buy_now') {
            return redirect()->route('checkout.create');
        }

        return redirect()->back()->with('success', 'Produk berhasil masuk keranjang!');
    }

    // 3. Hapus Item
    public function destroy(Cart $cart)
    {
        // Pastikan yang ngehapus adalah pemilik keranjang
        if ($cart->user_id !== Auth::id()) {
            abort(403);
        }

        $cart->delete();
        return redirect()->back()->with('success', 'Item dihapus dari keranjang.');
    }

    // 4. Update Qty (Optional, buat fitur di halaman cart nanti)
    public function update(Request $request, Cart $cart)
    {
        if ($cart->user_id !== Auth::id()) abort(403);
        
        // Update logic simple
        if ($request->type === 'plus') {
            $cart->increment('qty');
        } elseif ($request->type === 'minus' && $cart->qty > 1) {
            $cart->decrement('qty');
        }

        return back();
    }
}