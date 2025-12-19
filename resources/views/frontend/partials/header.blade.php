<div class="top-header-area" id="sticker">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-sm-12 text-center">
                <div class="main-menu-wrap">

                    {{-- LOGO --}}
                    <div class="site-logo">
                        <a href="{{ route('home') }}">
                            <img src="{{ asset('assets/fruitkha/img/logo.png') }}" alt="Logo">
                        </a>
                    </div>

                    {{-- MENU --}}
                    <nav class="main-menu">
                        <ul>
                            <li class="{{ request()->routeIs('home') ? 'current-list-item' : '' }}">
                                <a href="{{ route('home') }}">Home</a>
                            </li>

                            <li class="{{ request()->routeIs('shop') ? 'current-list-item' : '' }}">
                                <a href="{{ route('shop') }}">Shop</a>
                            </li>

                            @auth
                                @if (auth()->user()->role === 'user')
                                    <li>
                                        <a href="{{ route('orders.index') }}">Pesanan Saya</a>
                                    </li>
                                @endif
                            @endauth


                            {{-- ICON AREA (WAJIB DI LI TERAKHIR) --}}
                            <li>
                                <div class="header-icons">

                                    {{-- CART --}}
                                    <a class="shopping-cart"
                                        href="{{ auth()->check() ? route('cart') : route('login') }}">
                                        <i class="fas fa-shopping-cart"></i>
                                    </a>

                                    {{-- SEARCH --}}
                                    <a class="mobile-hide search-bar-icon" href="#">
                                        <i class="fas fa-search"></i>
                                    </a>

                                    {{-- USER --}}
                                    @guest
                                        <a class="mobile-hide" href="{{ route('login') }}">
                                            <i class="fas fa-user"></i>
                                        </a>
                                    @else
                                        <a class="mobile-hide" href="#"
                                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i class="fas fa-sign-out-alt"></i>
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    @endguest

                                </div>
                            </li>
                        </ul>
                    </nav>

                    {{-- SEARCH MOBILE --}}
                    <a class="mobile-show search-bar-icon" href="#">
                        <i class="fas fa-search"></i>
                    </a>

                    <div class="mobile-menu"></div>

                </div>
            </div>
        </div>
    </div>
</div>


<div class="search-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <span class="close-btn"><i class="fas fa-window-close"></i></span>
                <div class="search-bar">
                    <div class="search-bar-tablecell">
                        <h3>Search For:</h3>
                        <input type="text" placeholder="Keywords">
                        <button type="submit">Search <i class="fas fa-search"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
