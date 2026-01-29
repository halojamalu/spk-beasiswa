<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kriteria extends Model
{
    use HasFactory;

    protected $table = 'kriteria';

    protected $fillable = [
        'kode_kriteria',
        'nama_kriteria',
        'jenis',
        'bobot',
        'keterangan',
        'is_active'
    ];

    protected $casts = [
        'bobot' => 'decimal:4',
        'is_active' => 'boolean',
    ];

    // Relationships
    public function penilaianSiswa()
    {
        return $this->hasMany(PenilaianSiswa::class, 'kriteria_id');
    }

    public function perbandinganKriteria1()
    {
        return $this->hasMany(PerbandinganKriteria::class, 'kriteria_1');
    }

    public function perbandinganKriteria2()
    {
        return $this->hasMany(PerbandinganKriteria::class, 'kriteria_2');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeBenefit($query)
    {
        return $query->where('jenis', 'benefit');
    }

    public function scopeCost($query)
    {
        return $query->where('jenis', 'cost');
    }
}