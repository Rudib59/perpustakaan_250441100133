<style>
    .form-wrap {
        max-width: 1000px;
        margin: 0 auto;
        padding: 24px 16px;
    }

    .form-kartu {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 24px;
    }

    .form-buku {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
    }

    .form-buku label {
        display: block;
        font-size: 14px;
        margin-bottom: 4px;
    }

    .form-buku input,
    .form-buku select {
        width: 100%;
        padding: 8px;
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        box-sizing: border-box;
        font: inherit;
    }

    .form-buku input:focus,
    .form-buku select:focus {
        outline: 2px solid #2563eb;
        outline-offset: 0;
        border-color: #2563eb;
    }

    .form-aksi {
        grid-column: 1 / -1;
        display: flex;
        gap: 8px;
        align-items: center;
    }

    .form-aksi button,
    .form-aksi a {
        display: inline-block;
        padding: 8px 14px;
        border: 0;
        border-radius: 6px;
        cursor: pointer;
        font: inherit;
        text-decoration: none;
        color: #fff;
    }

    .form-aksi button {
        background: #2563eb;
    }

    .form-aksi a {
        background: #64748b;
    }

    .form-error {
        grid-column: 1 / -1;
        padding: 10px 12px;
        border-radius: 6px;
        background: #fee2e2;
        color: #991b1b;
    }

    .form-error ul {
        margin: 0;
        padding-left: 18px;
    }

    @media (max-width: 640px) {
        .form-buku {
            grid-template-columns: 1fr;
        }
    }
</style>

@csrf

@if ($errors->any())
<div class="form-error">
    <ul>
        @foreach ($errors->all() as $pesan)
        <li>{{ $pesan }}</li>
        @endforeach
    </ul>
</div>
@endif

<div>
    <label for="kategori_id">Kategori</label>
    <select name="kategori_id" id="kategori_id" required>
        <option value="">-- Pilih kategori --</option>
        @foreach ($kategoris as $k)
        <option value="{{ $k->id }}" @selected(old('kategori_id', $buku->kategori_id ?? '') == $k->id)>{{ $k->nama }}</option>
        @endforeach
    </select>
</div>

<div>
    <label for="judul">Judul</label>
    <input type="text" name="judul" id="judul" value="{{ old('judul', $buku->judul ?? '') }}" required>
</div>

<div>
    <label for="penulis">Penulis</label>
    <input type="text" name="penulis" id="penulis" value="{{ old('penulis', $buku->penulis ?? '') }}" required>
</div>

<div>
    <label for="tahun_terbit">Tahun Terbit</label>
    <input type="text" name="tahun_terbit" id="tahun_terbit" value="{{ old('tahun_terbit', $buku->tahun_terbit ?? '') }}" required>
</div>

<div class="form-aksi">
    <button type="submit">Simpan</button>
    <a href="{{ route('buku.index') }}">Batal</a>
</div>