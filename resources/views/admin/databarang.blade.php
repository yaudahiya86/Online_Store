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
                                @foreach ($data['status_barang'] as $item)
                                    <option value="{{ $item->id_status_barang }}">{{ $item->status_barang }}</option>
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
    <!-- Modal view barang -->
    <div class="modal fade" id="viewBarang" tabindex="-1" aria-labelledby="viewBarangLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('databarangtambah') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-primary font-weight-bold" id="exampleModalLabel">View Barang</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Nama Barang</label>
                            <input type="text" name="nama_barang" class="form-control" id="namaview"
                                aria-describedby="emailHelp" readonly>
                        </div>
                        <div class="form-group">
                            <label for="stok">Stok Barang</label>
                            <input type="number" name="stok_barang" class="form-control" id="stokview"
                                aria-describedby="emailHelp" readonly>
                        </div>
                        <div class="form-group">
                            <label for="harga">Harga Barang</label>
                            <input type="text" name="harga_barang" class="form-control" id="hargaview" readonly>
                            <input type="hidden" name="harga_barang_raw" id="harga_barang_raw">
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">Deskripsi Barang</label>
                            <textarea name="deskripsi_barang" class="form-control" id="deskripsiview" rows="3" readonly></textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlFile1">Foto barang</label>
                            <img src="" id="fotoview" alt="">
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Kategori barang</label>
                            <select name="kategori" class="form-control" id="exampleFormControlSelect1" readonly>
                                <option disabled selected>--Pilih Kategori--</option>
                                @foreach ($data['kategori'] as $item)
                                    <option value="{{ $item->id_kategori }}">{{ $item->kategori }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlSelect">Status barang</label>
                            <select name="status" class="form-control" id="exampleFormControlSelect" readonly>
                                <option disabled selected>--Pilih Status Barang--</option>
                                @foreach ($data['status_barang'] as $item)
                                    <option value="{{ $item->id_status_barang }}">{{ $item->status_barang }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
@section('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const hargaInput = document.getElementById('harga_barang');
        const hargaRawInput = document.getElementById('harga_barang_raw');

        hargaInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/[^,\d]/g, ''); // Hapus karakter non-angka
            let numberValue = parseInt(value, 10) || 0;

            // Simpan nilai raw ke input hidden
            hargaRawInput.value = numberValue;

            // Format angka ke Rupiah
            e.target.value = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(numberValue);
        });
        $(document).ready(function() {
            setTimeout(function() {
                $(".auto-dismiss").fadeOut("slow", function() {
                    $(this).remove();
                });
            }, 5000); // 5000ms = 5 seconds
        });
    </script>

    <script>
        document.querySelectorAll('.btn-view').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.dataset.id;
                const url = this.dataset.url;

                // Clear previous modal content
                document.getElementById('namaview').value = '';
                document.getElementById('stokview').value = '';
                document.getElementById('hargaview').value = '';
                document.getElementById('deskripsiview').value = '';
                document.getElementById('fotoview').src = '';

                fetch(url)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Data barang tidak ditemukan');
                        }
                        return response.json();
                    })
                    .then(data => {
                        // Populate modal fields
                        document.getElementById('namaview').value = data.nama_barang;
                        document.getElementById('stokview').value = data.stok_barang;
                        document.getElementById('hargaview').value = new Intl.NumberFormat('id-ID', {
                            style: 'currency',
                            currency: 'IDR',
                            minimumFractionDigits: 0
                        }).format(data.harga_barang);
                        document.getElementById('deskripsiview').value = data.deskripsi_barang;
                        document.getElementById('fotoview').src = data.foto_barang;
                    })
                    .catch(error => {
                        console.error(error);
                        Swal.fire('Error', 'Gagal mengambil data barang', 'error');
                    });
            });
        });

        document.querySelectorAll('.btn-hapus').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.dataset.id;
                const name = this.dataset.name;

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: `Kategori "${name}" akan dihapus secara permanen!`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Hapus',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById(`form-hapus-${id}`).submit();
                    }
                });
            });
        });
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
