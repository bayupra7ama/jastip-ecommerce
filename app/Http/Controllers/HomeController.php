<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Featured: ambil 5 produk teratas
        $featured = Product::where('status', 'active')
            ->latest()
            ->take(5)
            ->get();

        // Latest products: ambil 10 produk terbaru
        $latest = Product::where('status', 'active')
            ->latest()
            ->take(10)
            ->get();

        return view('index', compact('featured', 'latest'));
    }
}
