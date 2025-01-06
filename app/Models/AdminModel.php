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
    public static function JoinPesanan($idPesanan)
{
    return DB::table('pesanan')
        ->join('pembayaran', 'pembayaran.id_pesanan', '=', 'pesanan.id_pesanan')
        ->join('list_pesanan', 'list_pesanan.id_pesanan', '=', 'pesanan.id_pesanan')
        ->join('barang', 'barang.id_barang', '=', 'list_pesanan.id_barang')
        ->join('metode_pembayaran', 'metode_pembayaran.id_metode_pembayaran', '=', 'pembayaran.id_metode_pembayaran')
        ->join('pengiriman', 'pengiriman.id_pesanan', '=', 'pesanan.id_pesanan')
        ->join('expedisi_pengiriman', 'expedisi_pengiriman.id_expedisi_pengiriman', '=', 'pengiriman.id_expedisi_pengiriman')
        ->select(
            'pesanan.id_pesanan',
            'pesanan.nama_lengkap',
            'pesanan.telephone',
            'pesanan.alamat',
            'pesanan.kode_pos',
            'pesanan.total_harga_semua',
            'pesanan.status_pesanan',
            'pesanan.created_at',
            'pembayaran.tanggal_pembayaran',
            'metode_pembayaran.metode_pembayaran',
            'pengiriman.resi_pengiriman',
            'pengiriman.tanggal_menerima',
            'expedisi_pengiriman.expedisi_pengiriman',
            'barang.nama_barang',
            'barang.harga as harga_barang',
            'list_pesanan.jumlah_barang',
            DB::raw('barang.harga * list_pesanan.jumlah_barang as total_harga'),
            'barang.kategori'
        )
        ->where('pesanan.id_pesanan', $idPesanan)
        ->get();
}


}
