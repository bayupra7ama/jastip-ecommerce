<x-frontend.layouts.app title="Menunggu Pembayaran">

    <div class="checkout-section mt-150 mb-150">
        <div class="container text-center">

            <h2 class="orange-text mb-3">
                ⏳ Menunggu Pembayaran
            </h2>

            <p class="mb-4">
                Silakan selesaikan pembayaran sesuai instruksi Midtrans.
            </p>

            <a href="{{ route('orders.index') }}" class="boxed-btn">
                Cek Status Pesanan
            </a>

        </div>
    </div>

</x-frontend.layouts.app>
