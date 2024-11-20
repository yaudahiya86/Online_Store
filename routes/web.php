<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('login');
});

Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
Route::get('/admin/databarang', [AdminController::class, 'databarang'])->name('databarang');
Route::get('/admin/datakategori', [AdminController::class, 'datakategori'])->name('datakategori');
Route::get('/admin/datapesanan', [AdminController::class, 'datapesanan'])->name('datapesanan');
Route::get('/admin/datauser', [AdminController::class, 'datauser'])->name('datauser');
