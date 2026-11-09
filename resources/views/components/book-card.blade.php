<div class="book-card">

    <h3>{{ $buku['judul'] }}</h3>

    <p>Penulis: {{ $buku['penulis'] }}</p>

    <p>Tahun Terbit: {{ $buku['tahun'] }}</p>

    <a href="{{ route('buku.show', $buku['id']) }}">
        Lihat Detail
    </a>

    <div>
        {{ $slot }}
    </div>

</div>