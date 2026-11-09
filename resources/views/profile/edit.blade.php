@extends('layouts.perpustakaan')

@section('title', 'Profil')

@section('content')
<style>
    .kartu {
        background: #fff;
        border-radius: 8px;
        padding: 24px;
        margin-bottom: 24px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, .08);
    }

    .kartu h3 {
        color: #1e3a8a;
        margin-bottom: 16px;
    }

    .kartu label {
        display: block;
        margin: 12px 0 4px;
        font-weight: 700;
    }

    .kartu input {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        font-size: 16px;
    }

    .kartu .btn {
        margin-top: 16px;
        border: 0;
        cursor: pointer;
        font-size: 16px;
        padding: 12px 24px;
    }

    .btn-merah {
        background: #dc2626;
    }

    .error {
        color: #dc2626;
        font-size: 14px;
        margin-top: 4px;
    }

    .sukses {
        color: #16a34a;
        margin-left: 12px;
    }
</style>

<h2>Pengaturan Profil</h2>

{{-- 1. Informasi profil --}}
<div class="kartu">
    <h3>Informasi Profil</h3>
    <form method="POST" action="{{ route('profile.update') }}">
        @csrf
        @method('PATCH')

        <label for="name">Nama</label>
        <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" required>
        @error('name') <div class="error">{{ $message }}</div> @enderror

        <label for="email">Email</label>
        <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required>
        @error('email') <div class="error">{{ $message }}</div> @enderror

        <button type="submit" class="btn">Simpan</button>
        @if (session('status') === 'profile-updated')
        <span class="sukses">Tersimpan.</span>
        @endif
    </form>
</div>

{{-- 2. Ubah password --}}
<div class="kartu">
    <h3>Ubah Password</h3>
    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        @method('PUT')

        <label for="current_password">Password Saat Ini</label>
        <input id="current_password" type="password" name="current_password" autocomplete="current-password">
        @error('current_password', 'updatePassword') <div class="error">{{ $message }}</div> @enderror

        <label for="password">Password Baru</label>
        <input id="password" type="password" name="password" autocomplete="new-password">
        @error('password', 'updatePassword') <div class="error">{{ $message }}</div> @enderror

        <label for="password_confirmation">Konfirmasi Password Baru</label>
        <input id="password_confirmation" type="password" name="password_confirmation" autocomplete="new-password">
        @error('password_confirmation', 'updatePassword') <div class="error">{{ $message }}</div> @enderror

        <button type="submit" class="btn">Simpan</button>
        @if (session('status') === 'password-updated')
        <span class="sukses">Tersimpan.</span>
        @endif
    </form>
</div>

{{-- 3. Hapus akun --}}
<div class="kartu">
    <h3>Hapus Akun</h3>
    <p>Semua data akun akan dihapus permanen.</p>
    <form method="POST" action="{{ route('profile.destroy') }}"
        onsubmit="return confirm('Yakin ingin menghapus akun?')">
        @csrf
        @method('DELETE')

        <label for="hapus_password">Password</label>
        <input id="hapus_password" type="password" name="password" placeholder="Masukkan password untuk konfirmasi">
        @error('password', 'userDeletion') <div class="error">{{ $message }}</div> @enderror

        <button type="submit" class="btn btn-merah">Hapus Akun</button>
    </form>
</div>
@endsection