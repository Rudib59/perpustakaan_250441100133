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
</style>

<div class="buku-wrap"
    data-kelola="{{ auth()->user()->can('kelola data buku') ? '1' : '0' }}"
    data-csrf="{{ csrf_token() }}">
    <h1>Daftar Buku</h1>

    <div id="pesan"></div>

    @can('kelola data buku')
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
        <tbody id="tabel-buku"></tbody>
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

    const tbody = document.getElementById('tabel-buku');
    const kotakPesan = document.getElementById('pesan');

    // Elemen formulir hanya ada untuk yang berhak mengelola buku
    const form = document.getElementById('form-buku');
    const btnSimpan = document.getElementById('btn-simpan');
    const btnBatal = document.getElementById('btn-batal');
    const fKategori = document.getElementById('kategori_id');
    const fJudul = document.getElementById('judul');
    const fPenulis = document.getElementById('penulis');
    const fTahun = document.getElementById('tahun_terbit');

    let daftarBuku = [];
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

    async function muatBuku() {
        try {
            const res = await fetch(API, {
                headers: {
                    'Accept': 'application/json'
                }
            });
            if (!res.ok) {
                throw new Error('Gagal memuat data buku (status ' + res.status + ').');
            }
            const json = await res.json();
            daftarBuku = json.data;
            render();
        } catch (err) {
            tampilError(err);
        }
    }

    function render() {
        tbody.innerHTML = '';

        if (daftarBuku.length === 0) {
            const tr = document.createElement('tr');
            const td = document.createElement('td');
            td.colSpan = 5;
            td.textContent = 'Belum ada data buku.';
            tr.appendChild(td);
            tbody.appendChild(tr);
            return;
        }

        daftarBuku.forEach((b) => {
            const tr = document.createElement('tr');

            [b.kategori, b.judul, b.penulis, b.tahun].forEach((nilai) => {
                const td = document.createElement('td');
                td.textContent = nilai;
                tr.appendChild(td);
            });

            const tdAksi = document.createElement('td');

            // Detail: untuk semua role
            const linkDetail = document.createElement('a');
            linkDetail.href = '/buku/' + b.id;
            linkDetail.textContent = 'Detail';
            linkDetail.className = 'btn-kecil';
            tdAksi.appendChild(linkDetail);

            // Ubah dan Hapus: hanya admin dan petugas
            if (BISA_KELOLA) {
                const btnUbah = document.createElement('button');
                btnUbah.type = 'button';
                btnUbah.textContent = 'Ubah';
                btnUbah.style.marginLeft = '6px';
                btnUbah.addEventListener('click', () => mulaiUbah(b.id));

                const btnHapus = document.createElement('button');
                btnHapus.type = 'button';
                btnHapus.textContent = 'Hapus';
                btnHapus.className = 'bahaya';
                btnHapus.style.marginLeft = '6px';
                btnHapus.addEventListener('click', () => hapusBuku(b));

                tdAksi.appendChild(btnUbah);
                tdAksi.appendChild(btnHapus);
            }

            tr.appendChild(tdAksi);
            tbody.appendChild(tr);
        });
    }

    function resetForm() {
        form.reset();
        editId = null;
        btnSimpan.textContent = 'Tambah Buku';
        btnBatal.style.display = 'none';
    }

    function mulaiUbah(id) {
        const b = daftarBuku.find((x) => x.id === id);
        if (!b) return;
        bersihkanPesan();
        editId = id;
        fKategori.value = b.kategori_id;
        fJudul.value = b.judul;
        fPenulis.value = b.penulis;
        fTahun.value = b.tahun;
        btnSimpan.textContent = 'Simpan Perubahan';
        btnBatal.style.display = 'inline-block';
        form.scrollIntoView({
            behavior: 'smooth'
        });
    }

    async function hapusBuku(b) {
        if (!confirm('Hapus buku "' + b.judul + '"?')) {
            return;
        }
        bersihkanPesan();
        try {
            await kirim(API + '/' + b.id, 'DELETE');
            if (editId === b.id) resetForm();
            tampilPesan('Buku berhasil dihapus.', 'sukses');
            await muatBuku();
        } catch (err) {
            tampilError(err);
        }
    }

    // Listener formulir dipasang hanya jika formulirnya ada
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
                    tampilPesan('Buku berhasil diperbarui.', 'sukses');
                } else {
                    await kirim(API, 'POST', payload);
                    tampilPesan('Buku berhasil ditambahkan.', 'sukses');
                }
                resetForm();
                await muatBuku();
            } catch (err) {
                tampilError(err);
            }
        });
    }

    muatBuku();
</script>
@endsection