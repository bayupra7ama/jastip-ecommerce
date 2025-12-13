<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;

use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function home()
    {
        $products = Product::latest()->take(6)->get();
        return view('frontend.pages.home', compact('products'));
    }

    public function shop()
    {
        $categories = Category::withCount('products')->get(); // untuk filter
        $products = Product::with('category')->latest()->paginate(12);

        return view('frontend.pages.shop', compact('products', 'categories'));
    }

    public function product(Product $product)
    {
        $product->load(['images', 'category']); // eager load relasi

        return view('frontend.pages.single-product', compact('product'));
    }

     public function cart()
    {
        return view('frontend.pages.cart', [
            'title' => 'Cart',
            'subtitle' => 'Keranjang Pesanan Anda'
        ]);
    }

}
