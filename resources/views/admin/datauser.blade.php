@extends('layout.admin.app')
@section('title', 'Data User')
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
            <h6 class="m-0 font-weight-bold text-primary h4">Data User</h6>
            <button class="btn btn-success ml-auto" data-toggle="modal" data-target="#tambahKategori">Tambah User</button>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show auto-dismiss" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show auto-dismiss" role="alert">
                    {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
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
                        @foreach ($data['user'] as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->nama_lengkap }}</td>
                                <td>{{ $item->email }}</td>
                                <td>{{ $item->telephone }}</td>
                                <td>{{ $item->role }}</td>
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
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Modal tambah kategori -->
    <div class="modal fade" id="tambahKategori" tabindex="-1" aria-labelledby="tambahKategoriLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{route('datausertambah')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-primary font-weight-bold" id="exampleModalLabel">Tambah User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" class="form-control" id="exampleInputEmail1" required>
                            @error('nama_lengkap')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Email</label>
                            <input type="email" name="email" class="form-control" id="exampleInputEmail1" required>
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Telephone</label>
                            <input type="text" name="telephone" class="form-control" id="exampleInputEmail1" required>
                            @error('telephone')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlFile1">Foto Profil</label>
                            <input type="file" class="form-control-file" name="foto" id="exampleFormControlFile1">
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Role</label>
                            <select name="role" class="form-control" id="exampleFormControlSelect1" required>
                                <option disabled selected>-Pilih Role--</option>
                                @foreach ($data['role'] as $role)
                                    <option value="{{ $role->id_role }}">{{ $role->role }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Password</label>
                            <input type="password" name="password" class="form-control" id="inputPassword" required>
                            @error('password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
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
@section('script')
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // document.querySelectorAll('.btn-edit').forEach(button => {
        //     button.addEventListener('click', function() {
        //         const id = this.dataset.id;
        //         const url = this.dataset.url;

        //         // Clear previous form state
        //         document.getElementById('formEditKategori').reset();

        //         // Fetch category data via AJAX
        //         fetch(url)
        //             .then(response => {
        //                 if (!response.ok) {
        //                     throw new Error('Kategori tidak ditemukan');
        //                 }
        //                 return response.json();
        //             })
        //             .then(data => {
        //                 // Populate modal form with data
        //                 document.getElementById('editNamaKategori').value = data.kategori;

        //                 // Update form action dynamically
        //                 document.getElementById('formEditKategori').action =
        //                 `datakategori/update/${id}`;
        //             })
        //             .catch(error => {
        //                 console.error(error);
        //                 Swal.fire('Error', 'Gagal mengambil data kategori', 'error');
        //             });
        //     });
        // });
        // document.querySelectorAll('.btn-hapus').forEach(button => {
        //     button.addEventListener('click', function() {
        //         const id = this.dataset.id;
        //         const name = this.dataset.name;

        //         Swal.fire({
        //             title: 'Apakah Anda yakin?',
        //             text: `Kategori "${name}" akan dihapus secara permanen!`,
        //             icon: 'warning',
        //             showCancelButton: true,
        //             confirmButtonColor: '#d33',
        //             cancelButtonColor: '#3085d6',
        //             confirmButtonText: 'Hapus',
        //             cancelButtonText: 'Batal'
        //         }).then((result) => {
        //             if (result.isConfirmed) {
        //                 document.getElementById(`form-hapus-${id}`).submit();
        //             }
        //         });
        //     });
        // });
        // Automatically dismiss alerts after 5 seconds
        $(document).ready(function() {
            setTimeout(function() {
                $(".auto-dismiss").fadeOut("slow", function() {
                    $(this).remove();
                });
            }, 5000); // 5000ms = 5 seconds
        });
    </script>
@endsection
