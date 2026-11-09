<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class PeminjamanSayaController extends Controller
{
    // Status dan riwayat: hanya milik pengguna yang login
    public function index(Request $request)
    {
        $peminjamans = Peminjaman::with('buku')
            ->where('user_id', $request->user()->id)
            ->latest()
            ->get();

        return view('peminjaman-saya.index', compact('peminjamans'));
    }
    public function ajukanPengembalian(Request $request, Peminjaman $peminjaman)
    {
        abort_unless($peminjaman->user_id === $request->user()->id, 403);

        if ($peminjaman->status !== 'dipinjam') {
            return back()->withErrors(['aksi' => 'Hanya buku yang sedang dipinjam yang dapat diajukan pengembaliannya.']);
        }

        $peminjaman->update(['status' => 'pengembalian_diajukan']);

        return back()->with('sukses', 'Pengajuan pengembalian terkirim. Serahkan buku kepada petugas.');
    }
    // Ajukan peminjaman atas nama pengguna yang login
    public function store(Request $request, Buku $buku)
    {
        $sudah = Peminjaman::where('user_id', $request->user()->id)
            ->where('buku_id', $buku->id)
            ->whereIn('status', ['diajukan', 'dipinjam'])
            ->exists();

        if ($sudah) {
            return back()->withErrors(['pinjam' => 'Anda sudah mengajukan atau sedang meminjam buku ini.']);
        }

        Peminjaman::create([
            'user_id'        => $request->user()->id,
            'buku_id'        => $buku->id,
            'tanggal_pinjam' => now()->toDateString(),
            'status'         => 'diajukan',
        ]);

        return redirect()->route('peminjaman-saya.index')
            ->with('sukses', 'Pengajuan peminjaman terkirim.');
    }

    // Detail satu peminjaman: harus milik sendiri
    public function show(Request $request, Peminjaman $peminjaman)
    {
        abort_unless($peminjaman->user_id === $request->user()->id, 403);

        $peminjaman->load('buku');

        return view('peminjaman-saya.show', compact('peminjaman'));
    }
}
