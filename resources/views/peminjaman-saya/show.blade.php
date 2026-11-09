@extends('layouts.perpustakaan')

@section('title', 'Detail Peminjaman')

@section('content')
<h2>Detail Peminjaman</h2>

<table>
    <tr>
        <th>Buku</th>
        <td>{{ $peminjaman->buku->judul ?? '-' }}</td>
    </tr>
    <tr>
        <th>Tanggal Pinjam</th>
        <td>{{ $peminjaman->tanggal_pinjam->format('d/m/Y') }}</td>
    </tr>
    <tr>
        <th>Tanggal Kembali</th>
        <td>{{ $peminjaman->tanggal_kembali?->format('d/m/Y') ?? '-' }}</td>
    </tr>
    <tr>
        <th>Status</th>
        <td>{{ $peminjaman->status_label }}</td>
    </tr>
</table>

<a href="{{ route('peminjaman-saya.index') }}" class="btn-kecil">Kembali</a>
@endsection