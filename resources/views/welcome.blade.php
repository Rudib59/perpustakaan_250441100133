@extends('layouts.perpustakaan')

@section('title', 'Beranda')

@section('content')

<h2>Selamat Datang di Perpustakaan</h2>

<p class="info">
    Selamat datang di Perpustakaan.
</p>

<a href="{{ route('buku.index') }}" class="btn">
    Lihat Daftar Buku
</a>


@endsection