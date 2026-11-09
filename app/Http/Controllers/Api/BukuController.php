<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BukuResource;
use App\Models\Buku;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    public function index(Request $request)
    {
        $buku = Buku::with('kategori')
            ->withCount('peminjamans')
            ->when($request->filled('cari'), function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('judul', 'like', '%' . $request->cari . '%')
                        ->orWhere('penulis', 'like', '%' . $request->cari . '%');
                });
            })
            ->when($request->filled('kategori'), fn($q) => $q->where('kategori_id', $request->kategori))
            ->when($request->filled('tahun'), fn($q) => $q->where('tahun_terbit', $request->tahun))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return BukuResource::collection($buku);
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->aturan(), $this->pesan(), $this->atribut());

        $buku = Buku::create($data);

        return response()->json([
            'message' => 'Buku berhasil ditambahkan',
            'data'    => $buku->load('kategori'),
        ], 201);
    }

    public function show($id)
    {
        $buku = Buku::with(['kategori', 'peminjamans'])->find($id);

        if (!$buku) {
            return response()->json(['message' => 'not found'], 404);
        }

        return response()->json(['data' => $buku], 200);
    }

    public function update(Request $request, Buku $buku)
    {
        $aturan = collect($this->aturan())
            ->map(fn($rule) => array_merge(['sometimes'], $rule))
            ->all();

        $data = $request->validate($aturan, $this->pesan(), $this->atribut());

        $buku->update($data);

        return response()->json([
            'message' => 'Buku berhasil diperbarui',
            'data'    => $buku->load('kategori'),
        ], 200);
    }

    public function destroy(Buku $buku)
    {
        if ($buku->peminjamans()->exists()) {
            return response()->json([
                'message' => 'Buku tidak dapat dihapus karena memiliki Masih peminjaman.',
            ], 409);
        }

        $buku->delete();

        return response()->json(['message' => 'Buku berhasil dihapus'], 200);
    }
    private function aturan(): array
    {
        return [
            'kategori_id'  => ['required', 'exists:kategoris,id'],
            'judul'        => ['required', 'string', 'min:3', 'max:150'],
            'penulis'      => ['required', 'string', 'min:3', 'max:100'],
            'tahun_terbit' => ['required', 'integer', 'between:1900,' . date('Y')],
        ];
    }

    private function pesan(): array
    {
        return [
            'required'             => ':attribute wajib diisi.',
            'string'               => ':attribute harus berupa teks.',
            'integer'              => ':attribute harus berupa bilangan bulat.',
            'judul.min'            => 'Judul buku minimal :min karakter.',
            'judul.max'            => 'Judul buku maksimal :max karakter.',
            'penulis.min'          => 'Penulis minimal :min karakter.',
            'penulis.max'          => 'Penulis maksimal :max karakter.',
            'tahun_terbit.between' => 'Tahun terbit harus antara :min sampai :max.',
            'kategori_id.exists'   => 'Kategori yang dipilih tidak valid.',
        ];
    }

    private function atribut(): array
    {
        return [
            'kategori_id'  => 'kategori',
            'tahun_terbit' => 'tahun terbit',
        ];
    }
}