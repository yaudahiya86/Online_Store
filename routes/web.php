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
        Route::post('/databarang/tambah', 'databarangtambah')->name('databarangtambah');
        Route::get('/databarang/view/{id}', 'databarangview')->name('databarangview');
        Route::put('/databarang/edit/{id}', 'databarangedit')->name('databarangedit');
        Route::delete('/databarang/hapus/{id}', 'databaranghapus')->name('databaranghapus');


        Route::get('/datakategori', 'datakategori')->name('datakategori');
        Route::post('/datakategori/tambah', 'datakategoritambah')->name('datakategoritambah');
        Route::get('/datakategori/edit/{id}', 'datakategoriedit')->name('datakategoriedit');
        Route::put('datakategori/update/${id}', 'datakategoriupdate')->name('datakategoriupdate');
        Route::delete('/datakategori/hapus{id}', 'datakategorihapus')->name('datakategorihapus');
        
        Route::get('/dataexpedisi', 'dataexpedisi')->name('dataexpedisi');
        Route::post('/dataexpedisi/tambah', 'dataexpedisitambah')->name('dataexpedisitambah');
        Route::get('/dataexpedisi/edit/{id}', 'dataexpedisiedit')->name('dataexpedisiedit');
        Route::put('dataexpedisi/update/${id}', 'dataexpedisiupdate')->name('dataexpedisiupdate');
        Route::delete('/dataexpedisi/hapus{id}', 'dataexpedisihapus')->name('dataexpedisihapus');


        Route::get('/datapesanan', 'datapesanan')->name('datapesanan');


        Route::get('/detailpesanan/{id}', 'detailpesanan')->name('detailpesanan');
        Route::post('/masukkanresi/{id}', 'masukkanresi')->name('masukkanresi');


        Route::get('/datauser', 'datauser')->name('datauser');
        Route::post('/datauser/tambah', 'datausertambah')->name('datausertambah');
        Route::get('/datauser/view/{id}', 'datauserview')->name('datauserview');
        Route::put('/datauser/edit/{id}', 'datauseredit')->name('datauseredit');
        Route::delete('/datauser/hapus/{id}', 'datauserhapus')->name('datauserhapus');
    });


Route::controller(AdminController::class)
    ->middleware('auth')
    ->group(function () {
        Route::get('/beranda', [UserController::class, 'beranda'])->name('beranda');

        Route::get('/detailbarang/{id}', [UserController::class, 'detailbarang'])->name('detailbarang');
        Route::post('/detailbarang/tambahkeranjang', [UserController::class, 'detailbarangtambahkeranjang'])->name('detailbarangtambahkeranjang');

        Route::get('/keranjang', [UserController::class, 'keranjang'])->name('keranjang');
        Route::post('/keranjang/update', [UserController::class, 'keranjangupdate'])->name('keranjangupdate');
        Route::get('/keranjang/tambah/{id}', [UserController::class, 'tambahkeranjang'])->name('tambahkeranjang');
        Route::delete('/keranjang/hapus/{id}', [UserController::class, 'hapuskeranjang'])->name('hapuskeranjang');

        Route::get('/profil/{id}', [UserController::class, 'profil'])->name('profil');
        Route::post('/profil/gantipp', [UserController::class, 'profilgantipp'])->name('profilgantipp');
        Route::post('/profil/update', [UserController::class, 'profilupdate'])->name('profilupdate');

        Route::get('/histori', [UserController::class, 'histori'])->name('histori');
        Route::get('/user/detailpesanan/{id}', [UserController::class, 'userdetailpesanan'])->name('userdetailpesanan');

        Route::get('/checkout', [UserController::class, 'checkout'])->name('checkout');
        Route::post('/checkout/proses', [UserController::class, 'checkoutproses'])->name('checkoutproses');
        Route::get('/checkout/show', [UserController::class, 'checkoutshow'])->name('checkoutshow');
        Route::get('/checkout/hapus/{id_keranjang}', [UserController::class, 'hapusBarangCheckout'])->name('checkout.hapus');
        Route::post('/bayar', [UserController::class, 'bayar'])->name('bayar');
        Route::get('/bayar/proses', [UserController::class, 'bayarproses'])->name('bayarproses');
        Route::get('/pembayaranberhasil/{id_pesanan}', [UserController::class, 'pembayaranberhasil'])->name('pembayaranberhasil');
        Route::get('/pesananditerima/{id}', [UserController::class, 'pesananditerima'])->name('pesananditerima');
        Route::get('/bayarnanti/{id}', [UserController::class, 'bayarnanti'])->name('bayarnanti');
    });

