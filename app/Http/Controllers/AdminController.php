<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view("admin.dashboard");
    }
    public function databarang()
    {
        return view("admin.databarang");
    }
    public function datakategori()
    {
        return view("admin.datakategori");
    }
    public function datauser()
    {
        return view("admin.datauser");
    }
}
