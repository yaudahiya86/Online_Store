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

Route::controller(AdminController::class)->prefix('admin')->group(function () {
    Route::get('/dashboard', 'dashboard')->name('dashboard');

    Route::get('/databarang', 'databarang')->name('databarang');

    Route::get('/datakategori', 'datakategori')->name('datakategori');

    Route::get('/datapesanan', 'datapesanan')->name('datapesanan');
    Route::get('/detailpesanan', 'detailpesanan')->name('detailpesanan');

    Route::get('/datauser', 'datauser')->name('datauser');
});
