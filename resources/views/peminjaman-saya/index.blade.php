@extends('layouts.perpustakaan')

@section('title', 'Peminjaman Saya')

@section('content')
<h2>Peminjaman Saya</h2>

@if (session('sukses')) <div class="sukses">{{ session('sukses') }}</div> @endif
@error('aksi') <div class="error">{{ $message }}</div> @enderror

<table>
    <thead>
        <tr>
            <th>Buku</th>
            <th>Tanggal Pinjam</th>
            <th>Tanggal Kembali</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($peminjamans as $p)
        <tr>
            <td>{{ $p->buku->judul ?? '-' }}</td>
            <td>{{ $p->tanggal_pinjam->format('d/m/Y') }}</td>
            <td>{{ $p->tanggal_kembali?->format('d/m/Y') ?? '-' }}</td>
            <td>{{ $p->status_label }}</td>
            <td>
                <a href="{{ route('peminjaman-saya.show', $p) }}" class="btn-kecil">Detail</a>
                @if ($p->status === 'dipinjam')
                <form class="inline" method="POST" action="{{ route('peminjaman-saya.kembali', $p) }}"
                    onsubmit="return confirm('Ajukan pengembalian buku ini?')">
                    @csrf @method('PATCH')
                    <button type="submit" class="btn-kecil">Ajukan Pengembalian</button>
                </form>
                @endif
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="5">Anda belum pernah meminjam buku.</td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection