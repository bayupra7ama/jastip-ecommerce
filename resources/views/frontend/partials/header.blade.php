<div class="top-header-area" id="sticker">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-sm-12 text-center">
                <div class="main-menu-wrap">

                    <div class="site-logo">
                        <a href="#">
                            <img src="{{ asset('assets/fruitkha/img/logo.png') }}" alt="">
                        </a>
                    </div>

                    <nav class="main-menu">
                        <ul>
                            <li class="{{ request()->routeIs('home') ? 'current-list-item' : '' }}">
                                <a href="{{ route('home') }}">Home</a>
                            </li>

                            <li class="{{ request()->routeIs('shop') ? 'current-list-item' : '' }}">
                                <a href="{{ route('shop') }}">Shop</a>
                            </li>

                            @auth
                                {{-- Hanya user login (role user) --}}
                                @if (auth()->user()->role === 'user')
                                    <li><a href="#">Pesanan Saya</a></li>
                                @endif
                            @endauth

                            {{-- menu user mobile --}}
                            @guest
                                <li class="d-block d-lg-none"><a href="{{ route('login') }}">Login</a></li>
                            @else
                                {{-- <li class="d-block d-lg-none"><a href="{{ route('profile.edit') }}">Profile</a></li> --}}
                                <li class="d-block d-lg-none">
                                    <a href="#"
                                        onclick="event.preventDefault(); document.getElementById('logout-form-mobile').submit();">Logout</a>
                                    <form id="logout-form-mobile" method="POST" action="{{ route('logout') }}"
                                        class="d-none">@csrf</form>
                                </li>
                            @endguest

                            <li class="d-none d-lg-inline-block">
                                <div class="header-icons">
                                    {{-- Cart --}}
                                    <a class=" shopping-cart"
                                        href="{{ auth()->check() ? route('cart') : route('login') }}">
                                        <i class="fas fa-shopping-cart"></i>
                                    </a>

                                    {{-- Search --}}
                                    <a class="mobile-hide search-bar-icon" href="#">
                                        <i class="fas fa-search"></i>
                                    </a>

                                    {{-- User menu --}}
                                    @guest
                                        <a class="mobile-hide user-icon" href="{{ route('login') }}">
                                            <i class="fas fa-user"></i>
                                        </a>
                                    @else
                                        <div class="dropdown user-dropdown d-inline-block">
                                            <a class="mobile-hide user-icon dropdown-toggle" href="#" id="userMenu"
                                                data-toggle="dropdown">
                                                <i class="fas fa-user"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userMenu">
                                                {{-- <a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a> --}}
                                                <form method="POST" action="{{ route('logout') }}">
                                                    @csrf
                                                    <button class="dropdown-item" type="submit">Logout</button>
                                                </form>
                                            </div>
                                        </div>
                                    @endguest
                                </div>
                            </li>
                            {{-- Menu user khusus mobile --}}


                        </ul>
                    </nav>

                    <a class="mobile-show search-bar-icon" href="#"><i class="fas fa-search"></i></a>
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
