<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
class BukuController extends Controller
{
    public function index()
    {
        $kategoris = Kategori::orderBy('nama')->get();
        return view('buku.index', compact('kategoris'));
    }

    public function show(Buku $buku)
    {
        $buku->load('kategori');

        return view('buku.show', compact('buku'));
    }
}

