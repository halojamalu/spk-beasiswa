<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswa';

    protected $fillable = [
        'nis',
        'nama_lengkap',
        'jenis_kelamin',
        'kelas',
        'alamat',
        'nama_ortu',
        'pekerjaan_ortu',
        'penghasilan_ortu',
        'jumlah_tanggungan',
        'is_active'
    ];

    protected $casts = [
        'penghasilan_ortu' => 'decimal:2',
        'jumlah_tanggungan' => 'integer',
        'is_active' => 'boolean',
    ];

    // Relationships
    public function penilaianSiswa()
    {
        return $this->hasMany(PenilaianSiswa::class, 'siswa_id');
    }

    public function hasilPerhitungan()
    {
        return $this->hasMany(HasilPerhitungan::class, 'siswa_id');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeLakiLaki($query)
    {
        return $query->where('jenis_kelamin', 'L');
    }

    public function scopePerempuan($query)
    {
        return $query->where('jenis_kelamin', 'P');
    }

    // Accessor
    public function getJenisKelaminLengkapAttribute()
    {
        return $this->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan';
    }
}