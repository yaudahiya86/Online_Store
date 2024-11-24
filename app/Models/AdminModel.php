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
}
