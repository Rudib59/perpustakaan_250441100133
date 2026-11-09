<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjamans';

    protected $fillable = [
        'user_id',
        'anggota_id',
        'buku_id',
        'tanggal_pinjam',
        'tanggal_kembali',
        'status',
    ];
    public const STATUS_LABEL = [
        'diajukan'              => 'Diajukan',
        'dipinjam'              => 'Dipinjam',
        'pengembalian_diajukan' => 'Menunggu pengembalian',
        'dikembalikan'          => 'Dikembalikan',
        'ditolak'               => 'Ditolak',
    ];

    public function getStatusLabelAttribute(): string
    {
        return self::STATUS_LABEL[$this->status] ?? ucfirst($this->status);
    }
    protected function casts(): array
    {
        return [
            'tanggal_pinjam'  => 'date',
            'tanggal_kembali' => 'date',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function anggota()
    {
        return $this->belongsTo(Anggota::class);
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class);
    }

    // Nama peminjam: dari akun login, atau dari data anggota (data lama Modul 2)
    public function getNamaPeminjamAttribute(): string
    {
        return $this->user?->name ?? $this->anggota?->nama ?? '-';
    }
}
