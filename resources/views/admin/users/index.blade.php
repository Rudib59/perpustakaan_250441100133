@extends('layouts.perpustakaan')

@section('title', 'Kelola Pengguna')

@section('content')
<style>
    table {
        width: 100%;
        border-collapse: collapse;
        background: #fff;
        margin-top: 16px;
    }

    th,
    td {
        padding: 12px 16px;
        text-align: left;
        border-bottom: 1px solid #e2e8f0;
    }

    th {
        background: #f1f5f9;
    }

    .btn-kecil {
        display: inline-block;
        padding: 6px 14px;
        border-radius: 6px;
        color: #fff;
        text-decoration: none;
        border: 0;
        cursor: pointer;
        font-size: 14px;
        background: #2563eb;
    }

    .merah {
        background: #dc2626;
    }

    .sukses {
        background: #dcfce7;
        color: #166534;
        padding: 12px 16px;
        border-radius: 6px;
        margin-bottom: 16px;
    }

    .error {
        background: #fee2e2;
        color: #991b1b;
        padding: 12px 16px;
        border-radius: 6px;
        margin-bottom: 16px;
    }

    form.inline {
        display: inline;
    }
</style>

<h2>Kelola Pengguna</h2>

@if (session('sukses')) <div class="sukses">{{ session('sukses') }}</div> @endif
@error('hapus') <div class="error">{{ $message }}</div> @enderror

<a href="{{ route('admin.users.create') }}" class="btn">Tambah Pengguna</a>

<table>
    <thead>
        <tr>
            <th>Nama</th>
            <th>Email</th>
            <th>Role</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $u)
        <tr>
            <td>{{ $u->name }}</td>
            <td>{{ $u->email }}</td>
            <td>{{ $u->roles->pluck('name')->implode(', ') ?: '-' }}</td>
            <td>
                <a href="{{ route('admin.users.edit', $u) }}" class="btn-kecil">Ubah</a>
                <form class="inline" method="POST" action="{{ route('admin.users.destroy', $u) }}"
                    onsubmit="return confirm('Hapus pengguna ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-kecil merah">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection