<?php

namespace Database\Seeders;

use App\Models\Anggota;
use Illuminate\Database\Seeder;

class AnggotaSeeder extends Seeder
{
    public function run(): void
    {
        $anggotas = [
            [
                'nama' => 'Rudi Bayu',
                'email' => 'rudi.bayu@gmail.com',
                'no_telepon' => '081234567890',
            ],
            [
                'nama' => 'Siti Aisyah',
                'email' => 'siti.aisyah@gmail.com',
                'no_telepon' => '081298765432',
            ],
            [
                'nama' => 'Ahmad Fauzi',
                'email' => 'ahmad.fauzi@gmail.com',
                'no_telepon' => '085712345678',
            ],
            [
                'nama' => 'Dewi Lestari',
                'email' => 'dewi.lestari@gmail.com',
                'no_telepon' => '082134567891',
            ],
            [
                'nama' => 'Budi Santoso',
                'email' => 'budi.santoso@gmail.com',
                'no_telepon' => '087856781234',
            ],
        ];

        foreach ($anggotas as $anggota) {
            Anggota::updateOrCreate(
                ['email' => $anggota['email']],
                $anggota
            );
        }
    }
}
