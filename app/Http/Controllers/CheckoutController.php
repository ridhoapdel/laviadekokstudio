<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;

class CheckoutController extends Controller
{
    // 1. Tampilkan Form Checkout
    public function create()
    {
        $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong!');
        }

        $subtotal = $cartItems->sum(fn($item) => $item->product->price * $item->qty);

        return view('checkout.create', compact('cartItems', 'subtotal'));
    }

    // 2. Proses Simpan Order (Logic Paling Penting)
    public function store(Request $request)
    {
        $request->validate([
            'address' => 'required|string|max:255',
            'phone' => 'required|numeric',
        ]);

        $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();
        if ($cartItems->isEmpty()) return redirect()->back();

        $totalAmount = $cartItems->sum(fn($item) => $item->product->price * $item->qty);

        // Pake Transaction biar kalau error, data ga masuk setengah-setengah
        DB::transaction(function () use ($request, $cartItems, $totalAmount) {
            // A. Buat Order Utama
            $order = Order::create([
                'user_id' => Auth::id(),
                'address' => $request->address,
                'phone' => $request->phone,
                'total_amount' => $totalAmount,
                'status' => 'pending',
            ]);

            // B. Pindahin Item Cart ke OrderItems
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'qty' => $item->qty,
                    'price_at_checkout' => $item->product->price, // Snapshot harga
                ]);

                // C. Kurangi Stok Produk
                $item->product->decrement('stock', $item->qty);
            }

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'qty' => $item->qty,
                'size' => $item->size, // <--- TAMBAHIN INI JANGAN LUPA
                'price_at_checkout' => $item->product->price,
            ]);

            // D. Kosongkan Keranjang
            Cart::where('user_id', Auth::id())->delete();
        });

        return redirect()->route('orders.history')->with('success', 'Order berhasil dibuat!');
    }

    // 3. Lihat History Order
    public function history()
    {
        $orders = Order::where('user_id', Auth::id())->latest()->get();
        return view('orders.history', compact('orders'));
    }

    // 4. Detail Order
    public function show(Order $order)
    {
        if ($order->user_id !== Auth::id()) abort(403);
        return view('orders.show', compact('order'));
    }
}