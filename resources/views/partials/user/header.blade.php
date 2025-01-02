<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/user/navbar.css') }}">
</head>

<body>
<nav>
    <h1 class="brand">Fresh Flower</h1>
    <input type="search" placeholder="Search..." class="search-box">
    <div class="profile-menu">
        <img src="{{ asset('img/deafultprofil/deafult.png') }}" alt="foto profil">
        <ul class="menu">
            <li><a href="#"><i class="fas fa-shopping-cart"></i> Keranjang</a></li>
            <li><a href="#"><i class="fas fa-user"></i> Profil</a></li>
            <li><a href="#"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </div>
</nav>
