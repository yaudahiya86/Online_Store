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
            <a href="{{ route('datapesanan') }}" class="btn btn-secondary">Kembali</a>
        </div>
        <div class="card-body">
            <div class="card p-1 text-center mb-1">
                <div class="row">
                    <div class="col">Nama Pemesan : {{ $pesanan->nama_lengkap }}</div>
                    {{-- <div class="col">Metode Pembayaran : {{ $pesanan->metode_pembayaran }}</div> --}}
                    <div class="col"><button class="btn btn-primary" data-toggle="modal"
                            data-target="#tambahresi">Masukkan Resi</button></div>
                </div>
                <div class="row">
                    <div class="col">Tanggal Pesanan : {{ date('d-m-Y', strtotime($pesanan->tanggal_pembayaran)) }}</div>
                    <div class="col">Expedisi Pengiriman : {{ $pesanan->expedisi_pengiriman }} /
                        {{ $pesanan->resi_pengiriman }}</div>
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
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($barang as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->nama_barang }}</td>
                                <td>Rp. {{ number_format($item->harga_barang, 0, ',', '.') }}</td>
                                <td>{{ $item->jumlah_barang_satuan }}</td>
                                <td>Rp. {{ number_format($item->total_harga_satuan, 0, ',', '.') }}</td>
                                <td>{{ $item->kategori }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <form method="POST" action="{{route('masukkanresi',$pesanan->id_pesanan)}}">
        @csrf
        <div class="modal fade" id="tambahresi" tabindex="-1" aria-labelledby="tambahresiLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Masukkan Resi</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Masukkan Resi</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" name="resi"
                                aria-describedby="emailHelp">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
