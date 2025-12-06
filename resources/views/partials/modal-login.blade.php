<div class="modal fade" id="modallogin" tabindex="-1">
    <div class="modal-dialog modal-fullscreen-md-down modal-md modal-dialog-centered">
        <div class="modal-content p-4">
            <div class="modal-header mx-auto border-0">
                <h2 class="modal-title fs-3 fw-normal">Login</h2>
            </div>

            <div class="modal-body">
                <div class="login-detail">
                    <div class="login-form p-0">
                        <div class="col-lg-12 mx-auto">

                            {{-- FORM LOGIN STARTER KIT --}}
                            <form method="POST" action="{{ route('login') }}" id="login-form">
                                @csrf

                                <input type="email" name="email" required placeholder="Email Address *"
                                    class="mb-3 ps-3 text-input">

                                <input type="password" name="password" required placeholder="Password"
                                    class="ps-3 text-input">

                                <div class="checkbox d-flex justify-content-between mt-4">
                                    <p class="checkbox-form">
                                        <label>
                                            <input type="checkbox" name="remember"> Remember me
                                        </label>
                                    </p>
                                    <p class="lost-password">
                                        <a href="{{ route('password.request') }}">Forgot your password?</a>
                                    </p>
                                </div>

                                <div class="modal-footer mt-5 d-flex justify-content-center">
                                    <button type="submit" class="btn btn-red hvr-sweep-to-right dark-sweep">
                                        Login
                                    </button>


                                    <button type="button" class="btn btn-outline-gray hvr-sweep-to-right"
                                        data-bs-toggle="modal" data-bs-target="#modalregister" data-bs-dismiss="modal">
                                        Register
                                    </button>



                                </div>

                            </form>
                            {{-- END FORM LOGIN --}}

                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
