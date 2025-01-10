<?php

namespace App\Http\Controllers;

use App\Models\AdminModel;
use App\Models\UserModel;
use Auth;
use Illuminate\Http\Request;
use Storage;

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
    public function profil($id)
    {
        $id = [
            'id' => $id
        ];
        $data['profil'] = UserModel::GetDataById('users', $id);
        // dd($data);
        return view('user.profil', compact('data'));
    }
    public function profilgantipp(Request $request)
    {
        // Validate the uploaded file
        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Max file size: 2MB
        ]);
    
        $user = Auth::user(); // Get the currently authenticated user
        $uploadPath = public_path('img/profiluser');
        $image = $request->file('foto');
        $imageName = time() . '_' . $image->getClientOriginalName(); // Use a timestamp to prevent overwriting
    
        // Delete the old profile picture if it exists
        if ($user->foto && file_exists($uploadPath . '/' . $user->foto)) {
            unlink($uploadPath . '/' . $user->foto); // Remove the old photo
        }
    
        // Move the new photo to the server
        $image->move($uploadPath, $imageName);
    
        // Update the user's profile with the new image name
        $user->foto = $imageName;
        $user->save();
    
        return response()->json([
            'message' => 'Foto profil berhasil diperbarui!',
            'foto' => $imageName // Send the new image path for the frontend to update
        ]);
    }
    
    public function profilupdate(Request $request)
    {
        $user = auth()->user();
        $validatedData = $request->validate([
            'namaLengkap' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string',
            'alamat' => 'required|string',
        ]);

        $user->update([
            'nama_lengkap' => $validatedData['namaLengkap'],
            'email' => $validatedData['email'],
            'telephone' => $validatedData['phone'],
            'alamat' => $validatedData['alamat'],
        ]);

        return response()->json(['success' => true]);
    }
    public function detailbarang($id)
    {
        $where = [
            'id_barang' => $id
        ];
        // dd($where);
        $data['barang'] = UserModel::GetDataById('barang', $where);
        // dd($data);
        return view('user.detailbarang', compact('data'));
    }
    public function detailbarangtambahkeranjang(Request $request)
    {
        $userId = Auth::user()->id;
        $id = $request->id_barang;

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
                'total_barang_satuan' => $existingItem->total_barang_satuan + $request->total_barang_satuan
            ]);

            if ($updated) {
                return redirect()->route('detailbarang', $id)->with('success', 'Jumlah barang di keranjang berhasil diperbarui.');
            } else {
                return redirect()->route('detailbarang', $id)->with('error', 'Gagal memperbarui jumlah barang di keranjang.');
            }
        }

        // Jika barang belum ada, tambahkan ke keranjang
        $data = [
            'id_barang' => $id,
            'id_user' => $userId,
            'total_barang_satuan' => $request->total_barang_satuan // Set jumlah awal menjadi 1
        ];
        $insert = UserModel::InsertData('keranjang', $data);

        if ($insert) {
            return redirect()->route('detailbarang', $id)->with('success', 'Barang berhasil ditambahkan ke keranjang.');
        } else {
            return redirect()->route('detailbarang', $id)->with('error', 'Gagal menambahkan barang ke keranjang.');
        }
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
    public function keranjangupdate(Request $request)
    {
        return response()->json(['success' => true, 'message' => 'Keranjang diperbarui']);

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
    public function hapuskeranjang($id)
    {
        $userId = Auth::user()->id;

        // Periksa apakah barang sudah ada di keranjang
        $existingItem = UserModel::deleteData('keranjang', [
            'id_barang' => $id,
            'id_user' => $userId
        ]);
        return redirect()->route('beranda')->with('success', 'Barang berhasil ditambahkan ke keranjang.');
    }


}
