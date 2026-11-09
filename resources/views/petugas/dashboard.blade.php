@extends('layouts.perpustakaan')

@section('title', 'Dashboard Petugas')

@section('content')
<h2>Dashboard Petugas</h2>

<div class="grid">
    <div class="stat">
        <div class="angka">{{ $totalBuku }}</div>
        <div class="label">Total Buku</div>
    </div>
    <div class="stat">
        <div class="angka">{{ $pengajuanPinjam }}</div>
        <div class="label">Pengajuan Peminjaman</div>
    </div>
    <div class="stat">
        <div class="angka">{{ $pengajuanKembali }}</div>
        <div class="label">Pengajuan Pengembalian</div>
    </div>
    <div class="stat">
        <div class="angka">{{ $sedangDipinjam }}</div>
        <div class="label">Sedang Dipinjam</div>
    </div>
</div>

<a href="{{ route('peminjaman.index') }}" class="btn">Proses Peminjaman</a>
<a href="{{ route('pengembalian.index') }}" class="btn">Proses Pengembalian</a>
<a href="{{ route('buku.index') }}" class="btn">Kelola Buku</a>
<a href="{{ route('laporan.index') }}" class="btn">Laporan</a>
@endsection