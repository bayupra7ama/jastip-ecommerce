<!DOCTYPE html>
<html lang="en">

<head>

    @include('frontend.partials.head')
    <title>{{ $title ?? 'Trift' }}</title>
</head>

<body>

    @include('frontend.partials.preloader')

    @include('frontend.partials.header')

    {{ $slot }}

    @include('frontend.partials.footer')
    @include('frontend.partials.toast')

    @stack('scripts')



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
    @if (session('must_set_pin'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                $('#setPinModal').modal('show');
            });
        </script>
    @endif

</body>

</html>
