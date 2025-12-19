<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('order_code')->unique();
            $table->bigInteger('total_amount');

            // STATUS PESANAN
            $table->enum('order_status', [
                'draft',      // baru dibuat
                'paid',       // sudah dibayar
                'processed',  // diproses penjual
                'shipped',    // dikirim
                'completed',  // selesai
                'cancelled',  // dibatalkan
            ])->default('draft');

            // STATUS PEMBAYARAN
            $table->enum('payment_status', [
                'unpaid',
                'pending',
                'paid',
                'failed',
                'refunded',
            ])->default('unpaid');

            $table->string('payment_method')->nullable(); // midtrans
            $table->string('midtrans_order_id')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
