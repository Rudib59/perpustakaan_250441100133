<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BukuController extends Controller
{
    public function index()
    {
        $kategoris = Kategori::orderBy('nama')->get();
        $bukus = Buku::with('kategori')->orderBy('id')->get();

        return view('buku.index', compact('kategoris', 'bukus'));
    }

    public function show(Buku $buku)
    {
        $buku->load('kategori');

        return view('buku.show', compact('buku'));
    }
    public function create()
    {
        $kategoris = Kategori::orderBy('nama')->get();

        return view('buku.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'kategori_id'  => ['required', 'exists:kategoris,id'],
            'judul'        => ['required', 'string', 'max:255'],
            'penulis'      => ['required', 'string', 'max:255'],
            'tahun_terbit' => ['required', 'digits:4'],
        ]);

        Buku::create($data);

        return redirect()->route('buku.index')->with('sukses', 'Buku berhasil ditambahkan.');
    }

    public function edit(Buku $buku)
    {
        $kategoris = Kategori::orderBy('nama')->get();

        return view('buku.edit', compact('buku', 'kategoris'));
    }

    public function update(Request $request, Buku $buku)
    {
        $data = $request->validate([
            'kategori_id'  => ['required', 'exists:kategoris,id'],
            'judul'        => ['required', 'string', 'max:255'],
            'penulis'      => ['required', 'string', 'max:255'],
            'tahun_terbit' => ['required', 'digits:4'],
        ]);

        $buku->update($data);

        return redirect()->route('buku.index')->with('sukses', 'Buku berhasil diperbarui.');
    }
    // RENTAN (A2): nilai judul digabung langsung ke string SQL
    public function cari(Request $request)
    {
        $judul = $request->query('judul');

        $hasil = DB::select('SELECT * FROM bukus WHERE judul = ?', [$judul]);

        return response()->json($hasil);
    }

    // Dipakai route A3 (GET) dan, setelah Soal 2, route DELETE
    public function destroy(Buku $buku)
    {
        $buku->delete();

        return redirect()->route('buku.index');
    }
}
