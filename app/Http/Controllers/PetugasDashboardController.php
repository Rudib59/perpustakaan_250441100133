<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Peminjaman;

class PetugasDashboardController extends Controller
{
    public function __invoke()
    {
        return view('petugas.dashboard', [
            'totalBuku'          => Buku::count(),
            'pengajuanPinjam'    => Peminjaman::where('status', 'diajukan')->count(),
            'pengajuanKembali'   => Peminjaman::where('status', 'pengembalian_diajukan')->count(),
            'sedangDipinjam'     => Peminjaman::where('status', 'dipinjam')->count(),
        ]);
    }
}
