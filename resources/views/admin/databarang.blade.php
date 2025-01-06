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
                        @foreach ($data['join'] as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->nama_barang }}</td>
                                <td>{{ $item->stok_barang }}</td>
                                <td>{{ $item->harga_barang }}</td>
                                <td>{{ $item->kategori }}</td>
                                <td>{{ $item->status_barang }}</td>
                                <td>
                                    <button class="btn btn-view btn-primary" data-id="{{ $item->id_barang }}"
                                        data-url="{{ route('databarangview', $item->id_barang) }}" data-toggle="modal"
                                        data-target="#viewBarang">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-edit btn-warning" data-id="{{ $item->id_barang }}"
                                        data-url="{{ route('databarangview', $item->id_barang) }}" data-toggle="modal"
                                        data-target="#editBarang">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-hapus btn-danger" data-id="{{ $item->id_barang }}"
                                        data-name={{ $item->nama_barang }}>
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
    <!-- Modal tambah barang -->
    <div class="modal fade" id="tambahBarang" tabindex="-1" aria-labelledby="tambahBarangLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('databarangtambah') }}" method="POST" enctype="multipart/form-data">
                @csrf
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
                            <input type="text" name="nama_barang" class="form-control" id="exampleInputEmail1"
                                aria-describedby="emailHelp" required>
                        </div>
                        <div class="form-group">
                            <label for="stok">Stok Barang</label>
                            <input type="number" name="stok_barang" class="form-control" id="stok"
                                aria-describedby="emailHelp" required>
                        </div>
                        <div class="form-group">
                            <label for="harga">Harga Barang</label>
                            <input type="text" name="harga_barang" class="form-control" id="harga_barang" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">Deskripsi Barang</label>
                            <textarea name="deskripsi_barang" class="form-control" id="exampleFormControlTextarea1" rows="3" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlFile1">Foto barang</label>
                            <input type="file" class="form-control-file" name="foto_barang" id="exampleFormControlFile1"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Kategori barang</label>
                            <select name="kategori" class="form-control" id="exampleFormControlSelect1" required>
                                <option disabled selected>--Pilih Kategori--</option>
                                @foreach ($data['kategori'] as $item)
                                    <option value="{{ $item->id_kategori }}">{{ $item->kategori }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlSelect">Status barang</label>
                            <select name="status" class="form-control" id="exampleFormControlSelect" required>
                                <option disabled selected>--Pilih Status Barang--</option>
                                <option value="Aktif">Aktif</option>
                                <option value="Tidak Aktif">Tidak Aktif</option>
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
    <!-- Modal edit barang -->
    <div class="modal fade" id="editBarang" tabindex="-1" aria-labelledby="editBarangLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="#" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-primary font-weight-bold" id="exampleModalLabel">Edit Barang</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Nama Barang</label>
                            <input type="text" name="nama_barang" class="form-control" id="nama_barang"
                                aria-describedby="emailHelp">
                        </div>
                        <div class="form-group">
                            <label for="stok">Stok Barang</label>
                            <input type="number" name="stok_barang" class="form-control" id="stok_barang"
                                aria-describedby="emailHelp">
                        </div>
                        <div class="form-group">
                            <label for="harga">Harga Barang</label>
                            <input type="text" name="harga_barang" class="form-control" id="harga_barang">
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">Deskripsi Barang</label>
                            <textarea name="deskripsi_barang" class="form-control" id="deskripsi_barang" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlFile1">Foto barang</label>
                            <img src="" id="fotoview" alt="" width="60px">
                            <input type="file" class="form-control-file" name="foto_barang"
                                id="exampleFormControlFile1">
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Kategori barang</label>
                            <select name="kategori" class="form-control" id="kategori">
                                <option disabled selected>--Pilih Kategori--</option>
                                @foreach ($data['kategori'] as $item)
                                    <option value="{{ $item->id_kategori }}">{{ $item->kategori }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlSelect">Status barang</label>
                            <select name="status" class="form-control" id="status">
                                <option disabled selected>--Pilih Status Barang--</option>
                                <option value="Aktif">Aktif</option>
                                <option value="Tidak Aktif">Tidak Aktif</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="modal fade" id="viewBarang" tabindex="-1" role="dialog" aria-labelledby="viewBarangLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewBarangLabel">Detail Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <img id="fotoview" src="" class="img-fluid" alt="Foto Barang"
                                style="display: none;" />
                        </div>
                        <div class="col-md-8">
                            <table class="table table-bordered">
                                <tr>
                                    <th>Nama Barang</th>
                                    <td id="nama_barang"></td>
                                </tr>
                                <tr>
                                    <th>Stok</th>
                                    <td id="stok_barang"></td>
                                </tr>
                                <tr>
                                    <th>Harga</th>
                                    <td id="harga_barang"></td>
                                </tr>
                                <tr>
                                    <th>Kategori</th>
                                    <td id="kategori"></td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td id="status"></td>
                                </tr>
                                <tr>
                                    <th>Deskripsi</th>
                                    <td id="deskripsi_barang"></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            $('.btn-edit').on('click', function() {
                let url = $(this).data('url'); // URL endpoint untuk get data barang

                // Lakukan AJAX request untuk mendapatkan data barang
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(response) {
                        // Isi data ke dalam modal edit
                        $('#editBarang #nama_barang').val(response.nama_barang);
                        $('#editBarang #stok_barang').val(response.stok_barang);
                        $('#editBarang #harga_barang').val(formatRupiah(response.harga_barang
                            .toString(), 'Rp. '));
                        $('#editBarang #harga_barang_raw').val(response
                            .harga_barang); // Simpan harga asli
                        $('#editBarang #deskripsi_barang').val(response.deskripsi_barang);

                        // Set selected kategori
                        $('#editBarang #kategori option').each(function() {
                            if ($(this).val() == response.id_kategori) {
                                $(this).attr('selected', 'selected');
                            } else {
                                $(this).removeAttr('selected');
                            }
                        });

                        // Set selected status
                        $('#editBarang #status option').each(function() {
                            if ($(this).val() == response.status_barang) {
                                $(this).attr('selected', 'selected');
                            } else {
                                $(this).removeAttr('selected');
                            }
                        });

                        // Tampilkan foto jika ada
                        if (response.foto_barang) {
                            $('#editBarang #fotoview').attr('src', response.foto_barang);
                        } else {
                            $('#editBarang #fotoview').attr('src', '');
                        }

                        $('#editBarang form').attr('action',
                            `{{ route('databarangedit', ':id') }}`.replace(':id', response
                                .id_barang));
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        Swal.fire('Error', 'Gagal memuat data barang', 'error');
                    }
                });
            });
            $('.btn-view').on('click', function() {
                let url = $(this).data('url'); // URL endpoint untuk get data barang

                // Lakukan AJAX request untuk mendapatkan data barang
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(response) {
                        if (response) {
                            // Isi data ke dalam modal view
                            $('#viewBarang #nama_barang').text(response.nama_barang);
                            $('#viewBarang #stok_barang').text(response.stok_barang);
                            $('#viewBarang #harga_barang').text(formatRupiah(response
                                .harga_barang.toString(), 'Rp. '));
                            $('#viewBarang #deskripsi_barang').text(response.deskripsi_barang);
                            $('#viewBarang #kategori').text(response.kategori);
                            $('#viewBarang #status').text(response.status_barang == 1 ?
                                'Aktif' : 'Tidak Aktif');

                            // Tampilkan foto jika ada
                            if (response.foto_barang) {
                                $('#viewBarang #fotoview').attr('src', response.foto_barang)
                                    .show();
                            } else {
                                $('#viewBarang #fotoview').hide();
                            }
                        } else {
                            Swal.fire('Error', 'Data barang tidak ditemukan', 'error');
                        }
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        Swal.fire('Error', 'Gagal memuat data barang', 'error');
                    }
                });
            });
            $('.btn-hapus').on('click', function() {
                let id = $(this).data('id'); // ID barang yang akan dihapus
                let name = $(this).data('name'); // Nama barang untuk ditampilkan di dialog

                Swal.fire({
                    title: 'Konfirmasi Hapus',
                    text: `Apakah Anda yakin ingin menghapus barang "${name}"?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Lakukan AJAX request untuk menghapus barang
                        $.ajax({
                            url: `{{ route('databaranghapus', ':id') }}`.replace(':id',
                                id), // Generate URL dari name route
                            type: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                    'content') // Laravel CSRF token
                            },
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire(
                                        'Berhasil!',
                                        'Barang telah dihapus.',
                                        'success'
                                    ).then(() => {
                                        // Reload halaman atau tabel setelah data dihapus
                                        location.reload();
                                    });
                                } else {
                                    Swal.fire('Gagal!', response.message ||
                                        'Gagal menghapus barang.', 'error');
                                }
                            },
                            error: function(xhr) {
                                console.error(xhr.responseText);
                                Swal.fire('Error!',
                                    'Terjadi kesalahan saat menghapus barang.',
                                    'error');
                            }
                        });
                    }
                });
            });


            // Format harga saat user mengetik
            $('#harga_barang').on('keyup', function() {
                let value = $(this).val().replace(/[^,\d]/g, ''); // Hanya angka dan koma
                $(this).val(formatRupiah(value, 'Rp. '));
            });

            // Fungsi format Rupiah
            function formatRupiah(angka, prefix) {
                let numberString = angka.replace(/[^,\d]/g, '').toString();
                let split = numberString.split(',');
                let sisa = split[0].length % 3;
                let rupiah = split[0].substr(0, sisa);
                let ribuan = split[0].substr(sisa).match(/\d{3}/g);

                if (ribuan) {
                    let separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }

                rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
                return prefix === undefined ? rupiah : (rupiah ? prefix + rupiah : '');
            }
        });
    </script>
@endsection
