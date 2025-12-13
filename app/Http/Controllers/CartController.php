<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // TAMPILKAN CART
    public function index()
    {
        $carts = auth()->user()
            ->carts()
            ->with('product')
            ->get();

        return view('frontend.pages.cart', compact('carts'));
    }

    // ADD TO CART
    public function store(Request $request)
    {
        $product = Product::findOrFail($request->product_id);

        $cart = Cart::where('user_id', auth()->id())
            ->where('product_id', $product->id)
            ->first();

        if ($cart) {
            // sudah ada → tambah quantity
            $cart->increment('quantity');
        } else {
            // belum ada → buat baru
            Cart::create([
                'user_id' => auth()->id(),
                'product_id' => $product->id,
                'quantity' => 1,
            ]);
        }

        return back()->with('success', 'Produk ditambahkan ke keranjang');
    }

    // UPDATE QTY
    public function update(Request $request, Cart $cart)
    {
        $cart->update([
            'quantity' => $request->quantity
        ]);

        return back();
    }

    // REMOVE ITEM
    public function destroy(Cart $cart)
    {
        $cart->delete();
        return back();
    }
}
