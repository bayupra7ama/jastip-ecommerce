<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Log;

class MidtransWebhookController extends Controller
{
    public function handle(Request $request)
    {
        try {
            $payload = $request->all();

            $orderCode = $payload['order_id'] ?? null;
            $transactionStatus = $payload['transaction_status'] ?? null;
            $fraudStatus = $payload['fraud_status'] ?? null;

            // 🛑 WAJIB: balas 200 walau payload aneh
            if (!$orderCode || !$transactionStatus) {
                return response()->json(['message' => 'OK']);
            }

            $order = Order::where('order_code', $orderCode)->first();

            // 🛑 Jangan 404, Midtrans benci
            if (!$order) {
                return response()->json(['message' => 'OK']);
            }

            /**
             * ===============================
             * 🔒 RULE EMAS
             * ===============================
             * PAID TIDAK BOLEH TURUN LAGI
             */
            if ($order->payment_status === 'paid') {
                return response()->json(['message' => 'OK']);
            }

            /**
             * ===============================
             * ✅ STATUS FINAL (UANG MASUK)
             * ===============================
             */
            if (in_array($transactionStatus, ['capture', 'settlement'])) {
                if ($fraudStatus === 'accept' || $fraudStatus === null) {
                    $order->update([
                        'payment_status' => 'paid',
                        'order_status'   => 'processed',
                    ]);
                }

                return response()->json(['message' => 'OK']);
            }

            /**
             * ===============================
             * ⏳ MENUNGGU PEMBAYARAN
             * ===============================
             */
            if ($transactionStatus === 'pending') {
                // ⛔ jangan override kalau sudah paid
                if ($order->payment_status !== 'paid') {
                    $order->update([
                        'payment_status' => 'pending',
                    ]);
                }

                return response()->json(['message' => 'OK']);
            }

            /**
             * ===============================
             * ❌ GAGAL / DIBATALKAN
             * ===============================
             */
            if (in_array($transactionStatus, ['deny', 'cancel', 'expire'])) {
                $order->update([
                    'payment_status' => 'failed',
                    'order_status'   => 'cancelled',
                ]);

                return response()->json(['message' => 'OK']);
            }

            return response()->json(['message' => 'OK']);

        } catch (\Throwable $e) {
            Log::error('MIDTRANS WEBHOOK ERROR', [
                'error'   => $e->getMessage(),
                'payload' => $request->all(),
            ]);

            // ⚠️ TETAP 200 → STOP RETRY MIDTRANS
            return response()->json(['message' => 'OK']);
        }
    }
}

