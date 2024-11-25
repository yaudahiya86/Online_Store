<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Role table
        Schema::create('role', function (Blueprint $table) {
            $table->id('id_role');
            $table->string('role');
            $table->timestamps();
        });

        // Users table
        Schema::create('users', function (Blueprint $table) {
            $table->id('id');
            $table->string('nama_lengkap');
            $table->string('email')->unique();
            $table->string('telephone')->unique();
            $table->string('foto');
            $table->string('password');
            $table->unsignedBigInteger('id_role');
            $table->timestamps();

            $table->foreign('id_role')->references('id_role')->on('role')->onDelete('cascade');
        });

        // Address table
        Schema::create('alamat', function (Blueprint $table) {
            $table->id('id_alamat');
            $table->unsignedBigInteger('id_users');
            $table->text('alamat');
            $table->timestamps();

            $table->foreign('id_users')->references('id')->on('users')->onDelete('cascade');
        });

        // Category table
        Schema::create('kategori', function (Blueprint $table) {
            $table->id('id_kategori');
            $table->string('kategori');
            $table->timestamps();
        });

        // Order Status table
        Schema::create('status_barang', function (Blueprint $table) {
            $table->id('id_status_barang');
            $table->string('status_barang');
            $table->timestamps();
        });

        // Product table
        Schema::create('barang', function (Blueprint $table) {
            $table->id('id_barang');
            $table->string('nama_barang');
            $table->integer('harga_barang'); // Menggunakan integer untuk harga
            $table->text('deskripsi_barang');
            $table->integer('stok_barang');
            $table->string('foto_barang');
            $table->unsignedBigInteger('id_kategori');
            $table->unsignedBigInteger('id_status_barang');
            $table->timestamps();

            $table->foreign('id_kategori')->references('id_kategori')->on('kategori')->onDelete('cascade');
            $table->foreign('id_status_barang')->references('id_status_barang')->on('status_barang')->onDelete('cascade');
        });

         // Cart table
         Schema::create('keranjang', function (Blueprint $table) {
            $table->id('id_keranjang');
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_barang');
            $table->timestamps();

            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_barang')->references('id_barang')->on('barang')->onDelete('cascade');
        });

        // Order Status table
        Schema::create('status_pesanan', function (Blueprint $table) {
            $table->id('id_status_pesanan');
            $table->string('status_pesanan');
            $table->timestamps();
        });

        // Orders table
        Schema::create('pesanan', function (Blueprint $table) {
            $table->id('id_pesanan');
            $table->unsignedBigInteger('id_users');
            $table->integer('total_harga_semua'); // Menggunakan integer untuk total harga
            $table->unsignedBigInteger('id_status_pesanan');
            $table->timestamps();

            $table->foreign('id_users')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_status_pesanan')->references('id_status_pesanan')->on('status_pesanan')->onDelete('cascade');
        });

        // Order Items table
        Schema::create('list_pesanan', function (Blueprint $table) {
            $table->id('id_list_pesanan');
            $table->unsignedBigInteger('id_pesanan');
            $table->unsignedBigInteger('id_barang');
            $table->integer('jumlah_barang_pesanan');
            $table->integer('total_harga_satuan'); // Menggunakan integer untuk harga satuan
            $table->timestamps();

            $table->foreign('id_pesanan')->references('id_pesanan')->on('pesanan')->onDelete('cascade');
            $table->foreign('id_barang')->references('id_barang')->on('barang')->onDelete('cascade');
        });

        // Payment Methods table
        Schema::create('metode_pembayaran', function (Blueprint $table) {
            $table->id('id_metode_pembayaran');
            $table->string('metode_pembayaran');
            $table->timestamps();
        });

        // Payments table
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id('id_pembayaran');
            $table->unsignedBigInteger('id_pesanan');
            $table->unsignedBigInteger('id_metode_pembayaran');
            $table->date('tanggal_pembayaran');
            $table->timestamps();

            $table->foreign('id_pesanan')->references('id_pesanan')->on('pesanan')->onDelete('cascade');
            $table->foreign('id_metode_pembayaran')->references('id_metode_pembayaran')->on('metode_pembayaran')->onDelete('cascade');
        });

        // Shipping Companies table
        Schema::create('expedisi_pengiriman', function (Blueprint $table) {
            $table->id('id_expedisi_pengiriman');
            $table->string('expedisi_pengiriman');
            $table->timestamps();
        });

        // Shipments table
        Schema::create('pengiriman', function (Blueprint $table) {
            $table->id('id_pengiriman');
            $table->unsignedBigInteger('id_pesanan');
            $table->unsignedBigInteger('id_expedisi_pengiriman');
            $table->string('resi_pengiriman');
            $table->date('tanggal_pengiriman');
            $table->date('tanggal_menerima');
            $table->timestamps();

            $table->foreign('id_pesanan')->references('id_pesanan')->on('pesanan')->onDelete('cascade');
            $table->foreign('id_expedisi_pengiriman')->references('id_expedisi_pengiriman')->on('expedisi_pengiriman')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengiriman');
        Schema::dropIfExists('expedisi_pengiriman');
        Schema::dropIfExists('pembayaran');
        Schema::dropIfExists('metode_pembayaran');
        Schema::dropIfExists('list_pesanan');
        Schema::dropIfExists('pesanan');
        Schema::dropIfExists('status_pesanan');
        Schema::dropIfExists('barang');
        Schema::dropIfExists('kategori');
        Schema::dropIfExists('status_barang');
        Schema::dropIfExists('keranjang');
        Schema::dropIfExists('alamat');
        Schema::dropIfExists('users');
        Schema::dropIfExists('role');
    }
};
