<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
   

    public function index(Request $request)
    {
        $query = Order::where('user_id', auth()->id());

        if ($request->filled('status')) {
            $query->where('order_status', $request->status);
        }

        $orders = $query->latest()->paginate(10);

        return view('frontend.pages.orders.index', compact('orders'));
    }

    /**
     * 🔍 DETAIL PESANAN
     */
    public function show(Order $order)
    {
        // 🔐 SECURITY: pastikan order milik user
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load('items.product');

        return view('frontend.pages.orders.show', [
            'order' => $order,
            'snapToken' => $order->snap_token,
        ]);
    }
}
