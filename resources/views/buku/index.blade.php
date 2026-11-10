@extends('layouts.perpustakaan')

@section('title', 'Daftar Buku')

@section('content')
<style>
    .buku-wrap {
        max-width: 1000px;
        margin: 0 auto;
        padding: 24px 16px;
    }

    .buku-form {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
        margin-bottom: 16px;
    }

    .buku-form label {
        display: block;
        font-size: 14px;
        margin-bottom: 4px;
    }

    .buku-form input,
    .buku-form select {
        width: 100%;
        padding: 8px;
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        box-sizing: border-box;
    }

    .buku-aksi {
        grid-column: 1 / -1;
        display: flex;
        gap: 8px;
    }

    .buku-wrap button {
        padding: 8px 14px;
        border: 0;
        border-radius: 6px;
        cursor: pointer;
        background: #2563eb;
        color: #fff;
    }

    .buku-wrap button.sekunder {
        background: #64748b;
    }

    .buku-wrap button.bahaya {
        background: #dc2626;
    }

    .buku-tabel {
        width: 100%;
        border-collapse: collapse;
    }

    .buku-tabel th,
    .buku-tabel td {
        border: 1px solid #e2e8f0;
        padding: 8px 10px;
        text-align: left;
    }

    .buku-tabel th {
        background: #f1f5f9;
    }

    #pesan {
        padding: 10px 12px;
        border-radius: 6px;
        margin-bottom: 12px;
        display: none;
    }

    #pesan.sukses {
        display: block;
        background: #dcfce7;
        color: #166534;
    }

    #pesan.gagal {
        display: block;
        background: #fee2e2;
        color: #991b1b;
    }

    form.inline {
        display: inline;
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
        margin-left: 6px;
    }

    .btn-kecil:first-child {
        margin-left: 0;
    }

    .btn-kecil.bahaya {
        background: #dc2626;
    }
</style>

