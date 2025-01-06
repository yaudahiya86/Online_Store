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
                                    <button class="btn btn-primary btn-view" data-id="{{ $item->id }}"
                                        data-url="{{ route('datauserview', $item->id) }}" data-toggle="modal"
                                        data-target="#viewKategori">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-warning btn-edit" data-id="{{ $item->id }}"
                                        data-url="{{ route('datauserview', $item->id) }}" data-toggle="modal"
                                        data-target="#edituser">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-danger btn-delete" data-id="{{ $item->id }}">
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
            <form action="{{ route('datausertambah') }}" method="POST" enctype="multipart/form-data">
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
                            <label for="exampleInputEmail1">Alamat</label>
                            <input type="text" name="alamat" class="form-control" id="exampleInputEmail1">
                            @error('alamat')
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
    {{-- Modal View User --}}
    <div class="modal fade" id="viewKategori" tabindex="-1" aria-labelledby="viewKategoriLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-primary font-weight-bold" id="viewUserModalLabel">Detail User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4 text-center">
                            <img id="fotoview" src="/img/default.png" alt="Foto User" class="img-thumbnail"
                                style="width: 100%; max-width: 200px;">
                        </div>
                        <div class="col-md-8">
                            <p><strong>Nama Lengkap:</strong> <span id="nama_lengkap"></span></p>
                            <p><strong>Email:</strong> <span id="email"></span></p>
                            <p><strong>Telephone:</strong> <span id="telephone"></span></p>
                            <p><strong>Role:</strong> <span id="role"></span></p>
                            <p><strong>Alamat:</strong> <span id="alamat"></span></p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal edit kategori -->
    <div class="modal fade" id="edituser" tabindex="-1" aria-labelledby="edituserLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="#" method="POST" enctype="multipart/form-data" id="edituser">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-primary font-weight-bold" id="exampleModalLabel">Edit User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" class="form-control" id="nama_lengkap" required>
                            @error('nama_lengkap')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Email</label>
                            <input type="email" name="email" class="form-control" id="email" required>
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Telephone</label>
                            <input type="text" name="telephone" class="form-control" id="telephone" required>
                            @error('telephone')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Alamat</label>
                            <input type="text" name="alamat" class="form-control" id="alamat">
                            @error('alamat')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlFile1">Foto Profil</label>
                            <img src="" id="fotoedit" alt="" width="60px">
                            <input type="file" class="form-control-file" name="foto" id="exampleFormControlFile1">
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Role</label>
                            <select name="role" class="form-control" id="role" required>
                                <option disabled selected>-Pilih Role--</option>
                                @foreach ($data['role'] as $role)
                                    <option value="{{ $role->id_role }}">{{ $role->role }}</option>
                                @endforeach
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
@section('script')
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $('.btn-view').on('click', function() {
            let url = $(this).data('url'); // URL endpoint untuk mendapatkan data user

            // Make AJAX request to get user data
            $.ajax({
                url: url,
                type: 'GET',
                success: function(response) {
                    // Populate the modal fields with the fetched data
                    $('#viewKategori #nama_lengkap').text(response.nama_lengkap);
                    $('#viewKategori #email').text(response.email);
                    $('#viewKategori #telephone').text(response.telephone);
                    $('#viewKategori #alamat').text(response.alamat);
                    const roleName = response.id_role === 1 ? 'Admin' : response.id_role === 2 ?
                        'User' : 'Unknown';
                    $('#viewKategori #role').text(roleName);
                    $('#fotoview').attr('src', response.foto ? `/img/profiluser/${response.foto}` :
                        '/img/default.png');

                    // Show the modal
                    $('#viewKategori').modal('show');
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    Swal.fire('Error', 'Gagal memuat data user', 'error');
                }
            });
        });

        $('.btn-edit').on('click', function() {
            let url = $(this).data('url'); // URL endpoint for fetching user data

            // Make AJAX request to get user data
            $.ajax({
                url: url,
                type: 'GET',
                success: function(response) {
                    // Populate the modal fields with the fetched data
                    $('#edituser #nama_lengkap').val(response.nama_lengkap);
                    $('#edituser #email').val(response.email);
                    $('#edituser #telephone').val(response.telephone);
                    $('#edituser #alamat').val(response.alamat);
                    $('#edituser #role').val(response.role);
                    $('#fotoedit').attr('src', response.foto ? `/img/profiluser/${response.foto}` :
                        '/img/profiluser/default.png');
                    console.log(response.foto);
                    // Set selected kategori
                    $('#edituser #role option').each(function() {
                        if ($(this).val() == response.id_role) {
                            $(this).attr('selected', 'selected');
                        } else {
                            $(this).removeAttr('selected');
                        }
                    });

                    // Update the action URL for the form to handle editing
                    $('#edituser form').attr('action',
                        `{{ route('datauseredit', ':id') }}`.replace(':id', response
                            .id));
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    Swal.fire('Error', 'Gagal memuat data user', 'error');
                }
            });
        });

        $('.btn-delete').on('click', function() {
            let userId = $(this).data('id'); // Ambil ID user
            let url = '{{ route('datauserhapus', ':id') }}'.replace(':id',
            userId); // Ganti dengan URL untuk menghapus user

            // Tampilkan konfirmasi dengan SweetAlert2
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data ini akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Lakukan penghapusan menggunakan AJAX
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}', // Kirim CSRF token untuk keamanan
                        },
                        success: function(response) {
                            // Jika berhasil, beri notifikasi dan reload halaman
                            Swal.fire('Dihapus!', 'Data telah dihapus.', 'success');
                            location.reload(); // Reload halaman untuk menampilkan data terbaru
                        },
                        error: function(xhr) {
                            // Jika terjadi error
                            Swal.fire('Gagal!', 'Terjadi kesalahan saat menghapus data.',
                                'error');
                        }
                    });
                }
            });
        });


        $(document).ready(function() {
            setTimeout(function() {
                $(".auto-dismiss").fadeOut("slow", function() {
                    $(this).remove();
                });
            }, 5000); // 5000ms = 5 seconds
        });
    </script>
@endsection
