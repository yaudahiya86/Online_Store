<?php

namespace App\Http\Controllers;

use App\Models\AdminModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view("admin.dashboard");
    }



    public function databarang()
    {
        $data['kategori'] = AdminModel::GetData('kategori');
        $data['status_barang'] = AdminModel::GetData('status_barang');
        $data['join'] = AdminModel::JoinDataBarang();
        // dd($data['join']);
        return view("admin.databarang", compact('data'));
    }
    public function databarangtambah(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'stok_barang' => 'required|integer|min:0',
            'harga_barang_raw' => 'required|numeric|min:0',
            'deskripsi_barang' => 'required|string|max:1000',
            'foto_barang' => 'required|file|mimes:jpg,jpeg,png|max:2048',
            'kategori' => 'required|integer',
            'status' => 'required|integer',
        ]);

        $uploadPath = public_path('img/barang_img');

        if (!File::isDirectory($uploadPath)) {
            File::makeDirectory($uploadPath, 0777, true, true);
        }

        $image = $request->file('foto_barang');
        $imageName = $image->hashName();

        try {
            $image->move($uploadPath, $imageName);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengunggah foto barang: ' . $e->getMessage());
        }

        $cek = AdminModel::InsertData('barang', [
            'nama_barang' => $request->nama_barang,
            'stok_barang' => $request->stok_barang,
            'harga_barang' => $request->harga_barang_raw,
            'deskripsi_barang' => $request->deskripsi_barang,
            'foto_barang' => $imageName,
            'id_kategori' => $request->kategori,
            'id_status_barang' => $request->status,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        if (!$cek) {
            return redirect()->back()->with('error', 'Gagal menambah barang ke database. Silakan coba lagi.');
        }

        return redirect()->route('databarang')->with('success', 'Barang berhasil ditambahkan.');
    }




    public function datakategori()
    {
        $data = AdminModel::GetData('kategori');
        return view("admin.datakategori", compact('data'));
    }
    public function datakategoritambah(Request $request)
    {
        $request->validate([
            'kategori' => 'required'
        ]);
        $data = [
            'kategori' => $request->kategori,
        ];
        $cek = AdminModel::GetDataById('kategori', $data);
        if ($cek) {
            return redirect()->back()->with('error', 'Kategori sudah ada');
        }
        AdminModel::InsertData('kategori', $data);

        return redirect()->route('datakategori')->with('success', 'Berhasil menambah kategori');
    }
    public function datakategoriedit($id)
    {
        $data = ['id_kategori' => $id];

        $cek = AdminModel::GetDataById('kategori', $data);

        if (!$cek) {
            return response()->json(['error' => 'Kategori tidak ditemukan'], 404);
        }
        return response()->json($cek, 200);
    }
    public function datakategoriupdate(Request $request, $id)
    {
        $validated = $request->validate([
            'kategori' => 'required|string|max:255',
        ]);

        $data = [
            'kategori' => $validated['kategori']
        ];

        $where = ['id_kategori' => $id];

        $update = AdminModel::UpdateData('kategori', $where, $data);

        if ($update) {
            return redirect()->route('datakategori')->with('success', 'Kategori berhasil diperbarui');
        }

        return redirect()->route('datakategori')->with('error', 'Gagal memperbarui kategori');
    }
    public function datakategorihapus(Request $request, $id)
    {
        $data = [
            'id_kategori' => $id
        ];
        AdminModel::DeleteData('kategori', $data);

        return redirect()->route('datakategori')->with('success', 'Berhasil menghapus kategori');
    }



    public function datapesanan()
    {
        return view("admin.datapesanan");
    }
    public function detailpesanan()
    {
        return view("admin.detailpesanan.detailpesanan");
    }



    public function datauser()
    {
        return view("admin.datauser");
    }
}
