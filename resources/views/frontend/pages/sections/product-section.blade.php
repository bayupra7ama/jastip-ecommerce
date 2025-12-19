<div class="product-section mt-150 mb-150">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 text-center">
                <div class="section-title">
                    <h3><span class="orange-text">Our</span> Products</h3>
                    <p>Koleksi thrifting eksklusif dengan item langka dan berkualitas tinggi. Siapa cepat dia dapat!</p>
                </div>

            </div>
        </div>

        <div class="row">
            @forelse ($products as $product)
                <div class="col-lg-4 col-md-6 text-center mb-4">
                    <div class="single-product-item">
                        <div class="product-image fixed-img">
                            <a href="{{ url('product/' . $product->id) }}">
                                <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="{{ $product->name }}">
                            </a>
                        </div>
                        <h3>{{ $product->name }}</h3>

                        <p class="product-price">
                            {{-- Sesuaikan field di tabel kamu --}}
                            @if (!empty($product->unit))
                                <span>{{ $product->unit }}</span>
                            @endif
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </p>

                        <form action="{{ route('cart.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
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
                    <p>Belum ada produk tersedia.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
