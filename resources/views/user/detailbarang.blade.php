@extends('layout.user.app')
@section('title', 'Beranda')
@section('linkcss')
    <link rel="stylesheet" href="{{ asset('css/user/css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user/css/detailbarang.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user/css/footer.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kavoon&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .product-detail-container{
            width: 100%;
        }
    </style>
@endsection
@section('content')
<div class="product-detail-container">
    <div class="product-image">
        {{-- <span class="discount-badge">Diskon 20%</span> --}}
        <img src="{{asset('img/barang_img/'. $data['barang']->foto_barang)}}" alt="Product Image">
    </div>
    <div class="product-info">
        <h1 class="product-title">{{$data['barang']->nama_barang}}</h1>
        <p class="product-description">
            {{$data['barang']->deskripsi_barang}}
        </p>
        <p class="product-price">Rp {{ number_format($data['barang']->harga_barang, 0, ',', '.') }}</p>
        {{-- <p class="product-availability">In Stock</p> --}}
        <form class="purchase-options" action="{{route('detailbarangtambahkeranjang')}}" method="POST">
            @csrf
            <label for="quantity">Jumlah:</label>
            <input type="number" id="quantity" name="total_barang_satuan" min="1" max="{{$data['barang']->stok_barang}}" value="1">
            <input type="hidden" name="id_barang" value="{{$data['barang']->id_barang}}">
            <button type="submit" class="add-to-cart">Tambah Keranjang</button>
        </form>
        <div class="social-share">
            <p>Bagikan product:</p>
            <a href="#"><i class='bx bxl-whatsapp'></i></a>
            <a href="#"><i class='bx bxl-instagram'></i></a>
            <a href="#"><i class='bx bxl-facebook-circle'></i></a>
        </div>
    </div>
</div>
{{-- <div class="product-specs">
    <h2>Product Specifications</h2>
    <div class="specs-grid">
        <div class="spec-item">
            <i class='bx bx-tag spec-icon'></i>
            <p><strong>Brand:</strong> Flower</p>
        </div>
        <div class="spec-item">
            <i class='bx bx-cube spec-icon'></i>
            <p><strong>Material:</strong> Alami</p>
        </div>
        <div class="spec-item">
            <i class='bx bxs-palette spec-icon'></i>
            <p><strong>Warna:</strong> Pink</p>
        </div>
        <div class="spec-item">
            <i class='bx bx-shield spec-icon'></i>
            <p><strong>Jaminan:</strong> 3 Hari</p>
        </div>
    </div>
</div> --}}
{{-- <div class="customer-reviews">
    <h2>Customer Reviews</h2>
    <div class="review">
        <div class="reviewer-info">
            <img src="img/image.png" alt="Reviewer" class="reviewer-avatar">
            <div>
                <strong class="reviewer-name">Puseng</strong>
                <div class="review-rating">
                    <i class='bx bxs-star'></i>
                    <i class='bx bxs-star'></i>
                    <i class='bx bxs-star'></i>
                    <i class='bx bxs-star'></i>
                    <i class='bx bx-star'></i>
                </div>
            </div>
        </div>
        <p class="review-text">
           Lorem ipsum dolor sit amet consectetur adipisicing elit. Sunt facere, doloribus magni illum aliquid aliquam est nesciunt perferendis velit eaque nemo. 
        </p>
    </div>
    <div class="review">
        <div class="reviewer-info">
            <img src="img/image.png" alt="Reviewer" class="reviewer-avatar">
            <div>
                <strong class="reviewer-name">pulis</strong>
                <div class="review-rating">
                    <i class='bx bxs-star'></i>
                    <i class='bx bxs-star'></i>
                    <i class='bx bxs-star'></i>
                    <i class='bx bxs-star'></i>
                    <i class='bx bx-star'></i>
                </div>
            </div>
        </div>
        <p class="review-text">
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Impedit architecto ullam at ut molestiae? Impedit inventore, temporibus ratione cumque iste nihil soluta eligendi atque, natus numquam veniam, nesciunt rem doloremque.
        </p>
    </div>
</div><br><br> --}}
@endsection
@section('linkjs')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('css/user/js/home.js') }}"></script>
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
@endsection
