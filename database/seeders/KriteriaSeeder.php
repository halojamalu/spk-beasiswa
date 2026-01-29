<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kriteria;
use Illuminate\Support\Facades\DB;

class KriteriaSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('kriteria')->delete();

        $kriteria = [
            [
                'kode_kriteria' => 'C1',
                'nama_kriteria' => 'Nilai Akademik (Rata-rata Rapor)',
                'jenis' => 'benefit',
                'bobot' => 0,
                'keterangan' => 'Nilai rata-rata rapor semester terakhir (0-100)',
                'is_active' => true,
            ],
            [
                'kode_kriteria' => 'C2',
                'nama_kriteria' => 'Penghasilan Orang Tua',
                'jenis' => 'cost',
                'bobot' => 0,
                'keterangan' => 'Penghasilan orang tua per bulan dalam Rupiah',
                'is_active' => true,
            ],
            [
                'kode_kriteria' => 'C3',
                'nama_kriteria' => 'Jumlah Tanggungan Keluarga',
                'jenis' => 'benefit',
                'bobot' => 0,
                'keterangan' => 'Jumlah anak/tanggungan dalam keluarga',
                'is_active' => true,
            ],
            [
                'kode_kriteria' => 'C4',
                'nama_kriteria' => 'Prestasi Non-Akademik',
                'jenis' => 'benefit',
                'bobot' => 0,
                'keterangan' => 'Skor prestasi non-akademik (0-100)',
                'is_active' => true,
            ],
            [
                'kode_kriteria' => 'C5',
                'nama_kriteria' => 'Kehadiran',
                'jenis' => 'benefit',
                'bobot' => 0,
                'keterangan' => 'Persentase kehadiran siswa (0-100%)',
                'is_active' => true,
            ],
            [
                'kode_kriteria' => 'C6',
                'nama_kriteria' => 'Kelakuan/Sikap',
                'jenis' => 'benefit',
                'bobot' => 0,
                'keterangan' => 'Nilai kelakuan/sikap (0-100)',
                'is_active' => true,
            ],
        ];

        foreach ($kriteria as $item) {
            Kriteria::create($item);
        }
    }
}