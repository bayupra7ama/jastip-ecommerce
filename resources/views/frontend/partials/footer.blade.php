 {{-- <div class="logo-carousel-section">
     <div class="container">
         <div class="row">
             <div class="col-lg-12">
                 <div class="logo-carousel-inner">
                     <div class="single-logo-item">
                         <img src="https://freebiesupply.com/logos/chanel-logo/" alt="">
                     </div>
                     <div class="single-logo-item">
                         <img src="assets/img/company-logos/2.png" alt="">
                     </div>
                     <div class="single-logo-item">
                         <img src="assets/img/company-logos/3.png" alt="">
                     </div>
                     <div class="single-logo-item">
                         <img src="assets/img/company-logos/4.png" alt="">
                     </div>
                     <div class="single-logo-item">
                         <img src="assets/img/company-logos/5.png" alt="">
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </div> --}}
 {{-- <div class="footer-area">
     <div class="container">
         <div class="row">
             <div class="col-lg-3 col-md-6">
                 <div class="footer-box about-widget">
                     <h2 class="widget-title">About us</h2>
                     <p>Ut enim ad minim veniam perspiciatis unde omnis iste natus error sit voluptatem accusantium
                         doloremque laudantium, totam rem aperiam, eaque ipsa quae.</p>
                 </div>
             </div>
             <div class="col-lg-3 col-md-6">
                 <div class="footer-box get-in-touch">
                     <h2 class="widget-title">Get in Touch</h2>
                     <ul>
                         <li>34/8, East Hukupara, Gifirtok, Sadan.</li>
                         <li>support@fruitkha.com</li>
                         <li>+00 111 222 3333</li>
                     </ul>
                 </div>
             </div>
             <div class="col-lg-3 col-md-6">
                 <div class="footer-box pages">
                     <h2 class="widget-title">Pages</h2>
                     <ul>
                         <li><a href="index.html">Home</a></li>
                         <li><a href="about.html">About</a></li>
                         <li><a href="services.html">Shop</a></li>
                         <li><a href="news.html">News</a></li>
                         <li><a href="contact.html">Contact</a></li>
                     </ul>
                 </div>
             </div>
             <div class="col-lg-3 col-md-6">
                 <div class="footer-box subscribe">
                     <h2 class="widget-title">Subscribe</h2>
                     <p>Subscribe to our mailing list to get the latest updates.</p>
                     <form action="index.html">
                         <input type="email" placeholder="Email">
                         <button type="submit"><i class="fas fa-paper-plane"></i></button>
                     </form>
                 </div>
             </div>
         </div>
     </div>
 </div> --}}

 <div class="copyright">
     <div class="container">
         <div class="row">
             <div class="col-lg-6 col-md-12">
                 <p>Copyrights &copy; 2025 - <a href="https://www.instagram.com/curatedbydinda/">curatedbydinda</a>, All Rights
                     Reserved.<br>
                     Distributed By - <a href="https://themewagon.com/">Ramonasari</a>
                 </p>
             </div>
             <div class="col-lg-6 text-right col-md-12">
                 <div class="social-icons">
                     <ul>
                         <li><a href="#" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                         <li><a href="#" target="_blank"><i class="fab fa-twitter"></i></a></li>
                         <li><a href="https://www.instagram.com/curatedbydinda/" target="_blank"><i class="fab fa-instagram"></i></a></li>
                         <li><a href="#" target="_blank"><i class="fab fa-linkedin"></i></a></li>
                         <li><a href="#" target="_blank"><i class="fab fa-dribbble"></i></a></li>
                     </ul>
                 </div>
             </div>
         </div>
     </div>
 </div>

 <!-- scripts -->
 <script src="{{ asset('assets/fruitkha/js/jquery-1.11.3.min.js') }}"></script>

 <!-- Popper.js untuk Bootstrap 4 (WAJIB sebelum bootstrap.min.js) -->
 <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>

 <!-- Bootstrap JS dari template (Bootstrap 4) -->
 <!-- scripts -->
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

 {{-- 🔥 Tampilkan modal wajib set PIN --}}
 @if (session('must_set_pin') || $errors->any())
     <script>
         $(function() {
             $('#setPinModal').modal({
                 backdrop: 'static',
                 keyboard: false
             }).modal('show');
         });
     </script>
 @endif

 {{-- 🎉 Tampilkan toast sukses ketika PIN berhasil ditambahkan --}}
 @if (session('pin_success'))
     <script>
         $(function() {
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
