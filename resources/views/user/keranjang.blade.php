@extends('layout.user.app')
@section('title', 'Keranjang')
@section('content')
    <div class="containerkj">
        <a href="{{route('beranda')}}" class="back-button"><i class="bx bx-left-arrow-alt"></i> Kembali belanja</a>
        <div class="cart-section">
            <div class="cart-items">
                <h1>Keranjang Belanja</h1>
                @foreach ($data['keranjang'] as $item)
                <div class="cart-item">
                    <input type="checkbox" checked>
                    <img src="{{'img/barang_img/'.$item->foto_barang}}" alt="Bunga Melati">
                    <div class="item-details">
                        <div class="item-text">
                            <h2>{{Str::limit($item->nama_barang, 12)}}</h2>
                            <p>{{$item->kategori}}</p>
                        </div>
                        <div class="isiconten">
                            <div class="quantity-container">
                                <div class="quantity">
                                    <input type="number" min="1" max="{{$item->stok_barang}}" step="1" value="{{$item->total_barang_satuan}}">
                                    <div class="quantity-nav">
                                        <div class="quantity-button quantity-up">+</div>
                                        <div class="quantity-button quantity-down">−</div>
                                    </div>
                                </div>
                            </div>
                            <div class="item-pricing">
                                <span>Rp.500.000</span>
                                <small>Rp {{ number_format($item->harga_barang, 0, ',', '.') }} / per item</small>
                            </div>
                            <button class="delete"><i class="bx bxs-trash"></i></button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="cart-summary">
                <h3>Masukkan Kupon</h3>
                <div class="cart-promo">
                    <input type="text" placeholder="Promo Kode">
                    <button>Masukkan</button>
                </div>
                <div class="summary">
                    <table class="info-table">
                        <tbody>
                            <tr>
                                <td>Total Harga</td>
                                <td>:</td>
                                <td>Rp.100.000</td>
                            </tr>
                            <tr>
                                <td>Total Pengiriman</td>
                                <td>:</td>
                                <td>Rp.100.000</td>
                            </tr>
                            <tr class="totalnya2">
                                <td>Total Harga</td>
                                <td>:</td>
                                <td>Rp.100.000</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <a href="checkout.html"><button class="checkout">CHECK OUT</button></a>
            </div>

        </div>
        <h1>Rekomendasi Barang</h1>
        <div class="recommendation-slider">
            <button class="slide-btn prev"><i class="bx bx-left-arrow-alt"></i></button>
            <div class="recommendation">
                <div class="product-card">
                    <img src="https://i.pinimg.com/736x/2f/09/99/2f099922262c21d845d85b0a92ec182a.jpg" alt="Bunga Melati">
                    <div class="isi">
                        <h2>BUNGA MELATI</h2>
                        <p>Pernikahan</p>
                        <p>Rp.100,000</p>
                        <button>Tambahkan Keranjang</button>
                    </div>
                </div>
                <div class="product-card">
                    <img src="https://i.pinimg.com/736x/2f/09/99/2f099922262c21d845d85b0a92ec182a.jpg" alt="Bunga Melati">
                    <div class="isi">
                        <h2>BUNGA MELATI</h2>
                        <p>Pernikahan</p>
                        <p>Rp.100,000</p>
                        <button>Tambahkan Keranjang</button>
                    </div>
                </div>
                <div class="product-card">
                    <img src="https://i.pinimg.com/736x/2f/09/99/2f099922262c21d845d85b0a92ec182a.jpg" alt="Bunga Melati">
                    <div class="isi">
                        <h2>BUNGA MELATI</h2>
                        <p>Pernikahan</p>
                        <p>Rp.100,000</p>
                        <button>Tambahkan Keranjang</button>
                    </div>
                </div>
                <div class="product-card">
                    <img src="https://i.pinimg.com/736x/2f/09/99/2f099922262c21d845d85b0a92ec182a.jpg" alt="Bunga Melati">
                    <div class="isi">
                        <h2>BUNGA MELATI</h2>
                        <p>Pernikahan</p>
                        <p>Rp.100,000</p>
                        <button>Tambahkan Keranjang</button>
                    </div>
                </div>
                <div class="product-card">
                    <img src="https://i.pinimg.com/736x/2f/09/99/2f099922262c21d845d85b0a92ec182a.jpg" alt="Bunga Melati">
                    <div class="isi">
                        <h2>BUNGA MELATI</h2>
                        <p>Pernikahan</p>
                        <p>Rp.100,000</p>
                        <button>Tambahkan Keranjang</button>
                    </div>
                </div>
            </div>
            <button class="slide-btn next"><i class="bx bx-right-arrow-alt"></i></button>
        </div>
    </div>
