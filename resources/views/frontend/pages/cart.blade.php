<x-frontend.layouts.app title="Cart" subtitle="Fresh and Organic">

    {{-- Breadcrumb --}}
    @include('frontend.partials.breadcrumb', [
        'title' => 'Keranjang',
        'subtitle' => 'Pilih barang yang akan di checkout',
    ])

    {{-- CART SECTION --}}
    <div class="cart-section mt-150 mb-150">
        <div class="container">
            <div class="row">

                {{-- LEFT: CART TABLE --}}
                <div class="col-lg-8 col-md-12">
                    <div class="cart-table-wrap">
                        <table class="cart-table">
                            <thead class="cart-table-head">
                                <tr class="table-head-row">
                                    <th class="product-select">Select</th>
                                    <th class="product-image">Product Image</th>
                                    <th class="product-name">Name</th>
                                    <th class="product-price">Price</th>
                                    <th class="product-quantity">Quantity</th>
                                    <th class="product-total">Total</th>
                                    <th class="product-remove"></th>
                                </tr>
                            </thead>


                            <tbody>
                                @foreach ($carts as $cart)
                                    <tr class="table-body-row cart-row" data-price="{{ $cart->product->price }}">

                                        <td class="product-select text-center">
                                            <input type="checkbox" class="select-item" checked>
                                        </td>

                                        <td class="product-image">
                                            <img src="{{ asset('storage/' . $cart->product->thumbnail) }}">
                                        </td>

                                        <td>{{ $cart->product->name }}</td>

                                        <td class="unit-price">
                                            Rp {{ number_format($cart->product->price, 0, ',', '.') }}
                                        </td>

                                        <td>
                                            <input type="number" class="qty-input" value="{{ $cart->quantity }}"
                                                min="1">
                                        </td>

                                        <td class="row-total">
                                            Rp 0
                                        </td>

                                        <td>
                                            <form action="{{ route('cart.destroy', $cart) }}" method="POST">
                                                @csrf @method('DELETE')
                                                <button class="btn-reset">
                                                    <i class="far fa-window-close"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>


                        </table>
                    </div>
                </div>

                {{-- RIGHT: TOTAL --}}
                 <div class="col-lg-4">
                <div class="total-section">
                    <table class="total-table">
                        <thead class="total-table-head">
                            <tr class="table-total-row">
                                <th>Total</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="total-data">
                                <td><strong>Subtotal:</strong></td>
                                <td id="subtotal">Rp 0</td>
                            </tr>
                            <tr class="total-data">
                                <td><strong>Total:</strong></td>
                                <td id="grand-total">Rp 0</td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="cart-buttons">
                        <a href="#" class="boxed-btn">Update Cart</a>
                        <a href="{{ route('checkout') }}" class="boxed-btn black">Check Out</a>
                    </div>
                </div>
            </div>

            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function formatRupiah(number) {
                return 'Rp ' + number.toLocaleString('id-ID');
            }

            function updateCartTotal() {
                let subtotal = 0;

                document.querySelectorAll('.cart-row').forEach(row => {
                    const price = parseInt(row.dataset.price);
                    const qty = parseInt(row.querySelector('.qty-input').value);
                    const checked = row.querySelector('.select-item').checked;

                    let rowTotal = price * qty;

                    if (checked) {
                        subtotal += rowTotal;
                    }

                    row.querySelector('.row-total').innerText = formatRupiah(rowTotal);
                });

                document.getElementById('subtotal').innerText = formatRupiah(subtotal);
                document.getElementById('grand-total').innerText = formatRupiah(subtotal);
            }

            // Event listeners
            document.addEventListener('DOMContentLoaded', () => {
                updateCartTotal();

                document.querySelectorAll('.qty-input, .select-item').forEach(el => {
                    el.addEventListener('change', updateCartTotal);
                });
            });
        </script>
    @endpush
</x-frontend.layouts.app>
