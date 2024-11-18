<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/admin/global.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/sidebar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/databarang.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/datakategori.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/datapesanan.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/datauser.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <nav>
            <div class="hamburger">
                <i class="fas fa-bars buka"></i>
                <i class="fas fa-times tutup" style="display: none;"></i>
            </div>
            <div class="profil">
                <img src="{{ asset('img/deafultprofil/deafult.png') }}" alt="profil" class="profil">
            </div>
        </nav>
        <div class="sidebar">
            <a href="{{ route('dashboard') }}" class="side-list {{ Request::routeIs('dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
            <a href="{{ route('databarang') }}" class="side-list {{ Request::routeIs('databarang') ? 'active' : '' }}">
                <i class="fas fa-box"></i> Data Barang
            </a>
            <a href="{{ route('datakategori') }}" class="side-list {{ Request::routeIs('datakategori') ? 'active' : '' }}">
                <i class="fas fa-tags"></i> Data Kategori
            </a>
            <a href="{{ route('datapesanan') }}" class="side-list {{ Request::routeIs('datapesanan') ? 'active' : '' }}">
                <i class="fas fa-shopping-cart"></i> Data Pesanan
            </a>
            <a href="{{ route('datauser') }}" class="side-list {{ Request::routeIs('datauser') ? 'active' : '' }}">
                <i class="fas fa-users"></i> Data User
            </a>
        </div>
    </header>
    <section class="home">