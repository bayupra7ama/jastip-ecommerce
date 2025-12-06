<section id="latest-products" class="product-store py-2 my-2 py-md-5 my-md-5 pt-0">
    <div class="container-md">

        <div class="display-header d-flex align-items-center justify-content-between">
            <h2 class="section-title text-uppercase">Latest Products</h2>
            <a href="/shop" class="fw-bold text-uppercase">View all</a>
        </div>

        <div class="product-content padding-small">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5">

                <div class="col mb-4">
                    <div class="product-card">
                        <div class="card-img">
                            <img src="{{ asset('assets/images/card-item6.jpg') }}" class="product-image img-fluid">
                        </div>
                        <div class="card-detail d-flex justify-content-between mt-3">
                            <h3 class="fs-6"><a href="#">Running Shoes</a></h3>
                            <span class="fw-bold">$99</span>
                        </div>
                    </div>
                </div>

                {{-- Loop dynamic produk nanti --}}
            </div>
        </div>

    </div>
</section>
