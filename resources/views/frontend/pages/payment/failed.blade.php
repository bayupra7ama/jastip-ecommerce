<x-frontend.layouts.app title="Pembayaran Gagal">

    <div class="checkout-section mt-150 mb-150">
        <div class="container text-center">

            <h2 class="text-danger mb-3">
                ❌ Pembayaran Gagal
            </h2>

            <p class="mb-4">
                Pembayaran tidak berhasil atau dibatalkan.
            </p>

            <a href="{{ route('cart') }}" class="boxed-btn">
                Kembali ke Keranjang
            </a>

        </div>
    </div>

</x-frontend.layouts.app>
