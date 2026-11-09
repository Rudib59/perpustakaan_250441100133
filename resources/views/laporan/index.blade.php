@extends('layouts.perpustakaan')

@section('title', 'Laporan')

@section('content')
<h2>Laporan Perpustakaan</h2>

<form method="GET" action="{{ route('laporan.index') }}" class="filter">
    <label>Dari <input type="date" name="dari" value="{{ request('dari') }}"></label>
    <label>Sampai <input type="date" name="sampai" value="{{ request('sampai') }}"></label>
    <button type="submit" class="btn-kecil">Tampilkan</button>
    <a href="{{ route('laporan.index') }}" class="btn-kecil">Reset</a>
</form>
@error('sampai') <div class="error" style="margin-top:12px">{{ $message }}</div> @enderror

<div class="grid" style="margin-top:24px">
    <div class="stat">
        <div class="angka">{{ $ringkasan['total'] }}</div>
        <div class="label">Total</div>
    </div>
    <div class="stat">
        <div class="angka">{{ $ringkasan['diajukan'] }}</div>
        <div class="label">Diajukan</div>
    </div>
    <div class="stat">
        <div class="angka">{{ $ringkasan['dipinjam'] }}</div>
        <div class="label">Dipinjam</div>
    </div>
    <div class="stat">
        <div class="angka">{{ $ringkasan['menunggu'] }}</div>
        <div class="label">Menunggu Pengembalian</div>
    </div>
    <div class="stat">
        <div class="angka">{{ $ringkasan['dikembalikan'] }}</div>
        <div class="label">Dikembalikan</div>
    </div>
    <div class="stat">
        <div class="angka">{{ $ringkasan['ditolak'] }}</div>
        <div class="label">Ditolak</div>
    </div>
</div>

<table>
    <thead>
        <tr>
            <th>Peminjam</th>
            <th>Buku</th>
            <th>Tanggal Pinjam</th>
            <th>Tanggal Kembali</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($data as $p)
        <tr>
            <td>{{ $p->nama_peminjam }}</td>
            <td>{{ $p->buku->judul ?? '-' }}</td>
            <td>{{ $p->tanggal_pinjam->format('d/m/Y') }}</td>
            <td>{{ $p->tanggal_kembali?->format('d/m/Y') ?? '-' }}</td>
            <td>{{ $p->status_label }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="5">Tidak ada data pada rentang ini.</td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection