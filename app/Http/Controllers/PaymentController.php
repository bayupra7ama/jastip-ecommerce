<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    // public function callback(Request $request)
    // {
    //     $order = Order::where('order_code', $request->order_id)->first();

    //     if (!$order)
    //         return response()->json(['error' => 'Order not found']);

    //     if ($request->transaction_status === 'settlement') {
    //         $order->update([
    //             'payment_status' => 'paid',
    //             'order_status' => 'confirmed',
    //         ]);
    //     }

    //     if ($request->transaction_status === 'expire') {
    //         $order->update([
    //             'payment_status' => 'expired',
    //         ]);
    //     }

    //     return response()->json(['status' => 'ok']);
    // }

    public function success(Request $request)
    {
        return view('frontend.pages.payment.success');
    }

    public function pending(Request $request)
    {
        return view('frontend.pages.payment.pending');
    }

    public function failed(Request $request)
    {
        return view('frontend.pages.payment.failed');
    }
}
