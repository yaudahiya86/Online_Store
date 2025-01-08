<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- <link rel="website icon" type="png" href="img/gasos.jpg"> --}}
    @yield('linkcss')
    
    <title>@yield('title')</title>
</head>
<body class="kj">
    <div class="top-bar">
        <div class="contact-info">
            <i class='bx bx-phone'></i>
            <span>No.Telp: +623 323 7890</span>
        </div>
        <div class="icons">
            <a href="{{route('keranjang')}}"><i class='bx bx-cart'></i></a>
            <a href="profil.html"><i class='bx bx-user'></i></a>
        </div>
    </div>
    <nav>
        <div class="nav-bar">
            <i class='bx bx-menu sidebarOpen' ></i>
            <span class="logo navLogo">
                <a href="#">
                    <img src="https://images.tokopedia.net/img/cache/500-square/VqbcmM/2023/2/21/687a2414-b21a-4c01-bbf8-1fceb9410cae.jpg" alt="Logo" class="logo-img">
                    FLOWER 
                </a>
            </span>
            <div class="menu">
                <div class="logo-toggle">
                    <span class="logo navLogo">
                        <a href="{{route('beranda')}}">
                            <img src="https://images.tokopedia.net/img/cache/500-square/VqbcmM/2023/2/21/687a2414-b21a-4c01-bbf8-1fceb9410cae.jpg" alt="Logo" class="logo-img">
                            FLOWER
                        </a>
                    </span>             
                    <i class='bx bx-x siderbarClose'></i>
                </div>
                <ul class="nav-links">
                    <li><a href="{{route('beranda')}}">Beranda</a></li>
                    <li><a href="#" class="active">Produk</a></li>
                    <li><a href="#" class="active2">Tentang Kami</a></li>
                    <li><a href="#" class="active3">Kontak Kami</a></li>
                </ul>
            </div>
            <div class="darkLight-searchBox">
                <div class="dark-light">
                  <i class='bx bx-sun sun'></i>
                    <i class='bx bx-moon moon'></i>
                </div>
                <div class="searchBox">
                   <div class="searchToggle">
                    <i class='bx bx-x cancel'></i>
                    <i class='bx bx-search search'></i>
                   </div>
                    <div class="search-field">
                        <input type="text" placeholder="Search...">
                        <i class='bx bx-search'></i>
                    </div>
                </div>
            </div>
        </div>
    </nav>