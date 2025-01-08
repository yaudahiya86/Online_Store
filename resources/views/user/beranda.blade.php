@extends('layout.user.app')
@section('title', 'Beranda')
@section('linkcss')
    <link rel="stylesheet" href="{{ asset('css/user/css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user/css/kategori.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user/css/footer.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.1.1/css/boxicons.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v6.0.0-beta2/css/all.css" integrity="sha384-qQPTTSTCCCTi7CkrN4DTPaZGjMllJezVpxePe1EtB+nvNSrN3b2sWFy7ueE9I2Gz" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.3.5/css/swiper.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Kavoon&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
@endsection
@section('content')
    <div class="fullscreen-video-container">
        <video autoplay loop muted>
            <source src="{{ asset('css/user/video/vecteezy_flower-at-sunset_17691736.mp4') }}" type="video/mp4">
        </video>
        <div class="fullscreen-video-content">
            <div class="text-container">
                <h1>FLOWER IN
                    <br>THE HEART
                </h1>
                <p>Seperti bunga yang mekar di musim semi, biarkan dirimu berkembang dengan indah</p>
            </div>
            <div class="swiper-container">
                <div class="swiper mySwiper">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide"><img
                                src="https://i.pinimg.com/564x/7c/df/ee/7cdfeee6ca71a41b85735ddec81da6c7.jpg" alt="">
                        </div>
                        <div class="swiper-slide"><img
                                src="https://i.pinimg.com/564x/7c/df/ee/7cdfeee6ca71a41b85735ddec81da6c7.jpg"
                                alt=""></div>
                        <div class="swiper-slide"><img
                                src="https://i.pinimg.com/564x/7c/df/ee/7cdfeee6ca71a41b85735ddec81da6c7.jpg"
                                alt=""></div>

                    </div>
                    <div class="autoplay-progress">
                        <svg viewBox="0 0 48 48">
                            <circle cx="24" cy="24" r="20"></circle>
                        </svg>
                        <span></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="produk" id="produk">
        <div class="header-shop">
            <h1 class="title-shop">PRODUK</h1>
            <div class="menu-produk">
                <div class="title" onclick="f()">KATEGORI PRODUK <span class="fa fa-bars"></span>
                    <div class="arrow"></div>
                </div>
                <div class="dropdown">
                    <p data-content="">Utama</p>
                    <p data-content="pernikahan">Pernikahan</p>
                    <p data-content2="perpisahan">Perpisahan</p>
                    <p data-content="kematian">Kematian</p>
                </div>
            </div>
        </div>
        <main class="main bd-grid" id="productContainer">
            @foreach ($data['barang'] as $item)
                <article class="card">
                    <div class="card__img">
                        <img src="{{ asset('img/barang_img/' . $item->foto_barang) }}" alt="">
                    </div>
                    <div class="card__name">
                        <a href="detailbarang.html">
                            <p>DETAIL BARANG</p>
                        </a>
                    </div>
                    <a href="detailbarang.html" class="detail-icon">
                        <i class="fa-solid fa-ellipsis"></i>
                    </a>
                    <div class="card__precis">
                        <div>
                            <span class="card__preci card__preci--before">{{ $item->nama_barang }}</span>
                            <span class="card__preci card__preci--now">Rp {{ number_format($item->harga_barang, 0, ',', '.') }}</span>
                        </div>
                        <a href="{{ route('tambahkeranjang', $item->id_barang) }}" class="card__icon">
                            <ion-icon name="cart-outline"></ion-icon>
                        </a>
                    </div>
                </article> @endforeach
        </main>
    </div>
    <section class="aboutus"
        id="tentang">
    <div class="blog-card">
        <div class="meta">
            <div class="photo"
                style="background-image: url(https://i.pinimg.com/736x/c6/10/7d/c6107db2891ab660cc30bf11aaa70515.jpg)">
            </div>
            <ul class="details">
                <li class="author">
                    <a href="#">Berdiri sejak 2024, misi kami adalah mengubah setiap emosi menjadi rangkaian
                        elegan yang memberikan kebahagiaan untuk semua kesempatan.</a>
                </li>
            </ul>
        </div>
        <div class="description">
            <h1>TENTANG KAMI</h1>
            <h2>Selamat datang di FLOWER</h2>
            <p>Mitra terpercaya Anda dalam menciptakan bucket bunga indah yang dirangkai dengan penuh cinta untuk setiap
                momen spesial dalam hidup Anda.</p>
        </div>
    </div>
    <div class="blog-card alt">
        <div class="meta">
            <div class="photo"
                style="background-image: url(https://i.pinimg.com/736x/2f/09/99/2f099922262c21d845d85b0a92ec182a.jpg)">
            </div>
            <ul class="details">
                <li class="author">
                    <a href="#">Dari buket romantis hingga hadiah penuh keceriaan, kami selalu berusaha untuk
                        memberikan yang terbaik.</a>
                </li>
            </ul>
        </div>
        <div class="description">
            <h1>Siapa Kami?</h1>
            <h2>Di FLOWER, kami percaya bahwa bunga adalah bahasa universal untuk menyampaikan cinta, perhatian, dan
                kebahagiaan.</h2>
            <p>Setiap bucket bunga yang kami buat bukan sekadar rangkaian biasa, tetapi sebuah karya seni. Tim florist
                kami yang berpengalaman memilih bunga segar terbaik dan merancang setiap rangkaian dengan detail untuk
                menyampaikan cerita Anda.</p>
        </div>
    </div>
    </section>

    <section class="BgImage"></section>

    <section class="contactus" id="kontak">
        <div class="section-header">
            <div class="container">
                <h2>KONTAK KAMI</h2>
                <p>Halo!
                    Kami sangat senang mendengar dari Anda. Jika Anda memiliki pertanyaan, masukan, atau kritik yang dapat
                    membantu kami menjadi lebih baik, jangan ragu untuk menghubungi kami melalui formulir di bawah ini.Kami
                    berkomitmen untuk merespons pesan Anda secepat mungkin. Terima kasih atas perhatian dan dukungan Anda!
                </p>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="card3">
                    <iframe width="550" height="350"
                        src="https://www.youtube.com/embed/OjeYWxhJv5c?si=nosy1_vb_pd4RKSw" class="vid" frameborder="0"
                        allowfullscreen></iframe>
                    <hr>
                </div>
                <div class="contact-form">
                    <form action="" id="contact-form">
                        <h2>KIRIM PESAN</h2>
                        <div class="input-box">
                            <input type="text" required="true" name="">
                            <span>Nama Legkap</span>
                        </div>

                        <div class="input-box">
                            <input type="email" required="true" name="">
                            <span>Email</span>
                        </div>

                        <div class="input-box">
                            <textarea required="true" name=""></textarea>
                            <span>Ketik Pesanmu...</span>
                        </div>

                        <div class="input-box">
                            <input type="submit" value="KIRIM" name="">
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </section>

