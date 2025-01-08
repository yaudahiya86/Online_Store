<?php

namespace App\Http\Controllers;

use App\Models\AdminModel;
use App\Models\UserModel;
use Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function beranda()
    {
        $where = [
            'status_barang' => 'Aktif'
        ];
        $data['barang'] = UserModel::GetData('barang');
        // dd($data);
        return view('user.beranda', compact('data'));
    }
    public function keranjang()
    {
        $where = [
            'id_user' => Auth::user()->id
        ];
        $data['keranjang'] = UserModel::JoinKeranjang($where);
        // dd($data);
        return view('user.keranjang', compact('data'));
    }
    public function tambahkeranjang($id)
{
    $userId = Auth::user()->id;

    // Periksa apakah barang sudah ada di keranjang
    $existingItem = UserModel::GetDataById('keranjang', [
        'id_barang' => $id,
        'id_user' => $userId
    ]); // Mengambil data pertama jika ada

    if ($existingItem) {
        // Jika barang sudah ada, tambahkan total_barang_satuan
        $updated = UserModel::UpdateData('keranjang', [
            'id_keranjang' => $existingItem->id_keranjang
        ], [
            'total_barang_satuan' => $existingItem->total_barang_satuan + 1
        ]);

        if ($updated) {
            return redirect()->route('beranda')->with('success', 'Jumlah barang di keranjang berhasil diperbarui.');
        } else {
            return redirect()->route('beranda')->with('error', 'Gagal memperbarui jumlah barang di keranjang.');
        }
    }

    // Jika barang belum ada, tambahkan ke keranjang
    $data = [
        'id_barang' => $id,
        'id_user' => $userId,
        'total_barang_satuan' => 1 // Set jumlah awal menjadi 1
    ];
    $insert = UserModel::InsertData('keranjang', $data);

    if ($insert) {
        return redirect()->route('beranda')->with('success', 'Barang berhasil ditambahkan ke keranjang.');
    } else {
        return redirect()->route('beranda')->with('error', 'Gagal menambahkan barang ke keranjang.');
    }
}


}
