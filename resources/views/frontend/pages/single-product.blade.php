<x-frontend.layouts.app :title="$product->name">

    {{-- breadcrumb --}}
    @include('frontend.partials.breadcrumb', [
        'title' => $product->name,
        'subtitle' => 'See more Details',
    ])

    <!-- single product -->
    <div class="single-product mt-150 mb-150">
        <div class="container">
            <div class="row">
                {{-- Gambar --}}
                <div class="col-md-5">
                    <div class="single-product-img">

                        <div id="productCarousel" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner">

                                {{-- Slide pertama: thumbnail utama --}}
                                <div class="carousel-item active">
                                    <img src="{{ asset('storage/' . $product->thumbnail) }}"
                                        class=" carousel-img  d-block w-100 img-fluid rounded"
                                        alt="{{ $product->name }}">
                                </div>

                                {{-- Slide berikutnya: gambar tambahan dari tabel product_images --}}
                                @foreach ($product->images as $img)
                                    <div class="carousel-item">
                                        <img src="{{ asset('storage/' . $img->image) }}"
                                            class=" carousel-img d-block w-100 img-fluid rounded"
                                            alt="{{ $product->name }}">
                                    </div>
                                @endforeach

                            </div>

                            {{-- Tombol prev / next --}}
                            <a class="carousel-control-prev" href="javascript:void(0)" role="button" data-slide="prev"
                                onclick="$('#productCarousel').carousel('prev')">
                                <span class="carousel-control-prev-icon"></span>
                            </a>

                            <a class="carousel-control-next" href="javascript:void(0)" role="button" data-slide="next"
                                onclick="$('#productCarousel').carousel('next')">
                                <span class="carousel-control-next-icon"></span>
                            </a>


                        </div>

                    </div>
                </div>


                {{-- Konten --}}
                <div class="col-md-7">
                    <div class="single-product-content">
                        <h3>{{ $product->name }}</h3>
                        @if (!empty($product->category))
                            <p><strong>Category: </strong>{{ $product->category->name }}</p>
                        @endif
                        <p class="single-product-pricing">
                            <span>Price</span>
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </p>

                        <p>{{ $product->description }}</p>

                        <div class="single-product-form">
                            <form action="{{ route('cart.store') }}" method="POST" id="add-to-cart-form">
                                @csrf

                                <input type="hidden" name="product_id" value="{{ $product->id }}">

                                <input type="number" name="quantity" min="1" value="1">

                                <a href="#" class="cart-btn"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                    <i class="fas fa-shopping-cart"></i> Add to Cart
                                </a>
                            </form>

                            <p>
                                <strong>Categories:</strong> {{ $product->category->name }}
                            </p>
                        </div>





                        {{-- kategori (opsional) --}}

                    </div>

                    <h4>Share:</h4>
                    <ul class="product-share">
                        <li><a href=""><i class="fab fa-facebook-f"></i></a></li>
                        <li><a href=""><i class="fab fa-twitter"></i></a></li>
                        <li><a href=""><i class="fab fa-google-plus-g"></i></a></li>
                        <li><a href=""><i class="fab fa-linkedin"></i></a></li>
                    </ul>

                </div>
            </div>

        </div>
    </div>
    </div>
</x-frontend.layouts.app>
