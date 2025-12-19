<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Services\MidtransService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        // 1️⃣ Ambil item[] dari query string
        $itemIds = $request->input('items');

        // 2️⃣ Validasi awal
        if (!$itemIds || !is_array($itemIds) || count($itemIds) === 0) {
            return redirect()->route('cart')
                ->with('error', 'Pilih minimal satu produk');
        }

        // 3️⃣ Ambil cart sesuai user login
        $carts = Cart::with('product')
            ->where('user_id', auth()->id())
            ->whereIn('id', $itemIds)
            ->get();

        // 4️⃣ Cegah item palsu / cart kosong
        if ($carts->isEmpty()) {
            return redirect()->route('cart')
                ->with('error', 'Item tidak ditemukan');
        }

        // 5️⃣ Simpan ke session buat proses store
        session(['checkout_items' => $itemIds]);

        return view('frontend.pages.checkout', compact('carts'));

    }
    public function store(Request $request)
    {
        /**
         * 1️⃣ VALIDASI INPUT
         */
        $request->validate([
            'pin' => 'required|digits:6',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email',
            'shipping_address' => 'required|string',
            'customer_phone' => 'required|string|max:20',
            'note' => 'nullable|string|max:255',


        ]);

        /**
         * 2️⃣ AMBIL ITEM CHECKOUT DARI SESSION
         */
        $cartIds = session('checkout_items');

        if (!$cartIds || !is_array($cartIds)) {
            return redirect()->route('cart')
                ->withErrors(['cart' => 'Session checkout habis']);
        }

        /**
         * 3️⃣ VALIDASI PIN USER
         */
        $user = auth()->user();

        if (!$user->transaction_pin) {
            return back()->withErrors([
                'pin' => 'PIN belum disetel',
            ]);
        }

        if (!Hash::check($request->pin, $user->transaction_pin)) {
            return back()->withErrors([
                'pin' => 'PIN salah',
            ]);
        }

        /**
         * 4️⃣ AMBIL CART + PRODUCT (LOCK UNTUK AMAN)
         */
        $carts = Cart::with([
            'product' => function ($q) {
                $q->lockForUpdate();
            }
        ])
            ->where('user_id', $user->id)
            ->whereIn('id', $cartIds)
            ->get();

        if ($carts->isEmpty()) {
            return redirect()->route('cart')
                ->withErrors(['cart' => 'Keranjang kosong']);
        }

        /**
         * 5️⃣ VALIDASI STOK + HITUNG TOTAL
         */
        $total = 0;

        foreach ($carts as $cart) {
            if ($cart->quantity > $cart->product->stock) {
                return back()->withErrors([
                    'stock' => 'Stok produk "' . $cart->product->name . '" tidak mencukupi',
                ]);
            }

            $total += $cart->product->price * $cart->quantity;
        }

        /**
         * 6️⃣ SIMPAN ORDER + ORDER ITEMS (TRANSACTION)
         */
        DB::beginTransaction();

        try {
            $order = Order::create([
                'user_id' => $user->id,
                'order_code' => 'INV-' . now()->format('YmdHis'),
                'customer_name' => $request->customer_name,
                'customer_email' => $request->customer_email,
                'shipping_address' => $request->shipping_address,
                'customer_phone' => $request->customer_phone,
                'note' => $request->note,
                'total_amount' => $total,
                'order_status' => 'draft',
                'payment_status' => 'unpaid',
                'payment_method' => 'midtrans',
            ]);

            foreach ($carts as $cart) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cart->product_id,
                    'price' => $cart->product->price,
                    'quantity' => $cart->quantity,
                ]);

                $cart->product->decrement('stock', $cart->quantity);
            }

            Cart::whereIn('id', $cartIds)->delete();
            session()->forget('checkout_items');

            // 🔥 BUAT SNAP TOKEN SEKALI
            $snapToken = MidtransService::createSnapToken($order);

            // 🔥 SIMPAN TOKEN
            $order->update([
                'snap_token' => $snapToken,
            ]);

            DB::commit();

        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e->getMessage());
        }

        return view('frontend.pages.payment', [
            'order' => $order,
            'snapToken' => $order->snap_token,
        ]);

        // DB::commit();

        // // 🔥 GENERATE SNAP TOKEN SETELAH ORDER ADA
        // $snapToken = MidtransService::createSnapToken($order);

        // return view('frontend.pages.payment', [
        //     'order' => $order,
        //     'snapToken' => $snapToken,
        // ]);


    }


}
