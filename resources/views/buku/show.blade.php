@extends('layouts.perpustakaan')

@section('title', 'Detail Buku')

@section('content')
<h2>Detail Buku</h2>

@if (session('sukses')) <div class="sukses">{{ session('sukses') }}</div> @endif
@error('pinjam') <div class="error">{{ $message }}</div> @enderror

<table>
    <tr>
        <th>Judul</th>
        <td>{{ $buku->judul }}</td>
    </tr>
    <tr>
        <th>Penulis</th>
        <td>{{ $buku->penulis }}</td>
    </tr>
    <tr>
        <th>Tahun Terbit</th>
        <td>{{ $buku->tahun_terbit }}</td>
    </tr>
    <tr>
        <th>Kategori</th>
        <td>{{ $buku->kategori->nama ?? '-' }}</td>
    </tr>
</table>

@can('mengajukan peminjaman buku')
<form class="inline" method="POST" action="{{ route('peminjaman-saya.store', $buku) }}">
    @csrf
    <button type="submit" class="btn" style="border:0;cursor:pointer">Ajukan Peminjaman</button>
</form>
@endcan
<a href="{{ route('buku.index') }}" class="btn-kecil">Kembali</a>
@endsection