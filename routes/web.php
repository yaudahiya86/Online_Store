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

Route::get('/', [AuthController::class, 'login'])->name('login');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login/submit', [AuthController::class, 'loginsubmit'])->name('loginsubmit');
Route::post('/register/submit', [AuthController::class, 'registersubmit'])->name('registersubmit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::controller(AdminController::class)
    ->prefix('admin')
    ->middleware('auth') // Menambahkan middleware auth
    ->group(function () {
        Route::get('/dashboard', 'dashboard')->name('dashboard');


        Route::get('/databarang', 'databarang')->name('databarang');


        Route::get('/datakategori', 'datakategori')->name('datakategori');
        Route::post('/datakategori/tambah', 'datakategoritambah')->name('datakategoritambah');
        Route::get('/datakategori/edit/{id}', 'datakategoriedit')->name('datakategoriedit');
        Route::put('/datakategori/update/{id}', 'datakategoriupdate')->name('datakategoriupdate');

        Route::delete('/datakategori/hapus{id}', 'datakategorihapus')->name('datakategorihapus');


        Route::get('/datapesanan', 'datapesanan')->name('datapesanan');


        Route::get('/detailpesanan', 'detailpesanan')->name('detailpesanan');


        Route::get('/datauser', 'datauser')->name('datauser');
    });
