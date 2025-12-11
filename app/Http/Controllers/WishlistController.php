<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Wishlist;
use App\Models\Product;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlists = Wishlist::where('user_id', Auth::id())->with('product')->get();
        return view('wishlist.index', compact('wishlists'));
    }

    public function store(Product $product)
    {
        // Cek duplikat biar ga double
        Wishlist::firstOrCreate([
            'user_id' => Auth::id(),
            'product_id' => $product->id
        ]);
        return back()->with('success', 'Added to wishlist');
    }

    public function destroy(Product $product)
    {
        Wishlist::where('user_id', Auth::id())
                ->where('product_id', $product->id)
                ->delete();
        return back()->with('success', 'Removed from wishlist');
    }
}