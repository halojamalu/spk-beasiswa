<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogPerhitungan extends Model
{
    use HasFactory;

    protected $table = 'log_perhitungan';

    protected $fillable = [
        'periode_id',
        'user_id',
        'jenis_proses',
        'detail_proses',
        'keterangan'
    ];

    protected $casts = [
        'detail_proses' => 'array',
    ];

    // Relationships
    public function periode()
    {
        return $this->belongsTo(PeriodeSeleksi::class, 'periode_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Scopes
    public function scopeFuzzyAhp($query)
    {
        return $query->where('jenis_proses', 'fuzzy-ahp');
    }

    public function scopeMoora($query)
    {
        return $query->where('jenis_proses', 'moora');
    }
}