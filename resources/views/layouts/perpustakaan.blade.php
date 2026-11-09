<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Perpustakaan') - Perpustakaan</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #f8fafc;
            color: #1e293b;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        header {
            background: linear-gradient(135deg, #1e3a8a, #2563eb);
            color: #fff;
            padding: 48px 26px;
        }

        header h1 {
            font-size: 40px;
            letter-spacing: 1px;
        }

        nav {
            background: #fff;
            padding: 26px 24px;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 44px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .08);
        }

        nav a,
        nav span,
        nav button {
            color: #1e293b;
            font-family: inherit;
            font-size: 18px;
            font-weight: 700;
            text-decoration: none;
            background: none;
            border: 0;
            cursor: pointer;
        }

        main {
            flex: 1;
            width: 100%;
            max-width: 1320px;
            margin: 48px auto;
            padding: 0 24px;
        }

        main h2 {
            font-size: 36px;
            color: #1e3a8a;
            margin-bottom: 24px;
        }

        .info {
            background: #fff;
            border-left: 4px solid #2563eb;
            border-radius: 8px;
            padding: 16px 24px;
            color: #64748b;
            margin-bottom: 32px;
        }

        .btn {
            display: inline-block;
            background: #2563eb;
            color: #fff;
            font-size: 18px;
            font-weight: 700;
            padding: 18px 28px;
            border-radius: 8px;
            text-decoration: none;
        }

        footer {
            background: #0f172a;
            color: #e2e8f0;
            text-align: center;
            padding: 36px 24px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            margin: 16px 0 32px;
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

        h3 {
            color: #1e3a8a;
            margin-top: 24px;
        }

        .btn-kecil {
            display: inline-block;
            padding: 6px 14px;
            border-radius: 6px;
            color: #fff;
            background: #2563eb;
            border: 0;
            cursor: pointer;
            font-size: 14px;
            text-decoration: none;
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

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }

        .stat {
            background: #fff;
            border-left: 4px solid #2563eb;
            border-radius: 8px;
            padding: 20px;
        }

        .stat .angka {
            font-size: 28px;
            font-weight: 700;
            color: #1e3a8a;
        }

        .stat .label {
            color: #64748b;
        }

        .filter input {
            padding: 8px 10px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            font-size: 16px;
        }
    </style>
</head>

<body>
    <header>
        <h1>Perpustakaan</h1>
    </header>

    <nav>
        <a href="{{ route('home') }}">Beranda</a>
        <a href="{{ route('buku.index') }}">Daftar Buku</a>
        @role('siswa')
        <a href="{{ route('peminjaman-saya.index') }}">Peminjaman Saya</a>
        @endrole
        @can('akses dashboard admin')
        <a href="{{ route('admin.dashboard') }}">Dashboard Admin</a>
        @endcan
        @can('akses dashboard petugas')
        <a href="{{ route('petugas.dashboard') }}">Dashboard Petugas</a>
        @endcan
        @can('kelola data pengguna')
        <a href="{{ route('admin.users.index') }}">Kelola Pengguna</a>
        @endcan
        @can('kelola peminjaman')
        <a href="{{ route('peminjaman.index') }}">Peminjaman</a>
        @endcan
        @can('kelola pengembalian')
        <a href="{{ route('pengembalian.index') }}">Pengembalian</a>
        @endcan
        @can('lihat laporan perpustakaan')
        <a href="{{ route('laporan.index') }}">Laporan</a>
        @endcan

        @auth
        <a href="{{ route('profile.edit') }}">{{ Auth::user()->name }}</a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit">Logout</button>
        </form>
        @else
        <a href="{{ route('login') }}">Login</a>
        <a href="{{ route('register') }}">Register</a>
        @endauth
    </nav>

    <main>
        @yield('content')
    </main>

    <footer>
        rudib6929@gmail.com
    </footer>
</body>

</html>

