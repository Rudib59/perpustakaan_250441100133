<?php

namespace Database\Seeders;

use App\Models\Buku;
use Illuminate\Database\Seeder;

class BukuSeeder extends Seeder
{
    public function run(): void
    {
        Buku::factory()
            ->count(6)
            ->sequence(
                ['kategori_id' => 1, 'judul' => 'Laskar Pelangi', 'penulis' => 'Andrea Hirata', 'tahun_terbit' => 2005],
                ['kategori_id' => 2, 'judul' => 'Bumi Manusia', 'penulis' => 'Pramoedya Ananta Toer', 'tahun_terbit' => 1980],
                ['kategori_id' => 1, 'judul' => 'Negeri 5 Menara', 'penulis' => 'Ahmad Fuadi', 'tahun_terbit' => 2009],
                ['kategori_id' => 3, 'judul' => 'Filosofi Teras', 'penulis' => 'Henry Manampiring', 'tahun_terbit' => 2018],
                ['kategori_id' => 4, 'judul' => 'Ayat-Ayat Cinta', 'penulis' => 'Habiburrahman El Shirazy', 'tahun_terbit' => 2004],
                ['kategori_id' => 1, 'judul' => 'Sang Pemimpi', 'penulis' => 'Andrea Hirata', 'tahun_terbit' => 2006],
            )
            ->create();
    }
}
