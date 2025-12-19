<x-frontend.layouts.app title="Checkout">

    <!-- breadcrumb -->
    <div class="breadcrumb-section breadcrumb-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 text-center">
                    <div class="breadcrumb-text">
                        <p>Second Hand & Thrift</p>
                        <h1>Checkout</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- checkout section -->
    <div class="checkout-section mt-150 mb-150">
        <div class="container">
            <div class="row">

                <!-- LEFT : FORM -->
                <div class="col-lg-8">
                    <div class="checkout-accordion-wrap">
                        <div class="accordion" id="checkoutAccordion">

                            <!-- Billing -->
                            <div class="card single-accordion">
                                <div class="card-header" id="headingOne">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link" type="button" data-toggle="collapse"
                                            data-target="#billing" aria-expanded="true">
                                            Billing Address
                                        </button>
                                    </h5>
                                </div>

                                <div id="billing" class="collapse show" data-parent="#checkoutAccordion">
                                    <div class="card-body">
                                        <div class="billing-address-form">
                                            <form id="billing-form">
                                                <p>
                                                    <input type="text" name="customer_name"
                                                        placeholder="Nama Lengkap">
                                                </p>
                                                <p>
                                                    <input type="email" name="customer_email" placeholder="Email">
                                                </p>
                                                <p>
                                                    <input type="text" name="shipping_address"
                                                        placeholder="Alamat Lengkap">
                                                </p>
                                                <p>
                                                    <input type="tel" name="customer_phone"
                                                        placeholder="No. HP / WhatsApp">
                                                </p>
                                                <p>
                                                    <textarea name="note" cols="30" rows="5" placeholder="Catatan (opsional)"></textarea>
                                                </p>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                            </div>


                        </div>
                    </div>
                </div>

                <!-- RIGHT : ORDER SUMMARY -->
                <div class="col-lg-4 col-sm-12">
                    <div class="order-details-wrap">
                        <table class="order-details">
                            <thead>
                                <tr>
                                    <th>Produk</th>
                                    <th>Total</th>
                                </tr>
                            </thead>

                            <tbody class="order-details-body">
                                @php $subtotal = 0; @endphp

                                @foreach ($carts as $cart)
                                    @php
                                        $total = $cart->product->price * $cart->quantity;
                                        $subtotal += $total;
                                    @endphp

                                    <tr>
                                        <td>
                                            {{ $cart->product->name }}
                                            x {{ $cart->quantity }}
                                        </td>
                                        <td>
                                            Rp {{ number_format($total, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>

                            <tbody class="checkout-details">
                                <tr>
                                    <td>Subtotal</td>
                                    <td>
                                        Rp {{ number_format($subtotal, 0, ',', '.') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Total</strong></td>
                                    <td>
                                        <strong>
                                            Rp {{ number_format($subtotal, 0, ',', '.') }}
                                        </strong>
                                    </td>
                                </tr>

                            </tbody>
                        </table>

                        <a href="#" class="boxed-btn" id="btn-buat-pesanan">
                            Buat Pesanan
                        </a>
                    </div>
                </div>

            </div>
        </div>

        <form id="checkout-store-form" action="{{ route('checkout.store') }}" method="POST" style="display:none;">
            @csrf

            <input type="hidden" name="customer_name">
            <input type="hidden" name="customer_email">
            <input type="hidden" name="shipping_address">
            <input type="hidden" name="customer_phone">
            <input type="hidden" name="note">

            <input type="hidden" name="selected_items" value="{{ json_encode($carts->pluck('id')->values()) }}
">

            <input type="hidden" name="pin">
        </form>





    </div>
    <div class="modal fade" id="pinModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Masukkan PIN Transaksi</h5>
                </div>

                <div class="modal-body">
                    <input type="password" id="pin-input" class="form-control" maxlength="6" placeholder="PIN 6 digit">
                </div>

                <div class="modal-footer">
                    <button type="button" class="boxed-btn" id="btn-confirm-pin">
                        Konfirmasi
                    </button>
                </div>

            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const btnBuatPesanan = document.getElementById('btn-buat-pesanan');
            const btnConfirmPin = document.getElementById('btn-confirm-pin');

            if (!btnBuatPesanan) {
                console.error('Button Buat Pesanan tidak ditemukan');
                return;
            }

            btnBuatPesanan.addEventListener('click', function(e) {
                e.preventDefault();

                const billingForm = document.getElementById('billing-form');

                const name = billingForm.customer_name.value.trim();
                const email = billingForm.customer_email.value.trim();
                const address = billingForm.shipping_address.value.trim();
                const phone = billingForm.customer_phone.value.trim();
                const note = billingForm.note.value.trim();

                if (!name || !email || !address || !phone) {
                    alert('Lengkapi alamat terlebih dahulu');
                    return;
                }

                const storeForm = document.getElementById('checkout-store-form');
                storeForm.customer_name.value = name;
                storeForm.customer_email.value = email;
                storeForm.shipping_address.value = address;
                storeForm.customer_phone.value = phone;
                storeForm.note.value = note;

                // tampilkan modal PIN
                $('#pinModal').modal('show');
            });

            btnConfirmPin.addEventListener('click', function() {
                const pin = document.getElementById('pin-input').value;

                if (!pin || pin.length !== 6) {
                    alert('PIN harus 6 digit');
                    return;
                }

                // isi PIN
                document.querySelector('#checkout-store-form input[name="pin"]').value = pin;

                // 🔥 TAMPILKAN PRELOADER GLOBAL
                const loader = document.querySelector('.loader');
                if (loader) {
                    loader.style.display = 'flex';
                }

                // cegah double submit
                btnConfirmPin.disabled = true;

                // optional: tutup modal dulu
                $('#pinModal').modal('hide');

                // submit form
                document.getElementById('checkout-store-form').submit();
            });

        });
    </script>


</x-frontend.layouts.app>
