<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PenilaianSiswa;
use App\Models\Siswa;
use App\Models\Kriteria;
use App\Models\PeriodeSeleksi;
use Illuminate\Support\Facades\DB;

class PenilaianSiswaSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('penilaian_siswa')->delete();

        $periode = PeriodeSeleksi::first();
        
        if (!$periode) {
            $this->command->error('Periode seleksi tidak ditemukan! Jalankan PeriodeSeleksiSeeder terlebih dahulu.');
            return;
        }

        // Data penilaian sesuai dataset dari analisis kebutuhan
        $dataNilai = [
            ['2401', 85, 2000000, 4, 70, 95, 100],
            ['2402', 90, 1200000, 5, 85, 98, 100],
            ['2403', 78, 2500000, 3, 60, 88, 85],
            ['2404', 92, 1000000, 6, 100, 100, 100],
            ['2405', 88, 1800000, 4, 70, 92, 85],
            ['2406', 95, 900000, 5, 85, 97, 100],
            ['2407', 75, 3000000, 2, 0, 85, 85],
            ['2408', 87, 1500000, 4, 70, 94, 100],
            ['2409', 82, 2200000, 3, 60, 90, 85],
            ['2410', 93, 1100000, 5, 85, 99, 100],
            ['2411', 80, 2800000, 3, 60, 87, 85],
            ['2412', 89, 1400000, 4, 70, 96, 100],
            ['2413', 91, 1300000, 5, 85, 98, 100],
            ['2414', 77, 2600000, 2, 0, 86, 85],
            ['2415', 86, 1700000, 4, 70, 93, 100],
            ['2416', 94, 1000000, 6, 100, 100, 100],
            ['2417', 79, 2900000, 3, 60, 88, 85],
            ['2418', 90, 1200000, 5, 85, 97, 100],
            ['2419', 84, 2100000, 3, 60, 91, 85],
            ['2420', 96, 800000, 6, 100, 100, 100],
        ];

        $kriteria = Kriteria::orderBy('kode_kriteria')->get();

        foreach ($dataNilai as $data) {
            $siswa = Siswa::where('nis', $data[0])->first();
            
            if (!$siswa) continue;

            // C1: Nilai Akademik
            PenilaianSiswa::create([
                'periode_id' => $periode->id,
                'siswa_id' => $siswa->id,
                'kriteria_id' => $kriteria[0]->id,
                'nilai' => $data[1],
            ]);

            // C2: Penghasilan Orang Tua
            PenilaianSiswa::create([
                'periode_id' => $periode->id,
                'siswa_id' => $siswa->id,
                'kriteria_id' => $kriteria[1]->id,
                'nilai' => $data[2],
            ]);

            // C3: Jumlah Tanggungan
            PenilaianSiswa::create([
                'periode_id' => $periode->id,
                'siswa_id' => $siswa->id,
                'kriteria_id' => $kriteria[2]->id,
                'nilai' => $data[3],
            ]);

            // C4: Prestasi Non-Akademik
            PenilaianSiswa::create([
                'periode_id' => $periode->id,
                'siswa_id' => $siswa->id,
                'kriteria_id' => $kriteria[3]->id,
                'nilai' => $data[4],
            ]);

            // C5: Kehadiran
            PenilaianSiswa::create([
                'periode_id' => $periode->id,
                'siswa_id' => $siswa->id,
                'kriteria_id' => $kriteria[4]->id,
                'nilai' => $data[5],
            ]);

            // C6: Kelakuan/Sikap
            PenilaianSiswa::create([
                'periode_id' => $periode->id,
                'siswa_id' => $siswa->id,
                'kriteria_id' => $kriteria[5]->id,
                'nilai' => $data[6],
            ]);
        }
    }
}