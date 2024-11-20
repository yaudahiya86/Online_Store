@extends('layout.admin.app')
@section('title', 'Data User')
@section('content')
<style>
    /* Menetapkan lebar kolom yang ditentukan di tabel */
    #dataTable th, #dataTable td {
        white-space: nowrap;  /* Mencegah teks membungkus ke baris baru */
    }

    #dataTable th:nth-child(1), #dataTable td:nth-child(1) {
        width: 50px !important; /* Nama Barang */
    }

    #dataTable th:nth-child(3), #dataTable td:nth-child(3) {
        width: 30px !important; /* Stok */
    }
    /* Responsif pada layar kecil */
    @media (max-width: 767px) {
        /* Buat tabel scrollable */
        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        #dataTable th, #dataTable td {
            width: auto !important; /* Biarkan lebar otomatis pada layar kecil */
        }
    }
</style>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary h4">Data Kategori</h6>
        <button class="btn btn-success ml-auto" data-toggle="modal" data-target="#tambahKategori">Tambah Kategori</button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Lengkap</th>
                        <th>Email</th>
                        <th>Telephone</th>
                        <th>Role</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Nama Lengkap</th>
                        <th>Email</th>
                        <th>Telephone</th>
                        <th>Role</th>
                        <th>Aksi</th>
                    </tr>
                </tfoot>
                <tbody>
                    <tr>
                        <td>1.</td>
                        <td>Ergi Sapta Wijaya</td>
                        <td>ergisaptawijaya@gmail.com</td>
                        <td>789456123</td>
                        <td>User</td>
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
<!-- Modal tambah kategori -->
<div class="modal fade" id="tambahKategori" tabindex="-1" aria-labelledby="tambahKategoriLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="" method="">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-primary font-weight-bold" id="exampleModalLabel">Tambah Kategori</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email</label>
                        <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Telephone</label>
                        <input type="text" name="telephone" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlFile1">Foto Profil</label>
                        <input type="file" class="form-control-file" name="foto" id="exampleFormControlFile1">
                      </div>
                      <div class="form-group">
                        <label for="exampleFormControlSelect1">Role</label>
                        <select name="role" class="form-control" id="exampleFormControlSelect1">
                          <option>admin</option>
                          <option>user</option>
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail1">Password</label>
                        <input type="password" name="password" class="form-control" id="inputPassword">
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
