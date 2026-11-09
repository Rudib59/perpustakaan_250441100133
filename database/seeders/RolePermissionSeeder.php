<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();  
        $permissions = [
            'akses dashboard admin',
            'akses dashboard petugas',
            'lihat daftar buku',
            'kelola data buku',
            'kelola data pengguna',
            'kelola role pengguna',
            'kelola peminjaman',
            'kelola pengembalian',
            'mengajukan peminjaman buku',
            'memproses persetujuan peminjaman',
            'mencatat pengembalian buku',
            'melihat status peminjaman sendiri',
            'melihat riwayat peminjaman sendiri',
            'lihat laporan perpustakaan',
            'lihat profil sendiri',
            'ubah profil sendiri',
        ];

        foreach ($permissions as $p) {
            Permission::findOrCreate($p, 'web');
        }

        $umum = [
            'lihat daftar buku',
            'mengajukan peminjaman buku',
            'melihat status peminjaman sendiri',
            'melihat riwayat peminjaman sendiri',
            'lihat profil sendiri',
            'ubah profil sendiri',
        ];

        $operasional = [
            'kelola data buku',
            'kelola peminjaman',
            'kelola pengembalian',
            'memproses persetujuan peminjaman',
            'mencatat pengembalian buku',
            'lihat laporan perpustakaan',
        ];

        $admin   = Role::findOrCreate('admin', 'web');
        $petugas = Role::findOrCreate('petugas', 'web');
        $siswa   = Role::findOrCreate('siswa', 'web');


        $admin->syncPermissions(array_merge($umum, $operasional, [
            'akses dashboard admin',
            'kelola data pengguna',
            'kelola role pengguna',
        ]));

        $petugas->syncPermissions(array_merge($umum, $operasional, [
            'akses dashboard petugas',
        ]));


        $siswa->syncPermissions($umum);


        $akun = [
            ['Admin Perpustakaan',   'admin@perpustakaan.test',   'admin'],
            ['Petugas Perpustakaan', 'petugas@perpustakaan.test', 'petugas'],
            ['Siswa Contoh',         'siswa@perpustakaan.test',   'siswa'],
        ];

        foreach ($akun as [$nama, $email, $role]) {
            $user = User::firstOrCreate(
                ['email' => $email],
                ['name' => $nama, 'password' => Hash::make('password123')]
            );
            $user->syncRoles([$role]);
        }
    }
}
