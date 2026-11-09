<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        Kategori::factory()
            ->count(4)
            ->sequence(
                ['nama' => 'Novel'],
                ['nama' => 'Sastra'],
                ['nama' => 'Filsafat'],
                ['nama' => 'Religi'],
            )
            ->create();
    }
}
