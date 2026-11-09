@extends('layouts.perpustakaan')

@section('title', 'Dashboard Admin')

@section('content')
<style>
    .grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 16px;
        margin-bottom: 32px;
    }

    .stat {
        background: #fff;
        border-left: 4px solid #2563eb;
        border-radius: 8px;
        padding: 20px;
    }

    .stat .angka {
        font-size: 32px;
        font-weight: 700;
        color: #1e3a8a;
    }

    .stat .label {
        color: #64748b;
    }
</style>

<h2>Dashboard Admin</h2>

<div class="grid">
    <div class="stat">
        <div class="angka">{{ $totalBuku }}</div>
        <div class="label">Total Buku</div>
    </div>
    <div class="stat">
        <div class="angka">{{ $totalPengguna }}</div>
        <div class="label">Total Pengguna</div>
    </div>
    <div class="stat">
        <div class="angka">{{ $totalAdmin }}</div>
        <div class="label">Admin</div>
    </div>
    <div class="stat">
        <div class="angka">{{ $totalPetugas }}</div>
        <div class="label">Petugas</div>
    </div>
    <div class="stat">
        <div class="angka">{{ $totalSiswa }}</div>
        <div class="label">Siswa</div>
    </div>
</div>

<a href="{{ route('admin.users.index') }}" class="btn">Kelola Pengguna</a>
<a href="{{ route('buku.index') }}" class="btn">Kelola Buku</a>
@endsection