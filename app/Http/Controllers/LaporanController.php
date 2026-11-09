<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'dari'   => ['nullable', 'date'],
            'sampai' => ['nullable', 'date', 'after_or_equal:dari'],
        ]);

        $query = Peminjaman::with(['buku', 'user', 'anggota'])->latest('tanggal_pinjam');

        if ($request->filled('dari')) {
            $query->whereDate('tanggal_pinjam', '>=', $request->dari);
        }
        if ($request->filled('sampai')) {
            $query->whereDate('tanggal_pinjam', '<=', $request->sampai);
        }

        $data = $query->get();

        $ringkasan = [
            'total'        => $data->count(),
            'diajukan'     => $data->where('status', 'diajukan')->count(),
            'dipinjam'     => $data->where('status', 'dipinjam')->count(),
            'dikembalikan' => $data->where('status', 'dikembalikan')->count(),
            'ditolak'      => $data->where('status', 'ditolak')->count(),
            'menunggu'     => $data->where('status', 'pengembalian_diajukan')->count(),
        ];

        return view('laporan.index', compact('data', 'ringkasan'));
    }
}
