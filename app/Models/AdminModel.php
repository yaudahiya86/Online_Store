<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AdminModel extends Model
{
    use HasFactory;
    public static function GetData($table)
    {
        return DB::table($table)->get();
    }
    public static function GetDataById($table, $where)
    {
        return DB::table($table)->where($where)->first();
    }
    public static function InsertData($table, $data)
    {
        return DB::table($table)->insert($data);
    }
    public static function UpdateData($table, $where, $data)
    {
        return DB::table($table)->where($where)->update($data);
    }
    public static function deleteData($table, $where)
    {
        return DB::table($table)->where($where)->delete();
    }
    public static function JoinDataBarang()
    {
        return DB::table('barang')
            ->join('kategori', 'kategori.id_kategori', '=', 'barang.id_kategori')
            ->get();
    }
    public static function JoinDataBarangById($where)
    {
        return DB::table('barang')->where('id_barang', $where)
            ->join('kategori', 'kategori.id_kategori', '=', 'barang.id_kategori')
            ->first();
    }
    public static function JoinUser()
    {
        return DB::table('users')
            ->join('role', 'role.id_role', '=', 'users.id_role')
            ->get();
    }
    public static function getJoinPesanan()
    {
        // Query untuk mendapatkan data pesanan utama
        return DB::table('pesanan')
            ->join('pengiriman', 'pengiriman.id_pesanan', '=', 'pesanan.id_pesanan')
            ->join('pembayaran', 'pembayaran.id_pesanan', '=', 'pesanan.id_pesanan')
            ->join('metode_pembayaran', 'metode_pembayaran.id_metode_pembayaran', '=', 'pembayaran.id_metode_pembayaran')
            ->join('expedisi_pengiriman', 'expedisi_pengiriman.id_expedisi_pengiriman', '=', 'pengiriman.id_expedisi_pengiriman')
            ->select(
                'pesanan.*',
                'pengiriman.resi_pengiriman',
                'pengiriman.tanggal_pengiriman',
                'pengiriman.tanggal_menerima',
                'expedisi_pengiriman.expedisi_pengiriman',
                'pembayaran.tanggal_pembayaran',
                'metode_pembayaran.metode_pembayaran'
            )
            ->get();
    }
    public static function getDetailPesananFirst($idPesanan)
    {
        // Query untuk mendapatkan data pesanan utama
        $pesanan = DB::table('pesanan')
            ->join('pengiriman', 'pengiriman.id_pesanan', '=', 'pesanan.id_pesanan')
            ->join('pembayaran', 'pembayaran.id_pesanan', '=', 'pesanan.id_pesanan')
            ->join('metode_pembayaran', 'metode_pembayaran.id_metode_pembayaran', '=', 'pembayaran.id_metode_pembayaran')
            ->join('expedisi_pengiriman', 'expedisi_pengiriman.id_expedisi_pengiriman', '=', 'pengiriman.id_expedisi_pengiriman')
            ->where('pesanan.id_pesanan', $idPesanan)
            ->select(
                'pesanan.*',
                'pengiriman.resi_pengiriman',
                'pengiriman.tanggal_pengiriman',
                'pengiriman.tanggal_menerima',
                'expedisi_pengiriman.expedisi_pengiriman',
                'pembayaran.tanggal_pembayaran',
                'metode_pembayaran.metode_pembayaran'
            )
            ->first();

        // Query untuk mendapatkan daftar barang dalam pesanan
        $barang = DB::table('list_pesanan')
            ->join('barang', 'barang.id_barang', '=', 'list_pesanan.id_barang')
            ->join('kategori', 'kategori.id_kategori', '=', 'barang.id_kategori')
            ->where('list_pesanan.id_pesanan', $idPesanan)
            ->select(
                'barang.nama_barang',
                'barang.harga_barang',
                'list_pesanan.jumlah_barang_satuan',
                'list_pesanan.total_harga_satuan',
                'kategori.kategori'
            )
            ->get();

        // Mengembalikan data dalam format array
        return [
            'pesanan' => $pesanan,
            'barang' => $barang
        ];
    }
}
