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
                                    <tr class="table-body-row cart-row" data-price="{{ $cart->product->price }}"
                                        data-cart-id="{{ $cart->id }}">


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
                                            <div class="qty-wrapper" style="position: relative;">
                                                <input type="number" class="qty-input" value="{{ $cart->quantity }}"
                                                    min="1" data-old="{{ $cart->quantity }}">

                                                <div class="qty-loader"
                                                    style="display:none;
                    position:absolute;
                    right:8px;
                    top:50%;
                    transform:translateY(-50%);
                    font-size:12px;">
                                                    ⏳
                                                </div>
                                            </div>
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

                        <a href="{{ route('checkout.index') }}" class="boxed-btn black mt-2" id="checkout-link"
                            data-no-loader>
                            Check Out
                        </a>





                    </div>
                </div>

            </div>
        </div>
    </div>

    @push('scripts')
        <meta name="csrf-token" content="{{ csrf_token() }}">

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

                    const rowTotal = price * qty;

                    if (checked) subtotal += rowTotal;

                    row.querySelector('.row-total').innerText = formatRupiah(rowTotal);
                });

                document.getElementById('subtotal').innerText = formatRupiah(subtotal);
                document.getElementById('grand-total').innerText = formatRupiah(subtotal);
            }

            document.addEventListener('DOMContentLoaded', () => {
                updateCartTotal();

                document.querySelectorAll('.qty-input').forEach(input => {
                    input.addEventListener('change', function() {
                        const row = this.closest('.cart-row');
                        const cartId = row.dataset.cartId;
                        const loader = row.querySelector('.qty-loader');

                        const oldQty = this.dataset.old;
                        const newQty = parseInt(this.value);

                        // tampilkan loader & lock input
                        loader.style.display = 'inline';
                        this.disabled = true;

                        fetch(`/cart/${cartId}`, {
                                method: 'PATCH',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document
                                        .querySelector('meta[name="csrf-token"]')
                                        .getAttribute('content'),
                                },
                                body: JSON.stringify({
                                    quantity: newQty
                                })
                            })
                            .then(res => {
                                if (!res.ok) throw new Error('stok');
                                return res.json();
                            })
                            .then(data => {
                                // sukses → simpan qty baru
                                this.dataset.old = data.quantity;
                                updateCartTotal();
                            })
                            .catch(() => {
                                // gagal → rollback qty
                                alert('Stok tidak mencukupi');
                                this.value = oldQty;
                            })
                            .finally(() => {
                                // balikin UI
                                loader.style.display = 'none';
                                this.disabled = false;
                            });
                    });
                });

                document.querySelectorAll('.select-item').forEach(el => {
                    el.addEventListener('change', updateCartTotal);
                });

                const checkoutLink = document.getElementById('checkout-link');

                checkoutLink.addEventListener('click', function(e) {
                    e.preventDefault();

                    let selected = [];

                    document.querySelectorAll('.cart-row').forEach(row => {
                        if (row.querySelector('.select-item').checked) {
                            selected.push(row.dataset.cartId);
                        }
                    });

                    if (selected.length === 0) {
                        alert('Pilih minimal satu produk');
                        return;
                    }

                    const url = new URL(this.href);
                    selected.forEach(id => url.searchParams.append('items[]', id));

                    window.location.href = url.toString();
                });
            });
        </script>
    @endpush


</x-frontend.layouts.app>
