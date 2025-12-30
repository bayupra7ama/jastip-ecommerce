<div class="copyright">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-12">
                <p>
                    Copyrights &copy; 2025 -
                    <a href="https://www.instagram.com/curatedbydinda/">curatedbydinda</a>,
                    All Rights Reserved.<br>
                    Distributed By -
                    <a href="https://themewagon.com/">Ramonasari</a>
                </p>
            </div>
            <div class="col-lg-6 text-right col-md-12">
                <div class="social-icons">
                    <ul>
                        <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                        <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                        <li>
                            <a href="https://www.instagram.com/curatedbydinda/" target="_blank">
                                <i class="fab fa-instagram"></i>
                            </a>
                        </li>
                        <li><a href="#"><i class="fab fa-linkedin"></i></a></li>
                        <li><a href="#"><i class="fab fa-dribbble"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ================== SCRIPTS (URUTAN WAJIB) ================== --}}
<script src="{{ asset('assets/fruitkha/js/jquery-1.11.3.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>
<script src="{{ asset('assets/fruitkha/bootstrap/js/bootstrap.min.js') }}"></script>

<script src="{{ asset('assets/fruitkha/js/jquery.countdown.js') }}"></script>
<script src="{{ asset('assets/fruitkha/js/jquery.isotope-3.0.6.min.js') }}"></script>
<script src="{{ asset('assets/fruitkha/js/waypoints.js') }}"></script>
<script src="{{ asset('assets/fruitkha/js/owl.carousel.min.js') }}"></script>
<script src="{{ asset('assets/fruitkha/js/jquery.magnific-popup.min.js') }}"></script>
<script src="{{ asset('assets/fruitkha/js/jquery.meanmenu.min.js') }}"></script>
<script src="{{ asset('assets/fruitkha/js/sticker.js') }}"></script>
<script src="{{ asset('assets/fruitkha/js/main.js') }}"></script>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const loader = document.querySelector('.loader');
        if (!loader) return;

        // MATIKAN loader saat halaman load
        window.addEventListener('load', () => {
            loader.style.display = 'none';
        });

        // 🔥 EVENT DELEGATION (INI KUNCI)
        document.body.addEventListener('click', function(e) {
            const link = e.target.closest('a');
            if (!link) return;

            const href = link.getAttribute('href');

            // ❌ JANGAN TAMPILKAN LOADER UNTUK:
            if (
                !href ||
                href === '#' ||
                href.startsWith('javascript') ||
                link.target === '_blank' ||
                link.closest('.mean-container') || // 🔥 FIX UTAMA
                link.closest('.search-area') ||
                link.closest('.mobile-menu')
            ) {
                return;
            }

            // ✅ BARU NYALAKAN LOADER
            loader.style.display = 'block';
        });

        // BACK / BFCache
        window.addEventListener('pageshow', () => {
            loader.style.display = 'none';
        });
    });
</script>




{{-- ================== MODAL SET PIN (SATU-SATUNYA) ================== --}}
@if (session('must_set_pin'))
    <script>
        $(document).ready(function() {
            $('#setPinModal').modal({
                backdrop: 'static',
                keyboard: false
            });
        });
    </script>
@endif

{{-- ================== TOAST PIN SUCCESS ================== --}}
@if (session('pin_success'))
    <script>
        $(document).ready(function() {
            let toastHTML = `
        <div class="toast align-items-center text-white bg-success border-0"
             style="position: fixed; top: 20px; right: 20px; z-index: 9999;" role="alert">
            <div class="d-flex">
                <div class="toast-body">
                    PIN berhasil ditambahkan 🎉
                </div>
                <button type="button" class="ml-2 mb-1 close text-white" data-dismiss="toast">×</button>
            </div>
        </div>`;
            $('body').append(toastHTML);
            $('.toast').toast({
                delay: 4000
            });
            $('.toast').toast('show');
        });
    </script>
@endif
