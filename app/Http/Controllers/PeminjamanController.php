<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;

class PeminjamanController extends Controller
{
    public function index()
    {
        $peminjamans = Peminjaman::with(['buku', 'user', 'anggota'])->latest()->get();

        return view('peminjaman.index', compact('peminjamans'));
    }

    public function setujui(Peminjaman $peminjaman)
    {
        if ($peminjaman->status !== 'diajukan') {
            return back()->withErrors(['aksi' => 'Pengajuan ini sudah diproses.']);
        }

        $peminjaman->update([
            'status'         => 'dipinjam',
            'tanggal_pinjam' => now()->toDateString(),
        ]);

        return back()->with('sukses', 'Peminjaman disetujui.');
    }

    public function tolak(Peminjaman $peminjaman)
    {
        if ($peminjaman->status !== 'diajukan') {
            return back()->withErrors(['aksi' => 'Pengajuan ini sudah diproses.']);
        }

        $peminjaman->update(['status' => 'ditolak']);

        return back()->with('sukses', 'Peminjaman ditolak.');
    }
}
