@extends('layouts.perpustakaan')

@section('title', 'Detail Peminjaman')

@section('content')
<div style="max-width: 700px; margin: 0 auto; padding: 24px 16px;">
    <h2>Detail Peminjaman #{{ $peminjaman->id }}</h2>

    <table class="buku-tabel" style="width:100%; border-collapse: collapse; background:#fff; margin-top:16px;">
        <tr>
            <th style="text-align:left; padding:10px; border:1px solid #e2e8f0;">Buku</th>
            <td style="padding:10px; border:1px solid #e2e8f0;">{{ $peminjaman->buku->judul ?? '-' }}</td>
        </tr>
        <tr>
            <th style="text-align:left; padding:10px; border:1px solid #e2e8f0;">Peminjam</th>
            <td style="padding:10px; border:1px solid #e2e8f0;">{{ $peminjaman->nama_peminjam }}</td>
        </tr>
        <tr>
            <th style="text-align:left; padding:10px; border:1px solid #e2e8f0;">Email</th>
            <td style="padding:10px; border:1px solid #e2e8f0;">{{ $peminjaman->user->email ?? '-' }}</td>
        </tr>
        <tr>
            <th style="text-align:left; padding:10px; border:1px solid #e2e8f0;">Status</th>
            <td style="padding:10px; border:1px solid #e2e8f0;">{{ $peminjaman->status_label }}</td>
        </tr>
        <tr>
            <th style="text-align:left; padding:10px; border:1px solid #e2e8f0;">Tanggal Pinjam</th>
            <td style="padding:10px; border:1px solid #e2e8f0;">{{ $peminjaman->tanggal_pinjam }}</td>
        </tr>
        <tr>
            <th style="text-align:left; padding:10px; border:1px solid #e2e8f0;">Tanggal Kembali</th>
            <td style="padding:10px; border:1px solid #e2e8f0;">{{ $peminjaman->tanggal_kembali ?? '-' }}</td>
        </tr>
    </table>
</div>
@endsection