@endsection
@section('linkjs')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.3.5/js/swiper.min.js"></script>
    <script src="https://unpkg.com/ionicons@5.0.0/dist/ionicons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '{{ session('success') }}',
                background: '#f0f9ff', // Biru muda pastel
                iconColor: '#38bdf8', // Biru cerah untuk ikon
                color: '#1e3a8a', // Teks biru tua
                backdrop: 'rgba(0, 0, 0, 0.2)', // Latar belakang gelap dengan transparansi 20%
                showConfirmButton: false,
                timer: 1500
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: '{{ session('error') }}',
                showConfirmButton: false,
                timer: 2000
            });
        </script>
    @endif
    <script>
        const progressCircle = document.querySelector(".autoplay-progress svg");
        const progressContent = document.querySelector(".autoplay-progress span");
        var swiper = new Swiper(".mySwiper", {
            spaceBetween: 30,
            centeredSlides: true,
            autoplay: {
                delay: 2500,
                disableOnInteraction: false
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev"
            },
            on: {
                autoplayTimeLeft(s, time, progress) {
                    progressCircle.style.setProperty("--progress", 1 - progress);
                    progressContent.textContent = `${Math.ceil(time / 1000)}s`;
                }
            }
        });
    </script>
    <script>
        window.addEventListener('scroll', () => {
            const sections = document.querySelectorAll(
                '.produk, .blog-card, .alt, .card3, .section-header h2, .section-header p, .flip');

            sections.forEach((section) => {
                const sectionTop = section.getBoundingClientRect().top;
                const sectionBottom = section.getBoundingClientRect().bottom;

                if (sectionTop < window.innerHeight && sectionBottom >= 0) {
                    section.classList.add('in-view');
                } else {
                    section.classList.remove('in-view');
                }
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const produkButton = document.querySelector(".active");
            const tentangkamiButton = document.querySelector(".active2");
            const kontakkamiButton = document.querySelector(".active3");

            produkButton.addEventListener("click", function(event) {
                event.preventDefault();

                const produkSection = document.getElementById("produk");
                produkSection.scrollIntoView({
                    behavior: 'smooth'
                });
            });
            tentangkamiButton.addEventListener("click", function(event) {
                event.preventDefault();

                const tentangkamiSection = document.getElementById("tentang");
                tentangkamiSection.scrollIntoView({
                    behavior: 'smooth'
                });
            });
            kontakkamiButton.addEventListener("click", function(event) {
                event.preventDefault();

                const kontakkamiSection = document.getElementById("kontak");
                kontakkamiSection.scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>
    <script src="{{ asset('css/user/js/home.js') }}"></script>
@endsection
