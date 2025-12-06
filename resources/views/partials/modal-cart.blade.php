<div class="modal fade" id="modallong" tabindex="-1">
    <div class="modal-dialog modal-fullscreen-md-down modal-md modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h2 class="modal-title fs-5">Cart</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="shopping-cart">

                    <div class="shopping-cart-content">

                        {{-- EXAMPLE CART ITEM — nanti dinamis --}}
                        <div class="mini-cart cart-list p-0 mt-3">
                            <div class="mini-cart-item d-flex border-bottom pb-3">

                                <div class="col-lg-2 col-md-3 col-sm-2 me-4">
                                    <img src="{{ asset('assets/images/single-product-thumb1.jpg') }}" class="img-fluid">
                                </div>

                                <div class="col-lg-9 col-md-8 col-sm-8">
                                    <div class="product-header d-flex justify-content-between mb-3">
                                        <h4 class="product-title fs-6 me-5">Example Product</h4>
                                        <svg class="close">
                                            <use xlink:href="#close"></use>
                                        </svg>
                                    </div>

                                    <div class="quantity-price d-flex justify-content-between align-items-center">
                                        <input type="number" value="1" class="form-control w-25">
                                        <span class="product-price fs-6">$99</span>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="mini-cart-total d-flex justify-content-between py-4">
                            <span class="fs-6">Subtotal:</span>
                            <span class="fs-6 fw-bold">$198.00</span>
                        </div>

                        <div class="modal-footer my-4 justify-content-center">
                            <a class="btn btn-red hvr-sweep-to-right">View Cart</a>
                            <a class="btn btn-outline-gray hvr-sweep-to-right">Checkout</a>
                        </div>

                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
