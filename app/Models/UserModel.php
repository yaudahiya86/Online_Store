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
        return \DB::table($table)->where($conditions)->exists();
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
    public static function JoinKeranjang($where)
    {
        return DB::table('keranjang')
        ->join('barang', 'keranjang.id_barang', '=', 'barang.id_barang') 
        ->join('kategori', 'kategori.id_kategori', '=', 'barang.id_kategori') 
        ->join('users', 'keranjang.id_user', '=', 'users.id')
        ->where($where)
        ->get();
    }
}
