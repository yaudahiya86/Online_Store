<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserModel extends Model
{
    use HasFactory;
    public static function GetData($table)
    {
        return DB::table($table)->get();
    }
    public static function GetDataByIdGet($table, $where)
    {
        return DB::table($table)->where($where)->get();
    }
    public static function GetDataById($table, $where)
    {
        return DB::table($table)->where($where)->first();
    }
    public static function CheckDataExists($table, $conditions)
    {
        return DB::table($table)->where($conditions)->exists();
    }

    public static function InsertData($table, $data)
    {
        return DB::table($table)->insert($data);
    }
    public static function InsertDataGetId($table, $data)
    {
        return DB::table($table)->insertGetId($data);
    }

    public static function UpdateData($table, $where, $data)
    {
        return DB::table($table)->where($where)->update($data);
    }
    public static function deleteData($table, $where)
    {
        return DB::table($table)->where($where)->delete();
    }
    public static function JoinDataBarangWhere($where = [])
    {
        // Mulai query pada tabel barang dan join dengan kategori
        $query = DB::table('barang')
            ->join('kategori', 'kategori.id_kategori', '=', 'barang.id_kategori');

        // Jika ada kondisi pada where, terapkan kondisi tersebut
        if (!empty($where)) {
            $query->where($where);
        }

        // Eksekusi dan ambil hasil query
        return $query->get();
    }

    public static function JoinKeranjang($where)
    {
        return DB::table('keranjang')
            ->join('barang', 'keranjang.id_barang', '=', 'barang.id_barang')
            ->join('kategori', 'kategori.id_kategori', '=', 'barang.id_kategori')
            ->join('users', 'keranjang.id_user', '=', 'users.id')
            ->where($where)
            ->get();
    }
    public static function JoinHistoriPesanan($where)
    {
        return DB::table('pesanan')
            ->join('pembayaran', 'pembayaran.id_pesanan', '=', 'pesanan.id_pesanan')
            ->join('pengiriman', 'pengiriman.id_pesanan', '=', 'pesanan.id_pesanan')
            ->join('expedisi_pengiriman', 'expedisi_pengiriman.id_expedisi_pengiriman', '=', 'pengiriman.id_expedisi_pengiriman')
            ->where($where)
            ->select(
                'pesanan.id_pesanan',
                'pesanan.nama_lengkap',
                'pesanan.alamat',
                'pesanan.total_harga_semua',
                'pesanan.created_at',
                'pesanan.status_pesanan',
                'pembayaran.tanggal_pembayaran as tanggal_transaksi',
                'pembayaran.status_pembayaran',
                'expedisi_pengiriman.expedisi_pengiriman',
                'pengiriman.resi_pengiriman',
                'pengiriman.tanggal_pengiriman',
                'pengiriman.tanggal_menerima'
            )
            ->get();
    }
    public static function JoinDetailPesanan($where)
    {
        return DB::table('pesanan')
            ->join('list_pesanan', 'list_pesanan.id_pesanan', '=', 'pesanan.id_pesanan')
            ->join('barang', 'barang.id_barang', '=', 'list_pesanan.id_barang')
            ->join('pembayaran', 'pembayaran.id_pesanan', '=', 'pesanan.id_pesanan')
            ->where($where)
            ->get();
    }
}
