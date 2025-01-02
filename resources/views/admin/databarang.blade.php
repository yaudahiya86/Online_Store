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
                            <input type="hidden" name="harga_barang_raw" id="harga_barang_raw">
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
                            <input type="hidden" name="harga_barang_raw" id="harga_barang_raw">
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">Deskripsi Barang</label>
                            <textarea name="deskripsi_barang" class="form-control" id="deskripsi_barang" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlFile1">Foto barang</label>
                            <img src="" id="fotoview" alt="">
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
@endsection
@section('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            // When the 'Edit' button is clicked
            $('.btn-edit').click(function() {
                const id = $(this).data('id');
                const url = $(this).data('url');

                // Fetch the data from the server
                $.ajax({
                    url: url, // route to fetch the data based on id
                    method: 'GET',
                    success: function(data) {
                        // Populate the modal fields with the data returned from the server
                        $('#editBarang form').attr('action', '/databarang/' +
                        id); // Set dynamic action for the form
                        $('#nama_barang').val(data.nama_barang);
                        $('#stok_barang').val(data.stok_barang);
                        $('#harga_barang').val(data.harga_barang);
                        $('#deskripsi_barang').val(data.deskripsi_barang);
                        $('#foto_barang').attr('src', data.foto_barang); // Display existing photo
                        $('#kategori').val(data.id_kategori);
                        $('#status').val(data.status_barang);
                    },
                    error: function() {
                        Swal.fire('Error', 'Tidak dapat mengambil data', 'error');
                    }
                });
            });

            // Handle form submission for editing (AJAX)
            $('#editBarang form').submit(function(e) {
                e.preventDefault();

                const formData = new FormData(this);

                $.ajax({
                    url: $(this).attr('action'),
                    method: 'PUT',
                    data: formData,
                    processData: false, // Don't process the data
                    contentType: false, // Don't set content type
                    success: function(response) {
                        Swal.fire('Berhasil', 'Data barang berhasil diperbarui', 'success')
                            .then(() => {
                                // Close the modal and reload the table or page
                                $('#editBarang').modal('hide');
                                location.reload();
                            });
                    },
                    error: function() {
                        Swal.fire('Error', 'Gagal memperbarui data barang', 'error');
                    }
                });
            });

            // Format harga input in Rupiah
            const hargaInput = $('#harga_barang');
            const hargaRawInput = $('#harga_barang_raw');

            hargaInput.on('input', function(e) {
                let value = e.target.value.replace(/[^,\d]/g, ''); // Remove non-numeric characters
                let numberValue = parseInt(value, 10) || 0;

                // Store raw value
                hargaRawInput.val(numberValue);

                // Format number as currency (Rupiah)
                e.target.value = new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 0
                }).format(numberValue);
            });
        });
    </script>
@endsection