@endsection
@section('linkcss')
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Kavoon&family=Righteous&display=swap" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:ital,wght@0,100..800;1,100..800&family=Kavoon&family=Righteous&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/freeps2/a7rarpress@main/swiper-bundle.min.css">
    <link rel="stylesheet" href="{{ asset('css/user/css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user/css/keranjang.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user/css/footer.css') }}">
    <style>
        .top-bar.scrolled{
            background-color: #ffe8df;
        }
    </style>
@endsection
@section('linkjs')
    <script src="//cdn.jsdelivr.net/gh/freeps2/a7rarpress@main/swiper-bundle.min.js"></script>
    <script src="//cdn.jsdelivr.net/gh/freeps2/a7rarpress@main/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('css/user/js/home.js') }}"></script>
    <script>
        const recommendation = document.querySelector('.recommendation');
        const nextBtn = document.querySelector('.next');
        const prevBtn = document.querySelector('.prev');

        let currentPosition = 0;
        let isDragging = false;
        let startX = 0;
        let scrollLeft = 0;

        // Event untuk tombol Next
        nextBtn.addEventListener('click', () => {
            const maxScroll = recommendation.scrollWidth - recommendation.clientWidth;
            if (currentPosition < maxScroll) {
                currentPosition += 290; // Geser ke kanan 1 card
                recommendation.style.transform = `translateX(-${currentPosition}px)`;
                recommendation.style.transition = 'transform 0.3s ease';
            }
        });

        // Event untuk tombol Prev
        prevBtn.addEventListener('click', () => {
            if (currentPosition > 0) {
                currentPosition -= 290; // Geser ke kiri 1 card
                recommendation.style.transform = `translateX(-${currentPosition}px)`;
                recommendation.style.transition = 'transform 0.3s ease';
            }
        });

        // Event saat mouse ditekan
        recommendation.addEventListener('mousedown', (e) => {
            isDragging = true;
            startX = e.pageX - recommendation.offsetLeft;
            scrollLeft = recommendation.scrollLeft;
            recommendation.style.cursor = 'grabbing';
        });

        // Event saat mouse dilepaskan
        recommendation.addEventListener('mouseup', () => {
            isDragging = false;
            recommendation.style.cursor = 'grab';
        });

        // Event saat mouse keluar area slider
        recommendation.addEventListener('mouseleave', () => {
            isDragging = false;
            recommendation.style.cursor = 'grab';
        });

        // Event saat mouse digerakkan
        recommendation.addEventListener('mousemove', (e) => {
            if (!isDragging) return;
            e.preventDefault();
            const x = e.pageX - recommendation.offsetLeft;
            const walk = x - startX; // Jarak gerakan mouse
            recommendation.scrollLeft = scrollLeft - walk; // Geser konten slider
        });

        // Dukungan untuk perangkat sentuh (mobile)
        recommendation.addEventListener('touchstart', (e) => {
            isDragging = true;
            startX = e.touches[0].pageX - recommendation.offsetLeft;
            scrollLeft = recommendation.scrollLeft;
        });

        recommendation.addEventListener('touchend', () => {
            isDragging = false;
        });

        recommendation.addEventListener('touchmove', (e) => {
            if (!isDragging) return;
            const x = e.touches[0].pageX - recommendation.offsetLeft;
            const walk = x - startX;
            recommendation.scrollLeft = scrollLeft - walk;
        });
    </script>
    <script>
        document.querySelectorAll('.quantity-button').forEach(button => {
            button.addEventListener('click', function() {
                const input = this.closest('.quantity').querySelector('input[type="number"]');
                const currentValue = parseInt(input.value, 10);
                const isIncrement = this.classList.contains('quantity-up');
                const newValue = isIncrement ? currentValue + 1 : currentValue - 1;

                // Set nilai baru, pastikan tetap dalam batas min dan max
                if (newValue >= input.min && newValue <= input.max) {
                    input.value = newValue;
                }
            });
        });
    </script>
    
@endsection
