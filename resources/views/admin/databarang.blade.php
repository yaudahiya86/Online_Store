@extends('layout.admin.app')
@section('title', 'Data Barang')
@section('content')
<link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css">
<div class="databarang">
    <div class="card">
        <div class="card-header">
            Data Barang
            <button class="tambahbarang" onclick="showModal()">Tambah Barang</button>
        </div>
        <div class="card-body">
            <div style="overflow-x: auto;">
                <table class="tabel" id="tabel">
                    <thead>
                        <tr>
                            <th width="20px">No</th>
                            <th>Nama barang</th>
                            <th width="20px">Stok</th>
                            <th>Harga</th>
                            <th>Kategori</th>
                            <th width="120px">Status</th>
                            <th width="140px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Bucket</td>
                            <td>12</td>
                            <td>Rp. 200.000</td>
                            <td>Pernikahan</td>
                            <td>Tidak Aktif</td>
                            <td>
                                <button class="detail"><i class="fas fa-eye"></i></button>
                                <button class="edit"><i class="fas fa-edit"></i></button>
                                <button class="hapus"><i class="fas fa-trash-alt"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Adding Barang -->
<div class="modal" id="tambahBarangModal">
    <div class="modal-content">
        <div class="modal-header">
            Tambah Barang
            <span class="close" onclick="closeModal()">&times;</span>
        </div>
        <form action="#" method="POST">
            @csrf
            <div class="form-group">
                <label for="nama_barang">Nama Barang</label><br>
                <input type="text" class="form-control" id="nama_barang" name="nama_barang" required>
            </div>
            <div class="form-group">
                <label for="nama_barang">Deskripsi Barang</label><br>
                <textarea id="" cols="30" rows="10"></textarea>
            </div>
            <div class="form-group">
                <label for="stok">Stok</label><br>
                <input type="number" class="form-control" id="stok" name="stok" required>
            </div>
            <div class="form-group">
                <label for="harga">Harga</label><br>
                <input type="text" class="form-control" id="harga" name="harga" required>
            </div>
            <div class="form-group">
                <label for="kategori">Kategori</label><br>
                <select class="form-control" id="kategori" name="kategori" required>
                    <option value="Pernikahan">Pernikahan</option>
                    <option value="Elektronik">Elektronik</option>
                    <option value="Peralatan">Peralatan</option>
                </select>
            </div>
            <div class="form-group">
                <label for="harga">Foto</label><br>
                <input type="file" class="form-control" id="harga" name="harga" required>
            </div>
            <div class="form-group">
                <label for="kategori">Status</label><br>
                <select class="form-control" id="kategori" name="kategori" required>
                    <option value="Pernikahan">Aktif</option>
                    <option value="Pernikahan">Tidak Aktif</option>
                </select>
            </div>
            <div class="form-group">
                <button type="submit" class="submit">Tambah Barang</button>
            </div>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
<script>
    new DataTable('#tabel');

    // Show modal function
    function showModal() {
        document.getElementById("tambahBarangModal").style.display = "block";
    }

    // Close modal function
    function closeModal() {
        document.getElementById("tambahBarangModal").style.display = "none";
    }

    // Close modal when clicked outside of the modal
    window.onclick = function(event) {
        if (event.target == document.getElementById("tambahBarangModal")) {
            closeModal();
        }
    }
</script>
@endsection
