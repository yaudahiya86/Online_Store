<?php

namespace App\Http\Controllers;

use App\Models\AdminModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view("admin.dashboard");
    }



    public function databarang()
    {
        return view("admin.databarang");
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
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
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

    $update = AdminModel::UpdateData('kategori', $data, $where);

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
