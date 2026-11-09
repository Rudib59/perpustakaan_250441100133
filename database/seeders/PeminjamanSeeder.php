<?php

namespace Database\Seeders;

use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Database\Seeder;

class PeminjamanSeeder extends Seeder
{
    public function run(): void
    {
        $siswa = User::where('email', 'siswa@perpustakaan.test')->first();
        $buku  = Buku::take(4)->get();

        if (! $siswa || $buku->count() < 4) {
            return;
        }

        $data = [
            [$buku[0]->id, 'diajukan',     now()->toDateString(),              null],
            [$buku[1]->id, 'dipinjam',     now()->subDays(3)->toDateString(),  null],
            [$buku[2]->id, 'dikembalikan', now()->subDays(10)->toDateString(), now()->subDays(4)->toDateString()],
            [$buku[3]->id, 'ditolak',      now()->subDays(2)->toDateString(),  null],
        ];

        foreach ($data as [$bukuId, $status, $pinjam, $kembali]) {
            Peminjaman::firstOrCreate(
                ['user_id' => $siswa->id, 'buku_id' => $bukuId],
                ['status' => $status, 'tanggal_pinjam' => $pinjam, 'tanggal_kembali' => $kembali]
            );
        }
    }
}
