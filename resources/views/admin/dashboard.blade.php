@extends('layout.admin.app')
@section('title', 'Dashboard')
@section('content')
    <div class="dashboard">
        <div class="row-user">
            <div class="col">
                <div class="col-header">
                    <i class="fas fa-user"></i>
                </div>
                <div class="col-body">
                    10 Data User
                </div>
            </div>
            <div class="col">
                <div class="col-header">
                    <i class="fas fa-user"></i>
                </div>
                <div class="col-body">
                    10 Data Admin
                </div>
            </div>
        </div>
        <br>
        <div class="row-barang">
            <div class="col">
                <div class="col-header">
                    <i class="fas fa-box"></i>
                </div>
                <div class="col-body">
                    10 Total Barang
                </div>
            </div>
            <div class="col">
                <div class="col-header">
                    <i class="fas fa-tags"></i>
                </div>
                <div class="col-body">
                    10 Total Kategori
                </div>
            </div>
        </div>
        <br>
        <div class="row-pesanan">
            <div class="col">
                <div class="col-header">
                    <i class="fas fa-box"></i>
                </div>
                <div class="col-body">
                    10 Dikemas
                </div>
            </div>
            <div class="col">
                <div class="col-header">
                    <i class="fas fa-truck"></i>
                </div>
                <div class="col-body">
                    10 Dikirim
                </div>
            </div>
            <div class="col">
                <div class="col-header">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="col-body">
                    10 Selesai
                </div>
            </div>            
        </div>
        <br>
    </div>
@endsection
