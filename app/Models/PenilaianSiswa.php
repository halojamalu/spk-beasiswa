<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenilaianSiswa extends Model
{
    use HasFactory;

    protected $table = 'penilaian_siswa';

    protected $fillable = [
        'periode_id',
        'siswa_id',
        'kriteria_id',
        'nilai',
        'keterangan'
    ];

    protected $casts = [
        'nilai' => 'decimal:2',
    ];

    // Relationships
    public function periode()
    {
        return $this->belongsTo(PeriodeSeleksi::class, 'periode_id');
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class, 'kriteria_id');
    }
}