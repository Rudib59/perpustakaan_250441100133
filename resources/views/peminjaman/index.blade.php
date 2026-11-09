@extends('layouts.perpustakaan')

@section('title', 'Peminjaman')

@section('content')
<h2>Data Peminjaman</h2>

@if (session('sukses')) <div class="sukses">{{ session('sukses') }}</div> @endif
@error('aksi') <div class="error">{{ $message }}</div> @enderror

<table>
    <thead>
        <tr>
            <th>Peminjam</th>
            <th>Buku</th>
            <th>Tanggal</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($peminjamans as $p)
        <tr>
            <td>{{ $p->nama_peminjam }}</td>
            <td>{{ $p->buku->judul ?? '-' }}</td>
            <td>{{ $p->tanggal_pinjam->format('d/m/Y') }}</td>
            <td>{{ $p->status_label }}</td>
            <td>
                @if ($p->status === 'diajukan')
                @can('memproses persetujuan peminjaman')
                <form class="inline" method="POST" action="{{ route('peminjaman.setujui', $p) }}">
                    @csrf @method('PATCH')
                    <button type="submit" class="btn-kecil">Setujui</button>
                </form>
                <form class="inline" method="POST" action="{{ route('peminjaman.tolak', $p) }}">
                    @csrf @method('PATCH')
                    <button type="submit" class="btn-kecil merah">Tolak</button>
                </form>
                @endcan
                @else
                -
                @endif
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="5">Belum ada data peminjaman.</td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection