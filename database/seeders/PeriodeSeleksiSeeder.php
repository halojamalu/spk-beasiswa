<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PeriodeSeleksi;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PeriodeSeleksiSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('periode_seleksi')->delete();

        $periode = [
            [
                'nama_periode' => 'Seleksi Beasiswa Semester Genap 2024/2025',
                'tahun_ajaran' => '2024/2025',
                'tanggal_mulai' => Carbon::create(2025, 1, 1),
                'tanggal_selesai' => Carbon::create(2025, 2, 28),
                'kuota_beasiswa' => 10,
                'status' => 'aktif',
                'keterangan' => 'Periode seleksi beasiswa untuk semester genap tahun ajaran 2024/2025',
            ],
        ];

        foreach ($periode as $item) {
            PeriodeSeleksi::create($item);
        }
    }
}