<x-frontend.layouts.app title="Pembayaran Berhasil">

    <div class="checkout-section mt-150 mb-150">
        <div class="container text-center">

            <h2 class="text-success mb-3">
                🎉 Pembayaran Berhasil
            </h2>

            <p class="mb-4">
                Terima kasih! Pesanan kamu berhasil diproses.
            </p>

            <a href="{{ route('orders.index') }}" class="boxed-btn">
                Lihat Pesanan Saya
            </a>

        </div>
    </div>

</x-frontend.layouts.app>
