@extends('layout.admin.app')
@section('title', 'Data Barang')
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary h4">Data Pesanan</h6>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th width="400px">Nama Pemesan</th>
                            <th width="30px">Nama Barang</th>
                            <th width="110px">Jumlah</th>
                            <th>Total Harga</th>
                            <th width="60px">Status</th>
                            <th width="120px">Aksi</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Nama Barang</th>
                            <th>Stok</th>
                            <th>Harga</th>
                            <th>Kategori</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <tr>
                            <td>1.</td>
                            <td>Bucket Bunga Mawar</td>
                            <td>12</td>
                            <td>Rp. 100.000.000</td>
                            <td>Pernikahan</td>
                            <td>Tidak Aktif</td>
                            <td>
                                <button class="btn btn-primary">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-warning">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
