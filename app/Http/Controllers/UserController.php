<?php

namespace App\Http\Controllers;

use App\Models\AdminModel;
use App\Models\UserModel;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
// use Log;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Midtrans\Config;
use Midtrans\Snap;

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
        // Debugging untuk melihat data yang diterima
        Log::info('Data yang diterima:', [
            'itemId' => $request->itemId,
            'quantity' => $request->quantity
        ]);

        $where = [
            'id_keranjang' => $request->itemId
        ];
        $data = [
            'total_barang_satuan' => $request->quantity
        ];

        // Pastikan metode UpdateData bekerja dengan benar
        $updated = UserModel::UpdateData('keranjang', $where, $data);

        if ($updated) {
            return response()->json(['success' => true, 'message' => 'Keranjang diperbarui']);
        }

        return response()->json(['success' => false, 'message' => 'Gagal memperbarui keranjang']);
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

    public function histori()
    {
        $data['belumdibayar'] = UserModel::JoinHistoriPesanan([
            'status_pembayaran' => 'Belum Dibayar'
        ]);
        $data['sudahdibayar'] = UserModel::JoinHistoriPesanan([
            'status_pembayaran' => 'Sudah Dibayar',
            'status_pesanan' => null,
        ]);
        $data['dikirim'] = UserModel::JoinHistoriPesanan([
            'status_pembayaran' => 'Sudah Dibayar',
            'status_pesanan' => 'Dikirim',
        ]);
        $data['selesai'] = UserModel::JoinHistoriPesanan([
            'status_pembayaran' => 'Sudah Dibayar',
            'status_pesanan' => 'Diterima',
        ]);
        // dd($data);
        return view('user.histori', compact('data'));
    }


    public function checkout()
    {
        return view('user.checkout');
    }
    public function checkoutproses(Request $request)
    {
        // Ambil semua data dari input
        $selectedItems = $request->input('selected_items', []);

        // Filter hanya barang yang dicentang
        $itemsToCheckout = collect($selectedItems)->filter(function ($item) {
            return isset($item['checked']) && $item['checked'] == 1;
        });

        // Jika tidak ada barang yang dipilih, kembalikan pesan error
        if ($itemsToCheckout->isEmpty()) {
            return redirect()->back()->with('error', 'Pilih setidaknya satu barang untuk checkout.');
        }

        // Debug untuk melihat data yang dikirim
        // dd($itemsToCheckout);
        session(['checkout_items' => $itemsToCheckout]);

        // Lanjutkan proses, seperti menyimpan ke database
        return redirect()->route('checkoutshow');
    }
    public function checkoutshow()
    {
        // Ambil data barang yang ada di session
        $checkoutItems = session('checkout_items', collect());

        // Jika data tidak ditemukan, kembali ke halaman keranjang
        if ($checkoutItems->isEmpty()) {
            return redirect()->route('keranjang')->with('error', 'Tidak ada barang untuk checkout.');
        }

        // Ambil ID barang dari checkoutItems
        $ids = $checkoutItems->pluck('id_barang')->toArray();

        // Inisialisasi array untuk menyimpan data barang dan variabel total harga
        $barangData = [];
        $totalHarga = 0;

        // Loop untuk mengambil data barang dan kategori untuk setiap ID barang
        foreach ($checkoutItems as $item) {
            $id = $item['id_barang']; // ID barang untuk tiap item
            $keranjangId = $item['id_keranjang']; // ID keranjang
            $jumlah = $item['jumlah']; // Jumlah barang

            // Ambil data nama barang, harga, foto, dan kategori berdasarkan ID barang
            $data = UserModel::JoinDataBarangWhere([
                ['barang.id_barang', '=', $id]
            ])->first(); // Menggunakan first() karena ID barang unik

            // Gabungkan data barang dengan informasi keranjang dan jumlah
            if ($data) {
                $hargaBarang = $data->harga_barang;
                $subtotal = $jumlah * $hargaBarang; // Hitung subtotal per item
                $totalHarga += $subtotal; // Tambahkan ke total harga

                $barangData[] = [
                    'id_keranjang' => $keranjangId,
                    'jumlah' => $jumlah,
                    'id_barang' => $data->id_barang,
                    'nama_barang' => $data->nama_barang,
                    'nama_kategori' => $data->kategori,
                    'foto_barang' => $data->foto_barang,
                    'harga_barang' => $hargaBarang,
                    'subtotal' => $subtotal, // Menyimpan subtotal per barang
                ];
            }
        }

        // Kirim data barang dan total harga ke view
        return view('user.checkout', compact('barangData', 'totalHarga'));
    }

    public function hapusBarangCheckout($id_keranjang)
    {
        // Ambil data checkoutItems dari session
        $checkoutItems = session('checkout_items', collect());

        // Cari item dengan id_keranjang yang sesuai
        $checkoutItems = $checkoutItems->filter(function ($item) use ($id_keranjang) {
            return $item['id_keranjang'] != $id_keranjang;
        });

        // Simpan kembali data checkoutItems ke session
        session(['checkout_items' => $checkoutItems]);

        // Kembali ke halaman checkout
        return redirect()->route('checkoutshow');
    }
    public function bayar(Request $request)
    {
        // dd($request->all());
        // Set your Merchant Server Key
        Config::$serverKey = config('midtrans.serverKey');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        Config::$isProduction = false;
        // Set sanitization on (default)
        Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        Config::$is3ds = true;
        $params = array(
            'transaction_details' => array(
                'order_id' => rand(),
                'gross_amount' => $request->total_harga_semua
            ),
            'customer_details' => array(
                'first_name' => $request->nama_lengkap,
                'phone' => $request->telephone,
            )
        );
        $snapToken = Snap::getSnapToken($params);
        $data_pesanan = [
            'nama_lengkap' => $request->nama_lengkap,
            'telephone' => $request->telephone,
            'alamat' => $request->alamat_lengkap,
            'kode_pos' => $request->kode_pos,
            'total_harga_semua' => $request->total_harga_semua,
            'created_at' => Carbon::now('asia/jakarta'),
            'updated_at' => Carbon::now('asia/jakarta'),
        ];
        $id_pesanan = UserModel::InsertDataGetId('pesanan', $data_pesanan);
        foreach ($request->barang as $barang) {
            UserModel::InsertData('list_pesanan', [
                'id_pesanan' => $id_pesanan,
                'id_barang' => $barang['id_barang'],
                'jumlah_barang_satuan' => $barang['jumlah_barang'],
                'total_harga_satuan' => $barang['total_barang_satuan'],
            ]);
            $get_barang = UserModel::GetDataById('barang', [
                'id_barang' => $barang['id_barang']
            ]);
            UserModel::UpdateData('barang', [
                'id_barang' => $barang['id_barang']
            ], [
                'stok_barang' => $get_barang->stok_barang - $barang['jumlah_barang']
            ]);
            UserModel::deleteData('keranjang', [
                'id_keranjang' => $barang['id_keranjang']
            ]);
        }
        UserModel::InsertData('pengiriman', [
            'id_expedisi_pengiriman' => $request->pengiriman,
            'id_pesanan' => $id_pesanan
        ]);
        UserModel::InsertData('pembayaran', [
            'id_pesanan' => $id_pesanan,
            'snap_token' => $snapToken,
        ]);
        return view('user.prosespembayaran', [
            'snapToken' => $snapToken,
            'total_harga_semua' => $request->total_harga_semua,
            'id_pesanan' => $id_pesanan
        ]);
    }
    public function pembayaranberhasil($id_pesanan)
    {
        $data = UserModel::UpdateData('pembayaran',[
            'id_pesanan' => $id_pesanan
        ],[
            'status_pembayaran' => 'Sudah Dibayar',
            'tanggal_pembayaran' => Carbon::now('asia/jakarta')
        ]);
        $data = UserModel::UpdateData('pesanan',[
            'id_pesanan' => $id_pesanan
        ],[
            'status_pesanan' => 'Dikirim',
        ]);
        return redirect()->route('histori')->with('success', 'Barang berhasil Dibayar, Silahkan cek pada histori pesanan');
    }
    public function userdetailpesanan($id)
    {
        $where = [
            'list_pesanan.id_pesanan' => $id
        ];
        $data = UserModel::JoinDetailPesanan($where);
        // dd($data);
        return view('user.detailpesanan', compact('data'));
    }


    public function bayarproses()
    {
        return view('user.prosespembayaran');
    }
}
