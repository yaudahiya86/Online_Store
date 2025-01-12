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
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.1/css/dataTables.dataTables.css">
@endsection
@section('content')
    <div class="background">
        <div class="container-profile">
            @foreach ($data as $item)
                @if ($item->status_pembayaran == 'Sudah Dibayar')
                    <button>
                        Pesanan Selesai
                    </button>
                @endif
            @endforeach
            <table id="example">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Barang</th>
                        <th>Jumlah Beli</th>
                        <th>Total Harga</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->nama_barang }}</td>
                            <td>{{ $item->jumlah_barang_satuan }}</td>
                            <td>{{ $item->total_harga_satuan }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
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
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.2.1/js/dataTables.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        new DataTable('#example');
    </script>
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
    <script src="{{ asset('css/user/js/home.js') }}"></script>
@endsection
