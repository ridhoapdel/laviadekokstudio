<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Campaign; 
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $campaigns = Campaign::where('start_date', '<=', now())
                            ->where('end_date', '>=', now())
                            ->get();

        $products = Product::where('stock', '>', 0) 
                           ->latest()
                           ->take(8)
                           ->get();

        return view('home', compact('campaigns', 'products'));
    }
}
