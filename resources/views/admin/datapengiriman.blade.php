@extends('layout.admin.app')
@section('title', 'Data Expedisi')
@section('content')
    <style>
        /* Menetapkan lebar kolom yang ditentukan di tabel */
        #dataTable th,
        #dataTable td {
            white-space: nowrap;
        }

        #dataTable th:nth-child(1),
        #dataTable td:nth-child(1) {
            width: 50px !important;
        }

        #dataTable th:nth-child(3),
        #dataTable td:nth-child(3) {
            width: 30px !important;
        }

        @media (max-width: 767px) {
            .table-responsive {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }

            #dataTable th,
            #dataTable td {
                width: auto !important;
            }
        }
    </style>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary h4">Data Expedisi</h6>
            <button class="btn btn-success ml-auto" data-toggle="modal" data-target="#tambahKategori">Tambah Expedisi</button>
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
                            <th>Nama Expedisi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Nama Expedisi</th>
                            <th>Aksi</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($data as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->expedisi_pengiriman }}</td>
                            <td>
                                <button class="btn btn-warning btn-edit" data-id="{{ $item->id_expedisi_pengiriman }}"
                                    data-url="{{ route('dataexpedisiedit', $item->id_expedisi_pengiriman) }}" data-toggle="modal"
                                    data-target="#editKategori">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-danger btn-hapus" data-id="{{ $item->id_expedisi_pengiriman }}"
                                    data-name="{{ $item->expedisi_pengiriman }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <form id="form-hapus-{{ $item->id_expedisi_pengiriman }}"
                                    action="{{ route('dataexpedisihapus', $item->id_expedisi_pengiriman) }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
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
            <form action="{{ route('dataexpedisitambah') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-primary font-weight-bold" id="exampleModalLabel">Tambah Kategori</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Nama Expedisi</label>
                            <input type="text" name="expedisi" class="form-control" id="exampleInputEmail1"
                                aria-describedby="emailHelp">
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

    <div class="modal fade" id="editKategori" tabindex="-1" aria-labelledby="editKategoriLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" id="formEditKategori">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-primary font-weight-bold" id="editKategoriLabel">Edit Kategori</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="editNamaKategori">Nama Expedisi</label>
                            <input type="text" name="expedisi" class="form-control" id="editNamaKategori" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


@endsection

@section('script')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function () {
        $('.btn-hapus').on('click', function () {
            const id = $(this).data('id');
            const name = $(this).data('name');
            const formId = `#form-hapus-${id}`;
            
            // SweetAlert konfirmasi
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: `Data ekspedisi "${name}" akan dihapus secara permanen!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Kirim formulir jika konfirmasi
                    $(formId).submit();
                }
            });
        });
    });
</script>
    <script>
        $(document).ready(function() {
            // Tombol Edit Kategori
            $('.btn-edit').on('click', function() {
                let url = $(this).data('url'); // URL untuk mendapatkan data kategori berdasarkan ID

                // Lakukan AJAX request untuk mendapatkan data kategori
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(response) {
                        // Isi data ke dalam modal edit
                        $('#editNamaKategori').val(response.expedisi_pengiriman);

                        // Atur action form untuk update kategori
                        $('#formEditKategori').attr(
                            'action',
                            `{{ route('dataexpedisiupdate', ':id') }}`.replace(':id',
                                response.id_expedisi_pengiriman)
                        );
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        Swal.fire('Error', 'Gagal memuat data kategori', 'error');
                    },
                });
            });
        });
    </script>
@endsection
