@extends('layout.user.app')
@section('title', 'Detail Pesanan')
@section('linkcss')
    <link rel="stylesheet" href="{{ asset('css/user/css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user/css/detailpesanan.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user/css/footer.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kavoon&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://unpkg.com/gridjs/dist/theme/mermaid.min.css" rel="stylesheet" />
    <style>
        .pesanan {
            background-color: rgb(42, 140, 231);
            color: white;
            border: 1px solid black;
            padding: 10px 5px;
            border-radius: 15px;
            cursor: pointer;
        }

        .pesanan:hover {
            background-color: rgb(19, 100, 175);
            color: white;
            border: 1px solid black;
            padding: 10px 5px;
            border-radius: 15px;
            cursor: pointer;
        }
        .kembali{
            color: rgb(71, 71, 251);
            text-decoration: underline;
        }
    </style>
@endsection
@section('content')
    <div class="profile-container">
        @php
            $buttonShown = false;
        @endphp

        <a href="{{route('histori')}}" class="kembali">Kembali</a><br>
        @foreach ($data as $item)
            @if (!$buttonShown)
                @if ($item->status_pesanan == 'Dikirim')
                    <a href="{{ route('pesananditerima', $item->id_pesanan) }}">
                        <button class="pesanan">Pesanan Diterima</button>
                    </a>
                    @php
                        $buttonShown = true;
                    @endphp
                @elseif ($item->status_pembayaran == 'Belum Dibayar')
                    <button class="pesanan" id="pay-button">Bayar Pesanan</button>
                    @php
                        $buttonShown = true;
                    @endphp
                @endif
            @endif
        @endforeach

        <div id="example"></div>
    </div>
@endsection
@section('linkjs')
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
    <script src="https://unpkg.com/gridjs/dist/gridjs.umd.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('css/user/js/home.js') }}"></script>
    <script src="{{ asset('css/user/js/profil.js') }}"></script>
    <script>
        const data = [
            @foreach ($data as $item)
                [{{ $loop->iteration }}, "{{ $item->nama_barang }}", {{ $item->jumlah_barang_satuan }},
                    "{{ $item->total_harga_satuan }}"
                ],
            @endforeach
        ];

        // Inisialisasi Grid.js
        new gridjs.Grid({
            columns: ["No", "Nama Barang", "Jumlah Barang", "Total Harga"],
            data: data,
            search: true, // Menambahkan fitur pencarian
            pagination: {
                limit: 5, // Jumlah data per halaman
            },
            sort: true, // Fitur sorting
            resizable: true, // Kolom dapat diubah ukuran
            style: {
                table: {
                    border: '1px solid #ccc',
                },
                th: {
                    'text-align': 'center',
                    background: '#f4f4f4',
                },
            },
        }).render(document.getElementById("example"));
    </script>
    <script>
        document.getElementById('pay-button').onclick = function() {
            @foreach ($data as $item)
                snap.pay('{{ $item->snap_token }}', {
                    // Optional
                    onSuccess: function(result) {
                        window.location.href =
                            '{{ route('pembayaranberhasil', ['id_pesanan' => $item->id_pesanan]) }}';
                    },
                    // Optional
                    onPending: function(result) {
                        /* You may add your own js here, this is just example */
                        document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                    },
                    // Optional
                    onError: function(result) {
                        /* You may add your own js here, this is just example */
                        document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                    }
                });
            @endforeach
        };
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
