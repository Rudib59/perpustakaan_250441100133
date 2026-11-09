@extends('layouts.perpustakaan')

@section('title', 'Ubah Pengguna')

@section('content')
<h2>Ubah Pengguna</h2>
@include('admin.users._form', ['action' => route('admin.users.update', $user), 'user' => $user])
@endsection