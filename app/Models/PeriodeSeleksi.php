<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeriodeSeleksi extends Model
{
    use HasFactory;

    protected $table = 'periode_seleksi';

    protected $fillable = [
        'nama_periode',
        'tahun_ajaran',
        'tanggal_mulai',
        'tanggal_selesai',
        'kuota_beasiswa',
        'status',
        'keterangan'
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'kuota_beasiswa' => 'integer',
    ];

    // Relationships
    public function perbandinganKriteria()
    {
        return $this->hasMany(PerbandinganKriteria::class, 'periode_id');
    }

    public function penilaianSiswa()
    {
        return $this->hasMany(PenilaianSiswa::class, 'periode_id');
    }

    public function hasilPerhitungan()
    {
        return $this->hasMany(HasilPerhitungan::class, 'periode_id');
    }

    public function logPerhitungan()
    {
        return $this->hasMany(LogPerhitungan::class, 'periode_id');
    }

    // Scopes
    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    public function scopeSelesai($query)
    {
        return $query->where('status', 'selesai');
    }

    // Accessor
    public function getIsAktifAttribute()
    {
        return $this->status === 'aktif';
    }
}