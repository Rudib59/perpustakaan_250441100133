<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PeminjamanSayaController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PetugasDashboardController;

// Publik
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Harus login
Route::middleware('auth')->group(function () {

    // Profil sendiri (semua role)
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->middleware('permission:lihat profil sendiri')
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->middleware('permission:ubah profil sendiri')
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    // Semua role: lihat daftar buku
    Route::get('/buku', [BukuController::class, 'index'])
        ->middleware('permission:lihat daftar buku')
        ->name('buku.index');

    // RENTAN (A2): SQL Injection
    Route::get('/buku-cari', [BukuController::class, 'cari']);

    // Khusus petugas
    Route::get('/petugas/dashboard', PetugasDashboardController::class)
        ->middleware('permission:akses dashboard petugas')
        ->name('petugas.dashboard');

    // Admin dan petugas: tambah, ubah, hapus buku
    Route::middleware('permission:kelola data buku')->group(function () {
        Route::resource('buku', BukuController::class)->except(['index', 'show']);
    });

    // Semua role: detail buku (setelah resource agar /buku/create tidak bentrok)
    Route::get('/buku/{buku}', [BukuController::class, 'show'])
        ->middleware('permission:lihat daftar buku')
        ->whereNumber('buku')
        ->name('buku.show');

    // Siswa (dan semua role): ajukan peminjaman, status dan riwayat milik sendiri
    Route::post('/buku/{buku}/pinjam', [PeminjamanSayaController::class, 'store'])
        ->middleware('permission:mengajukan peminjaman buku')
        ->name('peminjaman-saya.store');

    Route::get('/peminjaman-saya', [PeminjamanSayaController::class, 'index'])
        ->middleware('permission:melihat riwayat peminjaman sendiri')
        ->name('peminjaman-saya.index');

    Route::get('/peminjaman-saya/{peminjaman}', [PeminjamanSayaController::class, 'show'])
        ->middleware('permission:melihat riwayat peminjaman sendiri')
        ->name('peminjaman-saya.show');

    Route::patch('/peminjaman-saya/{peminjaman}/kembali', [PeminjamanSayaController::class, 'ajukanPengembalian'])
        ->middleware('permission:mengajukan peminjaman buku')
        ->name('peminjaman-saya.kembali');

    // RENTAN (A4): IDOR, hanya cek login, tidak cek pemilik
    // (sengaja di luar grup permission:kelola peminjaman)
    Route::get('/peminjaman/{id}', [PeminjamanController::class, 'show'])
        ->whereNumber('id');

    // Admin dan petugas: peminjaman
    Route::middleware('permission:kelola peminjaman')->group(function () {
        Route::get('/peminjaman', [PeminjamanController::class, 'index'])
            ->name('peminjaman.index');

        Route::patch('/peminjaman/{peminjaman}/setujui', [PeminjamanController::class, 'setujui'])
            ->middleware('permission:memproses persetujuan peminjaman')
            ->name('peminjaman.setujui');

        Route::patch('/peminjaman/{peminjaman}/tolak', [PeminjamanController::class, 'tolak'])
            ->middleware('permission:memproses persetujuan peminjaman')
            ->name('peminjaman.tolak');
    });

    // Admin dan petugas: pengembalian
    Route::middleware('permission:kelola pengembalian')->group(function () {
        Route::get('/pengembalian', [PengembalianController::class, 'index'])
            ->name('pengembalian.index');

        Route::patch('/pengembalian/{peminjaman}', [PengembalianController::class, 'store'])
            ->middleware('permission:mencatat pengembalian buku')
            ->name('pengembalian.store');
    });

    // Admin dan petugas: laporan
    Route::get('/laporan', [LaporanController::class, 'index'])
        ->middleware('permission:lihat laporan perpustakaan')
        ->name('laporan.index');

    // Khusus admin (URL diawali /admin, nama diawali admin.)
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', DashboardController::class)
            ->middleware('permission:akses dashboard admin')
            ->name('dashboard');

        Route::resource('users', UserController::class)
            ->except('show')
            ->middleware('permission:kelola data pengguna');
    });
});

require __DIR__ . '/auth.php';
