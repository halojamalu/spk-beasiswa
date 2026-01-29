<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilPerhitungan extends Model
{
    use HasFactory;

    protected $table = 'hasil_perhitungan';

    protected $fillable = [
        'periode_id',
        'siswa_id',
        'nilai_moora',
        'ranking',
        'status_penerima'
    ];

    protected $casts = [
        'nilai_moora' => 'decimal:6',
        'ranking' => 'integer',
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

    // Scopes
    public function scopeLayak($query)
    {
        return $query->where('status_penerima', 'layak');
    }

    public function scopeTidakLayak($query)
    {
        return $query->where('status_penerima', 'tidak_layak');
    }

    public function scopeCadangan($query)
    {
        return $query->where('status_penerima', 'cadangan');
    }

    // Accessor
    public function getStatusPenerimaLabelAttribute()
    {
        $labels = [
            'layak' => 'Layak Menerima',
            'tidak_layak' => 'Tidak Layak',
            'cadangan' => 'Cadangan'
        ];
        return $labels[$this->status_penerima] ?? $this->status_penerima;
    }
}