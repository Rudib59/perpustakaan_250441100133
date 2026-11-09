@extends('layouts.perpustakaan')

@section('title', 'Tambah Pengguna')

@section('content')
<h2>Tambah Pengguna</h2>
@include('admin.users._form', ['action' => route('admin.users.store')])
@endsection