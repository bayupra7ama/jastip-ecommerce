<x-frontend.layouts.app title="Shop">

    {{-- Breadcrumb --}}
    @include('frontend.partials.breadcrumb', [
        'title' => 'Shop',
        'subtitle' => 'Stylish Thrift Finds for You',
    ])

    {{-- products --}}
    <div class="product-section mt-150 mb-150">
        <div class="container">

            {{-- Filter Kategori --}}
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="product-filters">
                        <ul>
                            <li class="active" data-filter="*">All</li>
                            @foreach ($categories as $cat)
                                <li data-filter=".cat-{{ $cat->id }}">{{ $cat->name }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            {{-- Daftar Produk --}}
            <div class="row product-lists">
                @forelse ($products as $p)
                    <div class="col-lg-4 col-md-6 text-center cat-{{ $p->category_id }}">
                        <div class="single-product-item">
                            <div class="product-image fixed-img">
                                <a href="{{ route('product.show', $p->id) }}">
                                    <img src="{{ asset('storage/' . $p->thumbnail) }}" alt="{{ $p->name }}">
                                </a>
                            </div>
                            <h3>{{ $p->name }}</h3>

                            <p class="product-price">
                                Rp {{ number_format($p->price, 0, ',', '.') }}
                            </p>

                            <form action="{{ route('cart.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $p->id }}">
                                <input type="hidden" name="quantity" value="1">

                                <a href="#" class="cart-btn"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                    <i class="fas fa-shopping-cart"></i> Add to Cart
                                </a>
                            </form>


                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center">
                        <p>No products available.</p>
                    </div>
                @endforelse
            </div>

            <div class="pagination-wrap">
                {{ $products->links('vendor.pagination.fruitkha') }}
            </div>


        </div>
    </div>

    <div class="modal fade" id="setPinModal" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <form method="POST" action="{{ route('pin.store') }}" class="modal-content">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">Buat PIN Transaksi</h5>
                    {{-- ❌ jangan tambahkan tombol close (X) agar tidak bisa ditutup --}}
                </div>

                <div class="modal-body px-4">

                    <p class="mb-3 text-muted">
                        Masukkan PIN keamanan 6 digit yang digunakan untuk transaksi checkout.
                    </p>

                    {{-- ⚠ tampilkan error validasi --}}
                    @if ($errors->any())
                        <div class="alert alert-danger py-2 mb-3">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <input type="password" name="pin" maxlength="6" inputmode="numeric" pattern="[0-9]*"
                        class="form-control mb-3" placeholder="Masukkan PIN" required>

                    <input type="password" name="pin_confirmation" maxlength="6" inputmode="numeric" pattern="[0-9]*"
                        class="form-control" placeholder="Ulangi PIN" required>

                </div>

                <div class="modal-footer">
                    <button type="submit" class="cart-btn w-100">
                        Simpan PIN
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-frontend.layouts.app>
