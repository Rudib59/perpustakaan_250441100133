<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Gate;
use App\Models\Peminjaman;

class PeminjamanController extends Controller
{
    public function index()
    {
        $peminjamans = Peminjaman::with(['buku', 'user', 'anggota'])->latest()->get();

        return view('peminjaman.index', compact('peminjamans'));
    }
    // RENTAN (A4): tidak ada pemeriksaan pemilik, siapa pun yang login
    // bisa melihat peminjaman siapa pun hanya dengan menebak id
    public function show($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        Gate::authorize('view', $peminjaman);

        $peminjaman->load(['buku', 'user', 'anggota']);

        return view('peminjaman.show', compact('peminjaman'));
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
