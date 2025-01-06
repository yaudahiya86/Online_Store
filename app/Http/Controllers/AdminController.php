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
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view("admin.dashboard");
    }



    public function databarang()
    {
        $data['kategori'] = AdminModel::GetData('kategori');
        $data['join'] = AdminModel::JoinDataBarang();
        // dd($data['join']);
        return view("admin.databarang", compact('data'));
    }
    public function databarangtambah(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'stok_barang' => 'required|integer|min:0',
            'harga_barang' => 'required',
            'deskripsi_barang' => 'required|string|max:1000',
            'foto_barang' => 'required|file|mimes:jpg,jpeg,png|max:2048',
            'kategori' => 'required|integer',
            'status' => 'required',
        ]);

        $uploadPath = public_path('img/barang_img');

        if (!File::isDirectory($uploadPath)) {
            File::makeDirectory($uploadPath, 0777, true, true);
        }

        $image = $request->file('foto_barang');
        $imageName = $image->getClientOriginalName();
        // dd($imageName);

        try {
            $image->move($uploadPath, $imageName);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengunggah foto barang: ' . $e->getMessage());
        }
        $harga = str_replace(['Rp.', '.'], '', $request->input('harga_barang'));

        $cek = AdminModel::InsertData('barang', [
            'nama_barang' => $request->nama_barang,
            'stok_barang' => $request->stok_barang,
            'harga_barang' => $harga,
            'deskripsi_barang' => $request->deskripsi_barang,
            'foto_barang' => $imageName,
            'id_kategori' => $request->kategori,
            'status_barang' => $request->status,
            'created_at' => Carbon::now('Asia/Jakarta'),
            'updated_at' => Carbon::now('Asia/Jakarta')
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
    public function databarangedit(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'stok_barang' => 'required|integer|min:0',
            'harga_barang' => 'required',
            'deskripsi_barang' => 'required|string|max:1000',
            'foto_barang' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
            'kategori' => 'required|integer',
            'status' => 'required',
        ]);

        $uploadPath = public_path('img/barang_img');

        // Buat direktori jika belum ada
        if (!File::isDirectory($uploadPath)) {
            File::makeDirectory($uploadPath, 0777, true, true);
        }

        $image = $request->file('foto_barang');
        $barang = AdminModel::GetDataById('barang', ['id_barang' => $id]); // Ambil data barang lama
        $imageName = $barang->foto_barang; // Default foto lama

        if ($image) {
            // Hapus foto lama jika ada
            $oldImagePath = $uploadPath . '/' . $barang->foto_barang;
            if (File::exists($oldImagePath)) {
                File::delete($oldImagePath);
            }

            // Upload foto baru
            $imageName = time() . '_' . $image->getClientOriginalName();
            try {
                $image->move($uploadPath, $imageName);
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Gagal mengunggah foto barang: ' . $e->getMessage());
            }
        }

        // Konversi harga dari format Rupiah ke angka
        $harga = str_replace(['Rp.', '.'], '', $request->input('harga_barang'));

        // Update data barang
        $where = ['id_barang' => $id];
        $updateData = [
            'nama_barang' => $request->nama_barang,
            'stok_barang' => $request->stok_barang,
            'harga_barang' => $harga,
            'deskripsi_barang' => $request->deskripsi_barang,
            'foto_barang' => $imageName,
            'id_kategori' => $request->kategori,
            'status_barang' => $request->status,
            'updated_at' => Carbon::now('Asia/Jakarta'),
        ];

        $cek = AdminModel::UpdateData('barang', $where, $updateData);

        if (!$cek) {
            return redirect()->back()->with('error', 'Gagal mengupdate barang di database. Silakan coba lagi.');
        }

        return redirect()->route('databarang')->with('success', 'Barang berhasil diperbarui.');
    }
    public function databaranghapus($id)
    {
        try {
            $where = ['id_barang' => $id];
            $barang = AdminModel::GetDataById('barang', $where);

            // Hapus file foto barang jika ada
            $fotoPath = public_path('img/barang_img/' . $barang->foto_barang);
            if (File::exists($fotoPath)) {
                File::delete($fotoPath);
            }

            AdminModel::deleteData('barang', $where);

            return response()->json(['success' => true, 'message' => 'Barang berhasil dihapus.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal menghapus barang: ' . $e->getMessage()]);
        }
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
            'kategori' => $validated['kategori'],
            'updated_at' => Carbon::now('Asia/Jakarta'), // Tambahkan timestamp jika diperlukan
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
            'alamat' => 'nullable',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $uploadPath = public_path('img/profiluser');
        if ($request->file('foto') == null) {
            User::create([
                'nama_lengkap' => $request->nama_lengkap,
                'email' => $request->email,
                'telephone' => $request->telephone,
                'alamat' => $request->alamat,
                'foto' => 'deafultpp.svg',
                'id_role' => $request->role,
                'password' => Hash::make($request->password),
                'created_at' => Carbon::now('Asia/Jakarta'),
                'updated_at' => Carbon::now('Asia/Jakarta')
            ]);
        } else {
            $image = $request->file('foto');
            $imageName = $image->getClientOriginalName();
            $image->move($uploadPath, $imageName);
            User::create([
                'nama_lengkap' => $request->nama_lengkap,
                'email' => $request->email,
                'telephone' => $request->telephone,
                'alamat' => $request->alamat,
                'foto' => $imageName,
                'id_role' => $request->role,
                'password' => Hash::make($request->password),
                'created_at' => Carbon::now('Asia/Jakarta'),
                'updated_at' => Carbon::now('Asia/Jakarta')
            ]);
        }
        return redirect()->route('datauser')->with('success', 'Tambah user berhasil!!');
    }
    public function datauserview($id)
    {
        $user = User::find($id);
        if (!$user) {
            return redirect()->route('datauser')->with('error', 'User tidak ditemukan');
        }
        return response()->json($user);
    }
    public function datauseredit(Request $request, $id)
    {
        // Validasi input form
        $validatedData = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telephone' => 'required|string|max:15',
            'role' => 'required',
            'alamat' => 'nullable',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Temukan user berdasarkan ID
        $user = User::findOrFail($id);

        // Simpan foto baru jika ada
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($user->foto && file_exists(public_path($user->foto))) {
                unlink(public_path($user->foto)); // Hapus file foto lama
            }

            // Ambil nama asli file
            $originalName = $request->file('foto')->getClientOriginalName();

            // Tentukan path penyimpanan
            $fotoPath = 'img/profiluser/' . $originalName;

            // Simpan file ke lokasi tujuan
            $request->file('foto')->move(public_path('img/profiluser'), $originalName);

            // Update path foto di database
            $user->foto = $originalName;
        }

        // Update data user lainnya
        $user->nama_lengkap = $validatedData['nama_lengkap'];
        $user->email = $validatedData['email'];
        $user->telephone = $validatedData['telephone'];
        $user->id_role = $validatedData['role'];
        $user->alamat = $validatedData['alamat'];


        // Simpan perubahan ke database
        $user->save();

        // Redirect dengan pesan sukses
        return redirect()->route('datauser')->with('success', 'User berhasil diperbarui.');
    }
    public function datauserhapus($id)
    {
        try {
            $user = User::findOrFail($id);

            // Cek apakah ada foto yang terkait
            $fotoPath = public_path('img/profiluser/' . $user->foto);
            if (File::exists($fotoPath)) {
                File::delete($fotoPath);
            }

            // Hapus data user dari database
            $user->delete();

            return response()->json(['message' => 'User deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to delete user'], 500);
        }
    }

}
