@extends('layout.admin.app')
@section('title', 'Data Pesanan')
@section('content')
    <style>
        /* Menetapkan lebar kolom yang ditentukan di tabel */
        #dataTable th,
        #dataTable td {
            white-space: nowrap;
            /* Mencegah teks membungkus ke baris baru */
        }

        #dataTable th:nth-child(1),
        #dataTable td:nth-child(1) {
            width: 50px !important;
            /* Nama Barang */
        }

        #dataTable th:nth-child(3),
        #dataTable td:nth-child(3) {
            width: 30px !important;
            /* Stok */
        }

        /* Responsif pada layar kecil */
        @media (max-width: 767px) {

            /* Buat tabel scrollable */
            .table-responsive {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }

            #dataTable th,
            #dataTable td {
                width: auto !important;
                /* Biarkan lebar otomatis pada layar kecil */
            }
        }
    </style>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary h4">Data Pesanan</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Pemesan</th>
                            <th>Tangga Pesanan</th>
                            <th>Metode Pembayaran</th>
                            <th>Expedisi Pengiriman</th>
                            <th>Total Harga</th>
                            <th>Status Pembayaran</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Nama Pemesan</th>
                            <th>Tangga Pesanan</th>
                            <th>Metode Pembayaran</th>
                            <th>Expedisi Pengiriman</th>
                            <th>Total Harga</th>
                            <th>Status Pembayaran</th>
                            <th>Aksi</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$item->nama_lengkap}}</td>
                                <td>{{$item->created_at}}</td>
                                <td>{{$item->metode_pembayaran}}</td>
                                <td>{{$item->expedisi_pengiriman}}</td>
                                <td>{{$item->total_harga_semua}}</td>
                                <td>{{$item->status_pembayaran}}</td>
                                <td>
                                    <a href="{{ route('detailpesanan', $item->id_pesanan) }}" class="btn btn-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
