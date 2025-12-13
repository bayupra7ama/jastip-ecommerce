<x-frontend.layouts.app title="Home">

    @include('frontend.pages.sections.hero-section')
    @include('frontend.pages.sections.features-section')
    @include('frontend.pages.sections.product-section')


    <!-- Modal Set PIN -->
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
