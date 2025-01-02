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
            $table->string('alamat');
            $table->string('password');
            $table->unsignedBigInteger('id_role');
            $table->timestamps();

            $table->foreign('id_role')->references('id_role')->on('role')->onDelete('cascade');
        });

        // Category table
        Schema::create('kategori', function (Blueprint $table) {
            $table->id('id_kategori');
            $table->string('kategori');
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
            $table->enum('status_barang', ['Aktif', 'Tidak Aktif']);
            $table->timestamps();

            $table->foreign('id_kategori')->references('id_kategori')->on('kategori')->onDelete('cascade');
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

        // Orders table
        Schema::create('pesanan', function (Blueprint $table) {
            $table->id('id_pesanan');
            $table->string('nama_lengkap');
            $table->string('telephone');
            $table->string('alamat');
            $table->string('kode_pos');
            $table->integer('total_harga_semua'); // Menggunakan integer untuk total harga
            $table->enum('status_pesanan', ['Dikemas', 'Dikirim', 'diterima']);
            $table->timestamps();
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
            $table->timestamp('tanggal_pembayaran')->nullable();

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
            $table->timestamp('tanggal_pengiriman')->nullable();
            $table->timestamp('tanggal_menerima')->nullable();

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
        Schema::dropIfExists('barang');
        Schema::dropIfExists('kategori');
        Schema::dropIfExists('keranjang');
        Schema::dropIfExists('users');
        Schema::dropIfExists('role');
    }
};
