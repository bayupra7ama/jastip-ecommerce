<x-frontend.layouts.app title="Detail Pesanan">

    {{-- Breadcrumb --}}
    @include('frontend.partials.breadcrumb', [
        'title' => 'Detail Pesanan',
        'subtitle' => $order->order_code,
    ])

    @php
        $canPay =
            in_array($order->payment_status, ['unpaid', 'pending']) &&
            !in_array($order->order_status, ['cancelled', 'completed']) &&
            !empty($order->snap_token);
    @endphp

    <div class="cart-section mt-150 mb-150">
        <div class="container">
            <div class="row">

                {{-- LEFT: ORDER ITEMS --}}
                <div class="col-lg-8 col-md-12">
                    <div class="cart-table-wrap">
                        <table class="cart-table">
                            <thead class="cart-table-head">
                                <tr class="table-head-row">
                                    <th class="product-image">Product Image</th>
                                    <th class="product-name">Name</th>
                                    <th class="product-price">Price</th>
                                    <th class="product-quantity">Quantity</th>
                                    <th class="product-total">Total</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($order->items as $item)
                                    <tr class="table-body-row">
                                        <td class="product-image">
                                            <img src="{{ asset('storage/' . $item->product->thumbnail) }}"
                                                alt="">
                                        </td>

                                        <td class="product-name">
                                            {{ $item->product->name }}
                                        </td>

                                        <td class="product-price">
                                            Rp {{ number_format($item->price, 0, ',', '.') }}
                                        </td>

                                        <td class="product-quantity">
                                            {{ $item->quantity }}
                                        </td>

                                        <td class="product-total">
                                            Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>
                </div>

                {{-- RIGHT: TOTAL + STATUS --}}
                <div class="col-lg-4">
                    <div class="total-section">

                        <table class="total-table">
                            <thead class="total-table-head">
                                <tr class="table-total-row">
                                    <th>Status</th>
                                    <th>Info</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="total-data">
                                    <td><strong>Order</strong></td>
                                    <td>
                                        <span
                                            class="badge
                                            {{ in_array($order->order_status, ['processed', 'shipped', 'completed']) ? 'bg-success' : 'bg-warning' }}">
                                            {{ strtoupper($order->order_status) }}
                                        </span>
                                    </td>
                                </tr>

                                <tr class="total-data">
                                    <td><strong>Payment</strong></td>
                                    <td>
                                        <span
                                            class="badge
                                            {{ $order->payment_status === 'paid'
                                                ? 'bg-success'
                                                : ($order->payment_status === 'pending'
                                                    ? 'bg-warning'
                                                    : 'bg-danger') }}">
                                            {{ strtoupper($order->payment_status) }}
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <table class="total-table mt-3">
                            <tbody>
                                <tr class="total-data">
                                    <td><strong>Total</strong></td>
                                    <td>
                                        Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        {{-- 🔥 MIDTRANS BUTTON --}}
                        @if ($canPay)
                            <a href="#" class="boxed-btn black mt-3 w-100" id="pay-button">
                                Bayar Sekarang
                            </a>
                        @endif


                        <a href="{{ route('orders.index') }}" class="boxed-btn mt-3 w-100">
                            Kembali ke Pesanan
                        </a>

                    </div>
                </div>

            </div>
        </div>
    </div>

    @if ($canPay)
        <script src="https://app.sandbox.midtrans.com/snap/snap.js"
            data-client-key="{{ config('services.midtrans.client_key') }}"></script>

        <script>
            document.getElementById('pay-button').addEventListener('click', function(e) {
                e.preventDefault(); // ⛔ cegah reload / pindah halaman
                window.snap.pay('{{ $order->snap_token }}');
            });
        </script>
    @endif


</x-frontend.layouts.app>
