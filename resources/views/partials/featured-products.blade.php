<section id="featured-products" class="product-store">
    <div class="container-md">

        <div class="display-header d-flex align-items-center justify-content-between">
            <h2 class="section-title text-uppercase">Featured Products</h2>
            <a href="/shop" class="fw-bold text-uppercase">View All</a>
        </div>

        <div class="product-content padding-small">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5">

                {{-- Example static card --}}
                <div class="col mb-4">
                    <div class="product-card">
                        <div class="card-img">
                            <img src="{{ asset('assets/images/card-item1.jpg') }}" class="product-image img-fluid">
                        </div>
                        <div class="card-detail d-flex justify-content-between mt-3">
                            <h3 class="fs-6"><a href="#">Product Name</a></h3>
                            <span class="fw-bold">$99</span>
                        </div>
                    </div>
                </div>

                {{-- nanti loop produk dari database --}}
            </div>
        </div>

    </div>
</section>
    