<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('peminjamans', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->after('id')
                ->constrained('users')->nullOnDelete();
            $table->string('status')->default('diajukan')->after('tanggal_kembali');
            // Peminjaman dari akun login tidak punya data anggota
            $table->foreignId('anggota_id')->nullable()->change();
        });

        // Data lama dari Modul 2 disesuaikan dengan status baru
        DB::table('peminjamans')->whereNotNull('tanggal_kembali')->update(['status' => 'dikembalikan']);
        DB::table('peminjamans')->whereNull('tanggal_kembali')->update(['status' => 'dipinjam']);
    }

    public function down(): void
    {
        Schema::table('peminjamans', function (Blueprint $table) {
            $table->dropConstrainedForeignId('user_id');
            $table->dropColumn('status');
        });
    }
};
