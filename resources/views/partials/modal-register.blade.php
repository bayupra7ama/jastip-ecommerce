<div class="modal fade" id="modalregister" tabindex="-1">
    <div class="modal-dialog modal-fullscreen-md-down modal-md modal-dialog-centered">
        <div class="modal-content p-4">

            <div class="modal-header mx-auto border-0">
                <h2 class="modal-title fs-3 fw-normal">Register</h2>
            </div>

            <div class="modal-body">
                <div class="login-detail">
                    <div class="login-form p-0">
                        <div class="col-lg-12 mx-auto">

                            {{-- FORM REGISTER STARTER KIT --}}
                            <form method="POST" action="{{ route('register') }}" id="register-form">
                                @csrf

                                <input type="text" name="name" required placeholder="Full Name *"
                                    class="mb-3 ps-3 text-input">

                                <input type="email" name="email" required placeholder="Email Address *"
                                    class="mb-3 ps-3 text-input">

                                <input type="password" name="password" required placeholder="Password *"
                                    class="mb-3 ps-3 text-input">

                                <input type="password" name="password_confirmation" required
                                    placeholder="Confirm Password *" class="mb-3 ps-3 text-input">

                                <div class="modal-footer mt-4 d-flex justify-content-center">

                                    <button type="submit" class="btn btn-red hvr-sweep-to-right dark-sweep">
                                        Register
                                    </button>

                                    <button type="button" class="btn btn-outline-gray hvr-sweep-to-right"
                                        data-bs-toggle="modal" data-bs-target="#modallogin" data-bs-dismiss="modal">
                                        Already have account?
                                    </button>

                                </div>

                            </form>
                            {{-- END FORM REGISTER --}}

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
