<?php

namespace App\Http\Controllers;

use App\Models\AdminModel;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;


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
    public function databarangview($id)
    {
        // Fetch data using the model method
        $cek = AdminModel::JoinDataBarangById($id);

        // Check if data exists
        if (!$cek) {
            return response()->json([
                'error' => 'Barang tidak ditemukan'
            ], 404);
        }

        // Format response to include relevant fields
        $data = [
            'id_barang' => $cek->id_barang,
            'nama_barang' => $cek->nama_barang,
            'stok_barang' => $cek->stok_barang,
            'harga_barang' => $cek->harga_barang,
            'deskripsi_barang' => $cek->deskripsi_barang,
            'foto_barang' => asset('img/barang_img/' . $cek->foto_barang), // Ensure the image path is correct
            'kategori' => $cek->kategori,
            'status_barang' => $cek->status_barang,
        ];

        // Return the formatted data
        return response()->json($data, 200);
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
        $data['role'] = AdminModel::GetData('role');
        $data['user'] = AdminModel::JoinUser();
        return view("admin.datauser", compact('data'));
    }
    public function datausertambah(Request $request)
    {
        // dd($request->all());
        // Validasi input
        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'telephone' => 'required|string|max:15|unique:users,telephone',
            'password' => 'required|string|min:6',
            'role' => 'string',
            'foto' => 'nullable',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $uploadPath = public_path('img/profil_user');

        if (!File::isDirectory($uploadPath)) {
            File::makeDirectory($uploadPath, 0777, true, true);
        }
        if ($request->file('foto') == null) {
            User::create([
                'nama_lengkap' => $request->nama_lengkap,
                'email' => $request->email,
                'telephone' => $request->telephone,
                'foto' => 'deafultpp.svg',
                'id_role' => 2,
                'password' => Hash::make($request->password),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        } else {
            $image = $request->file('foto');
            $imageName = $image->hashName();

            try {
                $image->move($uploadPath, $imageName);
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Gagal mengunggah foto barang: ' . $e->getMessage());
            }
            User::create([
                'nama_lengkap' => $request->nama_lengkap,
                'email' => $request->email,
                'telephone' => $request->telephone,
                'foto' => $imageName,
                'id_role' => $request->role,
                'password' => Hash::make($request->password),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }

        // Simpan data ke database


        // Redirect ke halaman login atau dashboard
        return redirect()->route('datauser')->with('success', 'Tambah user berhasil!!');
    }
}
