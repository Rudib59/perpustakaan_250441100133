@extends('layouts.perpustakaan')

@section('title', 'Pengembalian')

@section('content')
<h2>Pengembalian Buku</h2>

@if (session('sukses')) <div class="sukses">{{ session('sukses') }}</div> @endif
@error('aksi') <div class="error">{{ $message }}</div> @enderror

<h3>Sedang Dipinjam</h3>
<table>
    <thead>
        <tr>
            <th>Peminjam</th>
            <th>Buku</th>
            <th>Tanggal Pinjam</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($dipinjam as $p)
        <tr>
            <td>{{ $p->nama_peminjam }}</td>
            <td>{{ $p->buku->judul ?? '-' }}</td>
            <td>{{ $p->tanggal_pinjam->format('d/m/Y') }}</td>
            <td>{{ $p->status_label }}</td>
            <td>
                @can('mencatat pengembalian buku')
                <form class="inline" method="POST" action="{{ route('pengembalian.store', $p) }}"
                    onsubmit="return confirm('Catat buku ini sudah dikembalikan?')">
                    @csrf @method('PATCH')
                    <button type="submit" class="btn-kecil">Catat Pengembalian</button>
                </form>
                @endcan
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="5">Tidak ada buku yang sedang dipinjam.</td>
        </tr>
        @endforelse
    </tbody>
</table>

<h3>Sudah Dikembalikan</h3>
<table>
    <thead>
        <tr>
            <th>Peminjam</th>
            <th>Buku</th>
            <th>Tanggal Pinjam</th>
            <th>Tanggal Kembali</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($dikembalikan as $p)
        <tr>
            <td>{{ $p->nama_peminjam }}</td>
            <td>{{ $p->buku->judul ?? '-' }}</td>
            <td>{{ $p->tanggal_pinjam->format('d/m/Y') }}</td>
            <td>{{ $p->tanggal_kembali?->format('d/m/Y') ?? '-' }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="4">Belum ada pengembalian.</td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection