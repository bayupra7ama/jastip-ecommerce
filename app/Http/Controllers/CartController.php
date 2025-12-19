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
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $carts = auth()->user()
            ->carts()
            ->with('product')
            ->get();

        return view('frontend.pages.cart', compact('carts'));
    }


    // ADD TO CART
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);

        $cart = Cart::where('user_id', auth()->id())
            ->where('product_id', $product->id)
            ->first();

        if ($cart) {
            // ✅ tambahkan sesuai input
            $cart->update([
                'quantity' => $cart->quantity + $request->quantity
            ]);
        } else {
            // ✅ simpan sesuai input
            Cart::create([
                'user_id' => auth()->id(),
                'product_id' => $product->id,
                'quantity' => $request->quantity,
            ]);
        }

        return redirect()->back()->with('success', 'Produk ditambahkan ke keranjang');
    }


    // UPDATE QTY
    public function update(Request $request, Cart $cart)
    {
        if ($cart->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        // cek stok
        if ($request->quantity > $cart->product->stock) {
            return response()->json([
                'error' => 'Stok tidak mencukupi'
            ], 422);
        }

        $cart->update([
            'quantity' => $request->quantity
        ]);

        return response()->json([
            'success' => true,
            'quantity' => $cart->quantity
        ]);
    }


    // REMOVE ITEM
    public function destroy(Cart $cart)
    {
        $cart->delete();
        return back();
    }
}
