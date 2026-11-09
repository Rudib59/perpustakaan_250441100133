<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\User;

class DashboardController extends Controller
{
    public function __invoke()
    {
        return view('admin.dashboard', [
            'totalBuku'     => Buku::count(),
            'totalPengguna' => User::count(),
            'totalAdmin'    => User::role('admin')->count(),
            'totalPetugas'  => User::role('petugas')->count(),
            'totalSiswa'    => User::role('siswa')->count(),
        ]);
    }
}
