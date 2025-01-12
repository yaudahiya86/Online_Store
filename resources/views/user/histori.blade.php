@extends('layout.user.app')
@section('title', 'Histori')
@section('linkcss')
    <link rel="stylesheet" href="{{ asset('css/user/css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user/css/histori.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user/css/footer.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.1.1/css/boxicons.min.css" rel="stylesheet">
    <link rel="website icon" type="png" href="img/gasos.jpg">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.3.5/css/swiper.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kavoon&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
@endsection
@section('content')
    <div class="background">
        <div class="container-profile">
            <a href="{{ route('profil', Auth::user()->id) }}"><button class="back"><i
                        class="fa-solid fa-backward"></i></i></i> kembali</button></a>
            <div class="user-profile">
                <div class="profile-bg">
                    <img src="{{ asset('img/profiluser/' . Auth::user()->foto) }}" alt="User Profile" class="profile-img">
                    <div class="profile-info">
                        <h2>{{ Auth::user()->nama_lengkap }}</h2>
                        <p>Selamat datang kembali, lihat pesanan dan riwayat pembelian Anda!</p>
                    </div>
                </div>
            </div>
            <div class="tabs">
                <button class="tab-link active" onclick="openTab(event, 'belumdibayar')">
                    <i class="bx bxs-wallet"></i> Belum Dibayar
                </button>
                <button class="tab-link" onclick="openTab(event, 'dikemas')">
                    <i class="bx bxs-package"></i> Dikemas
                </button>
                <button class="tab-link" onclick="openTab(event, 'dikirim')">
                    <i class="bx bxs-truck"></i> Dikirim
                </button>
                <button class="tab-link" onclick="openTab(event, 'selesai')">
                    <i class="bx bxs-check-circle"></i> Selesai
                </button>


            </div>
            <div id="belumdibayar" class="tab-content" style="display: block;">
                <h2 class="jud"><i class="bx bxs-send"></i>Pesanan Belum Dibayar</h2>
                @foreach ($data['belumdibayar'] as $item)
                    <div class="order-card">
                        {{-- <img src="https://images.tokopedia.net/img/cache/700/VqbcmM/2022/9/5/638631bd-edbb-409c-8d4d-e973d06682c8.jpg"
                            alt="Produk A" class="product-img"> --}}
                        <div class="order-details">
                            <h3>{{ $item->nama_lengkap }}</h3>
                            <p><strong>Alamat : </strong>{{ $item->alamat }}</p>
                            <p><strong>Total : </strong>Rp {{ number_format($item->total_harga_semua, 0, ',', '.') }}</p>
                            <p><strong>Waktu Pesanan :
                                </strong>{{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y H:i') }}</p>
                            <span class="status waiting"><i class="fas fa-clock"></i> Menunggu Pembayaran</span>
                            <a class="detail-btn" href="{{route('userdetailpesanan', $item->id_pesanan)}}">Lihat Detail</a>
                        </div>
                    </div>
                @endforeach
            </div>
            <div id="dikemas" class="tab-content" style="display: block;">
                <h2 class="jud"><i class="bx bxs-send"></i>Pesanan Sudah Dibayar</h2>
                @foreach ($data['sudahdibayar'] as $item)
                    <div class="order-card">
                        {{-- <img src="https://images.tokopedia.net/img/cache/700/VqbcmM/2022/9/5/638631bd-edbb-409c-8d4d-e973d06682c8.jpg"
                            alt="Produk A" class="product-img"> --}}
                        <div class="order-details">
                            <h3>{{ $item->nama_lengkap }}</h3>
                            <p><strong>Alamat : </strong>{{ $item->alamat }}</p>
                            <p><strong>Total : </strong>Rp {{ number_format($item->total_harga_semua, 0, ',', '.') }}</p>
                            <p><strong>Waktu Pesanan :
                                </strong>{{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y H:i') }}</p>
                                <span class="status waiting"><i class="fas fa-truck"></i> Menunggu Dikirim</span>
                            <a class="detail-btn" href="{{route('userdetailpesanan', $item->id_pesanan)}}">Lihat Detail</a>
                        </div>
                    </div>
                @endforeach
            </div>
            <div id="dikirim" class="tab-content" style="display: block;">
                <h2 class="jud"><i class="bx bxs-send"></i>Pesanan Dikirim</h2>
                @foreach ($data['dikirim'] as $item)
                    <div class="order-card">
                        {{-- <img src="https://images.tokopedia.net/img/cache/700/VqbcmM/2022/9/5/638631bd-edbb-409c-8d4d-e973d06682c8.jpg"
                            alt="Produk A" class="product-img"> --}}
                        <div class="order-details">
                            <h3>{{ $item->nama_lengkap }}</h3>
                            <p><strong>Alamat : </strong>{{ $item->alamat }}</p>
                            <p><strong>Total : </strong>Rp {{ number_format($item->total_harga_semua, 0, ',', '.') }}</p>
                            <p><strong>Waktu Pesanan :
                                </strong>{{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y H:i') }}</p>
                                <span class="status waiting"><i class="fas fa-truck"></i> Dikirim</span>
                            <a href="{{route('userdetailpesanan', $item->id_pesanan)}}" class="detail-btn">Lihat Detail</a>
                        </div>
                    </div>
                @endforeach
            </div>
            <div id="selesai" class="tab-content" style="display: block;">
                <h2 class="jud"><i class="bx bxs-send"></i>Pesanan Selesai</h2>
                @foreach ($data['selesai'] as $item)
                    <div class="order-card">
                        {{-- <img src="https://images.tokopedia.net/img/cache/700/VqbcmM/2022/9/5/638631bd-edbb-409c-8d4d-e973d06682c8.jpg"
                            alt="Produk A" class="product-img"> --}}
                        <div class="order-details">
                            <h3>{{ $item->nama_lengkap }}</h3>
                            <p><strong>Alamat : </strong>{{ $item->alamat }}</p>
                            <p><strong>Total : </strong>Rp {{ number_format($item->total_harga_semua, 0, ',', '.') }}</p>
                            <p><strong>Waktu Pesanan :
                                </strong>{{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y H:i') }}</p>
                                <span class="status processing"><i class="fas fa-check-circle"></i> Selesai</span>
                            <a class="detail-btn" href="{{route('userdetailpesanan', $item->id_pesanan)}}">Lihat Detail</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div id="detail-card" class="detail-card">
        <button class="close-btn" onclick="closeDetail()">&times;</button>
        <div v class="detail-content">
            <img id="detail-img" src="" alt="Detail Produk">
            <div class="detail-text">
                <h3 id="detail-title">Judul Produk</h3>
                <p id="detail-description">Deskripsi lengkap produk.</p>
                <p><strong>Alamat Pengiriman:</strong> Pangkru</p>
                <p><strong>Jumlah:</strong> 1</p>
                <p><strong>Total:</strong> Rp.1000.000</p>
                <p><strong>Estimasi Pengiriman:</strong> 10-20-202020.</p>
            </div>
        </div>
    </div><br><br><br><br><br><br><br>
@endsection
@section('linkjs')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                showConfirmButton: true,
            });
        </script>
    @endif
    <script>
        function openTab(evt, tabName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tab-content");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tab-link");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(tabName).style.display = "block";
            evt.currentTarget.className += " active";
        }

        function openDetail(detailId) {
            var detailData = {
                'detail-A': {
                    title: 'Produk A',
                    description: 'Deskripsi lengkap produk A.',
                    imgSrc: 'https://via.placeholder.com/300',
                    address: 'Jl. Contoh 123, Kota.',
                    quantity: 2,
                    total: 'Rp 100.000',
                    shipping: '3 Hari Kerja'
                },
                'detail-B': {
                    title: 'Produk B',
                    description: 'Deskripsi lengkap produk B.',
                    imgSrc: 'https://via.placeholder.com/300',
                    address: 'Jl. Contoh 456, Kota.',
                    quantity: 1,
                    total: 'Rp 50.000',
                    shipping: '2 Hari Kerja'
                },
                'detail-C': {
                    title: 'Produk C',
                    description: 'Deskripsi lengkap produk C.',
                    imgSrc: 'https://via.placeholder.com/300',
                    address: 'Jl. Contoh 789, Kota.',
                    quantity: 1,
                    total: 'Rp 70.000',
                    shipping: '5 Hari Kerja'
                },
                'detail-D': {
                    title: 'Produk D',
                    description: 'Deskripsi lengkap produk D.',
                    imgSrc: 'https://via.placeholder.com/300',
                    address: 'Jl. Contoh 101, Kota.',
                    quantity: 3,
                    total: 'Rp 150.000',
                    shipping: '7 Hari Kerja'
                }
            };

            var detail = detailData[detailId];
            if (detail) {
                document.getElementById('detail-card').style.display = 'flex';
                document.getElementById('detail-img').src = detail.imgSrc;
                document.getElementById('detail-title').innerText = detail.title;
                document.getElementById('detail-description').innerText = detail.description;
                document.getElementById('detail-address').innerText = detail.address;
                document.getElementById('detail-quantity').innerText = detail.quantity;
                document.getElementById('detail-total').innerText = detail.total;
                document.getElementById('detail-shipping').innerText = detail.shipping;
            }
        }

        function closeDetail() {
            document.getElementById('detail-card').style.display = 'none';
        }
    </script>
    <script src="{{ asset('css/user/js/home.js') }}"></script>
@endsection
