@extends('layout.admin.app')
@section('title', 'Detail Pesanan')
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
        <h6 class="m-0 font-weight-bold text-primary h4">Detail Pesanan</h6>
        <a href="{{route('datapesanan')}}" class="btn btn-secondary">Kembali</a>
    </div>
    <div class="card-body">
            <div class="card p-1 text-center mb-1">
                <div class="row">
                    <div class="col">Nama Pemesan : Ergi</div>
                    <div class="col">Metode Pembayaran : OVO</div>
                </div>
                <div class="row">
                    <div class="col">Tanggal Pesanan : 12-12-2024</div>
                    <div class="col">Expedisi Pengiriman : JNT</div>
                </div>
            </div>
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Barang</th>
                        <th>Harga</th>
                        <th>Jumlah Barang</th>
                        <th>Total Harga</th>
                        <th>Kategori</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                    <th>No</th>
                        <th>Nama Barang</th>
                        <th>Harga</th>
                        <th>Jumlah Barang</th>
                        <th>Total Harga</th>
                        <th>Kategori</th>
                        <th>Aksi</th>
                    </tr>
                </tfoot>
                <tbody>
                    <tr>
                        <td>1.</td>
                        <td>Bucket</td>
                        <td>Rp. 150.000</td>
                        <td>2</td>
                        <td>Rp. 300.000</td>
                        <td>Pernikahan</td>
                        <td>
                            <button class="btn btn-primary">
                                <i class="fas fa-eye"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
