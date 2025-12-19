<x-frontend.layouts.app title="Pembayaran">

    <script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('services.midtrans.client_key') }}"></script>

    <div class="container vh-100 d-flex align-items-center justify-content-center text-center">
        <h3>Memproses Pembayaran...</h3>
    </div>


    <script>
        window.snap.pay('{{ $snapToken }}', {
            onSuccess: function(result) {
                window.location.href = "{{ route('orders.show', $order->id) }}";
            },
            onPending: function(result) {
                window.location.href = "{{ route('orders.show', $order->id) }}";
            },
            onError: function(result) {
                alert('Pembayaran gagal');
                window.location.href = "{{ route('orders.show', $order->id) }}";
            },
            onClose: function() {
                alert('Pembayaran dibatalkan');
                window.location.href = "{{ route('orders.show', $order->id) }}";
            }
        });
    </script>

</x-frontend.layouts.app>
