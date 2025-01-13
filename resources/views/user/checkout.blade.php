@extends('layout.user.app')
@section('title', 'CheckOut')
@section('linkcss')
    <link rel="stylesheet" href="{{ asset('css/user/css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user/css/checkout.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user/css/footer.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.1.1/css/boxicons.min.css" rel="stylesheet">
    <style>
        .top-bar.scrolled {
            background-color: #ffe8df;
        }

        .select {
            width: 100%;
            height: 42px;
            line-height: 42px;
            display: block;
            padding: 0;
            border: 1px solid #eee;
            text-align: center;
            font-size: 16px;
            box-sizing: border-box;
            border-radius: 10px;
        }

        .kembali {
            color: black;
        }
    </style>
@endsection
@section('content')
    <div class="containerck">
        <div class="rowck">
            <div class="col-left">
                <div class="back-button">
                    <a href="{{ route('keranjang') }}" class="kembali"><i class="bx bx-arrow-back"></i>
                        <span>Kembali Keranjang</span>
                    </a>
                </div>
                <h1>Check Out</h1>
                <div class="line"></div>
                <h2>Kamu punya {{ count($barangData) }} item di check out mu</h2>


                <!-- Loop untuk menampilkan barang -->
                @foreach ($barangData as $barang)
                    <div class="cardck">
                        <img src="{{ asset('img/barang_img/' . $barang['foto_barang']) }}" alt="Product Image">
                        <div class="card-content">
                            <h2>{{ $barang['nama_barang'] }}</h2>
                            <p>{{ $barang['nama_kategori'] }}</p>
                        </div>
                        <div class="quantity-container">
                            <div class="quantity">
                                <input type="number" min="1" step="1" value="{{ $barang['jumlah'] }}"
                                    readonly>
                            </div>
                            <div class="quantity-info">
                                <p class="harga">Rp
                                    {{ number_format($barang['jumlah'] * $barang['harga_barang'], 0, ',', '.') }}</p>
                            </div>
                            <!-- Hidden inputs to pass id_barang, jumlah_barang, and total_barang_satuan -->
                            {{-- <input type="hidden" name="barang[{{ $loop->index }}][id_barang]"
                                value="{{ $barang['id_barang'] }}">
                            <input type="hidden" name="barang[{{ $loop->index }}][jumlah_barang]"
                                value="{{ $barang['jumlah'] }}">
                            <input type="hidden" name="barang[{{ $loop->index }}][total_barang_satuan]"
                                value="{{ $barang['jumlah'] * $barang['harga_barang'] }}"> --}}
                            <a href="{{ route('checkout.hapus', $barang['id_keranjang']) }}" class="trash-icon">
                                <i class="bx bxs-trash"></i>
                            </a>
                        </div>
                    </div><br>
                @endforeach
            </div>

            <div class="col-right">
                <h1 class="format">Format</h1>
                <hr>
                <div class="cardck">
                    <form action="{{ route('bayar') }}" method="POST">
                        @csrf
                        @foreach ($barangData as $barang)
                            <input type="hidden" name="barang[{{ $loop->index }}][id_barang]"
                                value="{{ $barang['id_barang'] }}">
                            <input type="hidden" name="barang[{{ $loop->index }}][jumlah_barang]"
                                value="{{ $barang['jumlah'] }}">
                            <input type="hidden" name="barang[{{ $loop->index }}][id_keranjang]"
                                value="{{ $barang['id_keranjang'] }}">
                            <input type="hidden" name="barang[{{ $loop->index }}][total_barang_satuan]"
                                value="{{ $barang['jumlah'] * $barang['harga_barang'] }}">
                        @endforeach
                        <div class="form-group">
                            <label for="nama-lengkap">Nama Lengkap</label>
                            <input type="text" id="nama-lengkap" name="nama_lengkap" placeholder="Masukkan Nama Lengkap">
                        </div>
                        <div class="form-group">
                            <label for="no-telepon">No. Telepon</label>
                            <input type="text" id="no-telepon" name="telephone" placeholder="Masukkan No. Telepon">
                        </div>
                        <div class="form-group">
                            <label for="alamat-lengkap">Alamat Lengkap</label>
                            <textarea id="alamat-lengkap" name="alamat_lengkap" placeholder="Alamat Lengkap" rows="4"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="kode_pos">Kode Pos</label>
                            <input type="number" id="kode_pos" name="kode_pos" placeholder="Masukkan Kode Pos">
                        </div>
                        <div class="form-group">
                            <label for="pengiriram">Pengiriman</label>
                            <select id="pengiriram" name="pengiriman" class="select">
                                <option value="" disabled selected>Pilih Pengiriman</option>
                                @foreach ($expedisi as $item)
                                <option value="{{$item->id_expedisi_pengiriman}}">{{$item->expedisi_pengiriman}}</option>
                                @endforeach
                            </select>
                        </div>
                </div>
                <div class="card-pembayaran">
                    <table class="info-table">
                        <tbody>
                            <tr>
                                <td>Total Harga</td>
                                <td>:</td>
                                <td>Rp {{ number_format($totalHarga, 0, ',', '.') }}</td>
                                <input type="hidden" name="total_harga_semua" value="{{$totalHarga}}">
                            </tr>
                        </tbody>
                    </table>
                    <a class="beli">
                        <button type="submit">
                            Pesan & Bayar
                            <i class="fa fa-shopping-cart"></i>
                        </button>
                    </a>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('linkjs')
    <script>
        const toggleList = document.querySelector('.toggle-list');
        const list = document.querySelector('.list');
        const icon = document.querySelector('.toggle-list i');

        // Nambah event untuk klik
        toggleList.addEventListener('click', () => {
            // Toggle visibilitas list
            list.style.display = (list.style.display === 'none' || list.style.display === '') ? 'block' : 'none';

            // Mengganti ikon ke atas atau bawah
            icon.classList.toggle('bx-chevron-up');
            icon.classList.toggle('bx-chevron-down');
        });
    </script>
    <script>
        // Mendapatkan elemen yang akan di-klik
        const detailsToggle = document.querySelector('.details-toggle');
        const lis = document.querySelector('.lis');
        const i = document.querySelector('.details-toggle i');

        // Menambahkan event listener untuk klik
        detailsToggle.addEventListener('click', () => {
            // Toggle visibilitas list
            lis.style.display = (lis.style.display === 'none' || lis.style.display === '') ? 'block' : 'none';

            // Mengganti ikon ke atas atau bawah
            i.classList.toggle('bx-chevron-up');
            i.classList.toggle('bx-chevron-down');
        });
    </script>
    <script src="{{ asset('css/user/js/home.js') }}"></script>
@endsection