<div class="buku-wrap"
    data-kelola="{{ auth()->user()->can('kelola-buku') ? '1' : '0' }}"
    data-csrf="{{ csrf_token() }}">
    <h1>Daftar Buku</h1>

    <div id="pesan"></div>

    @if (session('sukses'))
    <div class="sukses" style="padding:10px 12px;border-radius:6px;margin-bottom:12px;background:#dcfce7;color:#166534;">
        {{ session('sukses') }}
    </div>
    @endif

    @can('kelola-buku')
    <form id="form-buku" class="buku-form">
        <div>
            <label for="kategori_id">Kategori</label>
            <select id="kategori_id" required>
                <option value="">-- Pilih kategori --</option>
                @foreach ($kategoris as $k)
                <option value="{{ $k->id }}">{{ $k->nama }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="judul">Judul</label>
            <input type="text" id="judul">
        </div>
        <div>
            <label for="penulis">Penulis</label>
            <input type="text" id="penulis">
        </div>
        <div>
            <label for="tahun_terbit">Tahun Terbit</label>
            <input type="text" id="tahun_terbit">
        </div>
        <div class="buku-aksi">
            <button type="submit" id="btn-simpan">Tambah Buku</button>
            <button type="button" id="btn-batal" class="sekunder" style="display:none;">Batal</button>
        </div>
    </form>
    @endcan

    {{-- Tabel dirender oleh Blade (server-side), bukan lagi oleh JavaScript.
         Ini diperlukan agar setiap baris bisa memiliki form Hapus asli
         dengan @csrf dan @method('DELETE') sesuai Soal 2(c). --}}
    <table class="buku-tabel">
        <thead>
            <tr>
                <th>Kategori</th>
                <th>Judul</th>
                <th>Penulis</th>
                <th>Tahun Terbit</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody id="tabel-buku">
            @forelse ($bukus as $buku)
            <tr>
                <td>{{ $buku->kategori->nama ?? '-' }}</td>
                {{-- Soal 2(a): escaping Blade default, judul selalu tampil sebagai teks --}}
                <td>{{ $buku->judul }}</td>
                <td>{{ $buku->penulis }}</td>
                <td>{{ $buku->tahun_terbit }}</td>
                <td>
                    <a href="{{ url('/buku/' . $buku->id) }}" class="btn-kecil">Detail</a>

                    @can('kelola data buku')
                    <button type="button"
                        class="btn-kecil sekunder btn-ubah"
                        data-id="{{ $buku->id }}"
                        data-kategori_id="{{ $buku->kategori_id }}"
                        data-judul="{{ $buku->judul }}"
                        data-penulis="{{ $buku->penulis }}"
                        data-tahun_terbit="{{ $buku->tahun_terbit }}">
                        Ubah
                    </button>

                    {{-- Soal 2(c): penghapusan lewat form DELETE dengan @csrf --}}
                    <form class="inline" method="POST" action="{{ route('buku.destroy', $buku) }}"
                        onsubmit="return confirm('Hapus buku &quot;{{ $buku->judul }}&quot;?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-kecil bahaya">Hapus</button>
                    </form>
                    @endcan
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5">Belum ada data buku.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<script>
    const API = '/api/buku';
    const wrap = document.querySelector('.buku-wrap');
    const BISA_KELOLA = wrap.dataset.kelola === '1';
    const HEADER_JSON = {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': wrap.dataset.csrf
    };

    const kotakPesan = document.getElementById('pesan');

    // Elemen formulir hanya ada untuk yang berhak mengelola buku
    const form = document.getElementById('form-buku');
    const btnSimpan = document.getElementById('btn-simpan');
    const btnBatal = document.getElementById('btn-batal');
    const fKategori = document.getElementById('kategori_id');
    const fJudul = document.getElementById('judul');
    const fPenulis = document.getElementById('penulis');
    const fTahun = document.getElementById('tahun_terbit');

    let editId = null;

    function tampilPesan(teks, jenis) {
        kotakPesan.textContent = teks;
        kotakPesan.className = jenis;
    }

    function bersihkanPesan() {
        kotakPesan.textContent = '';
        kotakPesan.className = '';
    }

    function tampilError(err) {
        if (err instanceof TypeError) {
            tampilPesan('API tidak dapat diakses. Pastikan server berjalan.', 'gagal');
            return;
        }
        if (err.errors) {
            const semua = Object.values(err.errors).flat().join(' ');
            tampilPesan(semua, 'gagal');
            return;
        }
        tampilPesan(err.message, 'gagal');
    }

    async function kirim(url, method, body) {
        const res = await fetch(url, {
            method: method,
            headers: HEADER_JSON,
            body: body ? JSON.stringify(body) : undefined,
        });
        const data = await res.json().catch(() => ({}));
        if (!res.ok) {
            const err = new Error(data.message || 'Permintaan gagal (status ' + res.status + ').');
            err.errors = data.errors || null;
            throw err;
        }
        return data;
    }

    function resetForm() {
        form.reset();
        editId = null;
        btnSimpan.textContent = 'Tambah Buku';
        btnBatal.style.display = 'none';
    }

    function mulaiUbah(tombol) {
        bersihkanPesan();
        editId = tombol.dataset.id;
        fKategori.value = tombol.dataset.kategori_id;
        fJudul.value = tombol.dataset.judul;
        fPenulis.value = tombol.dataset.penulis;
        fTahun.value = tombol.dataset.tahun_terbit;
        btnSimpan.textContent = 'Simpan Perubahan';
        btnBatal.style.display = 'inline-block';
        form.scrollIntoView({
            behavior: 'smooth'
        });
    }

    // Tombol Ubah dipasang lewat delegasi, karena baris tabel dirender Blade
    document.querySelectorAll('.btn-ubah').forEach((tombol) => {
        tombol.addEventListener('click', () => mulaiUbah(tombol));
    });

    // Listener formulir Tambah/Ubah dipasang hanya jika formulirnya ada
    if (form) {
        btnBatal.addEventListener('click', () => {
            bersihkanPesan();
            resetForm();
        });

        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            bersihkanPesan();

            const payload = {
                kategori_id: fKategori.value,
                judul: fJudul.value,
                penulis: fPenulis.value,
                tahun_terbit: fTahun.value,
            };

            try {
                if (editId) {
                    await kirim(API + '/' + editId, 'PUT', payload);
                } else {
                    await kirim(API, 'POST', payload);
                }
                // Tabel kini dirender server-side, jadi halaman dimuat ulang
                // agar data terbaru tampil.
                window.location.reload();
            } catch (err) {
                tampilError(err);
            }
        });
    }
</script>
@endsection