<?php

namespace App\Http\Controllers;

use App\Models\AdminModel;
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
            'kategori' => $request->kategori
        ];
        AdminModel::InsertData('kategori', $data);

        return redirect()->route('datakategori')->with('success', 'Berhasil menambah kategori');
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
