@extends('layouts.perpustakaan')

@section('title', 'Ubah Buku')

@section('content')
<div class="form-wrap">
    <h1>Ubah Buku</h1>

    <div class="form-kartu">
        <form method="POST" action="{{ route('buku.update', $buku) }}" class="form-buku">
            @method('PUT')
            @include('buku._form')
        </form>
    </div>
</div>
@endsection