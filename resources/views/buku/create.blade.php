@extends('layouts.perpustakaan')

@section('title', 'Tambah Buku')

@section('content')
<div class="form-wrap">
    <h1>Tambah Buku</h1>

    <div class="form-kartu">
        <form method="POST" action="{{ route('buku.store') }}" class="form-buku">
            @include('buku._form')
        </form>
    </div>
</div>
@endsection