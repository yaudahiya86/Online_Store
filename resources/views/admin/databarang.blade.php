@extends('layout.admin.app')
@section('title', 'Data Barang')
@section('content')
    <style>
        /* Menetapkan lebar kolom yang ditentukan di tabel */
        #dataTable th,
        #dataTable td {
            white-space: nowrap;
            /* Mencegah teks membungkus ke baris baru */
        }

        #dataTable th:nth-child(2),
        #dataTable td:nth-child(2) {
            width: 400px !important;
            /* Nama Barang */
        }

        #dataTable th:nth-child(3),
        #dataTable td:nth-child(3) {
            width: 30px !important;
            /* Stok */
        }

        #dataTable th:nth-child(4),
        #dataTable td:nth-child(4) {
            width: 110px !important;
            /* Harga */
        }

        #dataTable th:nth-child(5),
        #dataTable td:nth-child(5) {
            width: auto !important;
            /* Kategori, biarkan otomatis */
        }

        #dataTable th:nth-child(6),
        #dataTable td:nth-child(6) {
            width: 60px !important;
            /* Status */
        }

        #dataTable th:nth-child(7),
        #dataTable td:nth-child(7) {
            width: 120px !important;
            /* Aksi */
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
            <h6 class="m-0 font-weight-bold text-primary h4">Data Barang</h6>
            <button class="btn btn-success ml-auto" data-toggle="modal" data-target="#tambahBarang">Tambah Barang</button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th width="400px">Nama Barang</th>
                            <th width="30px">Stok</th>
                            <th width="110px">Harga</th>
                            <th>Kategori</th>
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
    <!-- Modal tambah barang -->
    <div class="modal fade" id="tambahBarang" tabindex="-1" aria-labelledby="tambahBarangLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="" method="">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-primary font-weight-bold" id="exampleModalLabel">Tambah Barang</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Nama Barang</label>
                            <input type="text" name="nama_barang" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                        </div>
                        <div class="form-group">
                            <label for="stok">Stok Barang</label>
                            <input type="number" name="stok_barang" class="form-control" id="stok" aria-describedby="emailHelp">
                        </div>
                        <div class="form-group">
                            <label for="harga">Harga Barang</label>
                            <input type="number" name="harga_barang" class="form-control" id="harga" aria-describedby="emailHelp">
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">Deskripsi Barang</label>
                            <textarea name="deskripsi_Barang" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                          </div>
                          <div class="form-group">
                            <label for="exampleFormControlFile1">Foto barang</label>
                            <input type="file" class="form-control-file" name="foto_barang" id="exampleFormControlFile1">
                          </div>
                          <div class="form-group">
                            <label for="exampleFormControlSelect1">Kategori barang</label>
                            <select name="kategori" class="form-control" id="exampleFormControlSelect1">
                              <option>Pernikahan</option>
                              <option>Kelulusan</option>
                            </select>
                          </div>
                          <div class="form-group">
                            <label for="exampleFormControlSelect">Status barang</label>
                            <select name="status" class="form-control" id="exampleFormControlSelect">
                              <option>Aktif</option>
                              <option>Tidak Aktif</option>
                            </select>
                          </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
