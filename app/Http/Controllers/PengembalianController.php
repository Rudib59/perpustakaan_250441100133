<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;

class PengembalianController extends Controller
{
    public function index()
    {
        // Pengajuan dari siswa ditampilkan paling atas
        $dipinjam = Peminjaman::with(['buku', 'user', 'anggota'])
            ->whereIn('status', ['dipinjam', 'pengembalian_diajukan'])
            ->latest()->get()
            ->sortByDesc(fn($p) => $p->status === 'pengembalian_diajukan')
            ->values();

        $dikembalikan = Peminjaman::with(['buku', 'user', 'anggota'])
            ->where('status', 'dikembalikan')->latest('tanggal_kembali')->get();

        return view('pengembalian.index', compact('dipinjam', 'dikembalikan'));
    }

    public function store(Peminjaman $peminjaman)
    {
        if (! in_array($peminjaman->status, ['dipinjam', 'pengembalian_diajukan'])) {
            return back()->withErrors(['aksi' => 'Buku ini tidak sedang dipinjam.']);
        }

        $peminjaman->update([
            'status'          => 'dikembalikan',
            'tanggal_kembali' => now()->toDateString(),
        ]);

        return back()->with('sukses', 'Pengembalian dicatat.');
    }
}
