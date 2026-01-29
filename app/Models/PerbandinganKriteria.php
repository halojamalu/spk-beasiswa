<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerbandinganKriteria extends Model
{
    use HasFactory;

    protected $table = 'perbandingan_kriteria';

    protected $fillable = [
        'periode_id',
        'kriteria_1',
        'kriteria_2',
        'nilai_crisp',
        'nilai_fuzzy_l',
        'nilai_fuzzy_m',
        'nilai_fuzzy_u'
    ];

    protected $casts = [
        'nilai_crisp' => 'decimal:2',
        'nilai_fuzzy_l' => 'decimal:2',
        'nilai_fuzzy_m' => 'decimal:2',
        'nilai_fuzzy_u' => 'decimal:2',
    ];

    // Relationships
    public function periode()
    {
        return $this->belongsTo(PeriodeSeleksi::class, 'periode_id');
    }

    public function kriteriaFirst()
    {
        return $this->belongsTo(Kriteria::class, 'kriteria_1');
    }

    public function kriteriaSecond()
    {
        return $this->belongsTo(Kriteria::class, 'kriteria_2');
    }
}