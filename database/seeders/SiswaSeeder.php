<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Siswa;
use Illuminate\Support\Facades\DB;

class SiswaSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('siswa')->delete();

        $siswa = [
            ['nis' => '2401', 'nama_lengkap' => 'Ahmad Fauzi', 'jenis_kelamin' => 'L', 'kelas' => '5A', 'alamat' => 'Jl. Merdeka No. 10, Batam', 'nama_ortu' => 'Budi Santoso', 'pekerjaan_ortu' => 'Buruh Pabrik', 'penghasilan_ortu' => 2000000, 'jumlah_tanggungan' => 4],
            ['nis' => '2402', 'nama_lengkap' => 'Siti Aminah', 'jenis_kelamin' => 'P', 'kelas' => '5A', 'alamat' => 'Jl. Sudirman No. 25, Batam', 'nama_ortu' => 'Ahmad Yani', 'pekerjaan_ortu' => 'Pedagang Kecil', 'penghasilan_ortu' => 1200000, 'jumlah_tanggungan' => 5],
            ['nis' => '2403', 'nama_lengkap' => 'Muhammad Rizki', 'jenis_kelamin' => 'L', 'kelas' => '5B', 'alamat' => 'Jl. Diponegoro No. 5, Batam', 'nama_ortu' => 'Hendra Wijaya', 'pekerjaan_ortu' => 'Karyawan Swasta', 'penghasilan_ortu' => 2500000, 'jumlah_tanggungan' => 3],
            ['nis' => '2404', 'nama_lengkap' => 'Fatimah Zahra', 'jenis_kelamin' => 'P', 'kelas' => '5B', 'alamat' => 'Jl. Pahlawan No. 15, Batam', 'nama_ortu' => 'Abdul Rohman', 'pekerjaan_ortu' => 'Tukang Ojek', 'penghasilan_ortu' => 1000000, 'jumlah_tanggungan' => 6],
            ['nis' => '2405', 'nama_lengkap' => 'Abdul Rahman', 'jenis_kelamin' => 'L', 'kelas' => '6A', 'alamat' => 'Jl. Kartini No. 8, Batam', 'nama_ortu' => 'Suryanto', 'pekerjaan_ortu' => 'Buruh Bangunan', 'penghasilan_ortu' => 1800000, 'jumlah_tanggungan' => 4],
            ['nis' => '2406', 'nama_lengkap' => 'Aisyah Putri', 'jenis_kelamin' => 'P', 'kelas' => '6A', 'alamat' => 'Jl. Gatot Subroto No. 20, Batam', 'nama_ortu' => 'Rahmat Hidayat', 'pekerjaan_ortu' => 'Tukang Becak', 'penghasilan_ortu' => 900000, 'jumlah_tanggungan' => 5],
            ['nis' => '2407', 'nama_lengkap' => 'Hamdan Hadi', 'jenis_kelamin' => 'L', 'kelas' => '6B', 'alamat' => 'Jl. Ahmad Yani No. 30, Batam', 'nama_ortu' => 'Bambang Susilo', 'pekerjaan_ortu' => 'Wiraswasta', 'penghasilan_ortu' => 3000000, 'jumlah_tanggungan' => 2],
            ['nis' => '2408', 'nama_lengkap' => 'Khadijah Azzahra', 'jenis_kelamin' => 'P', 'kelas' => '4A', 'alamat' => 'Jl. Veteran No. 12, Batam', 'nama_ortu' => 'Sutrisno', 'pekerjaan_ortu' => 'Buruh Pabrik', 'penghasilan_ortu' => 1500000, 'jumlah_tanggungan' => 4],
            ['nis' => '2409', 'nama_lengkap' => 'Umar Khattab', 'jenis_kelamin' => 'L', 'kelas' => '4A', 'alamat' => 'Jl. Proklamasi No. 7, Batam', 'nama_ortu' => 'Agus Setiawan', 'pekerjaan_ortu' => 'Karyawan Swasta', 'penghasilan_ortu' => 2200000, 'jumlah_tanggungan' => 3],
            ['nis' => '2410', 'nama_lengkap' => 'Zahra Amalia', 'jenis_kelamin' => 'P', 'kelas' => '4B', 'alamat' => 'Jl. Kemerdekaan No. 18, Batam', 'nama_ortu' => 'Hartono', 'pekerjaan_ortu' => 'Pedagang Kecil', 'penghasilan_ortu' => 1100000, 'jumlah_tanggungan' => 5],
            ['nis' => '2411', 'nama_lengkap' => 'Ibrahim Malik', 'jenis_kelamin' => 'L', 'kelas' => '5A', 'alamat' => 'Jl. Pemuda No. 22, Batam', 'nama_ortu' => 'Sugeng Riyadi', 'pekerjaan_ortu' => 'Supir Angkot', 'penghasilan_ortu' => 2800000, 'jumlah_tanggungan' => 3],
            ['nis' => '2412', 'nama_lengkap' => 'Maryam Husna', 'jenis_kelamin' => 'P', 'kelas' => '5B', 'alamat' => 'Jl. Mawar No. 9, Batam', 'nama_ortu' => 'Edi Santoso', 'pekerjaan_ortu' => 'Buruh Pabrik', 'penghasilan_ortu' => 1400000, 'jumlah_tanggungan' => 4],
            ['nis' => '2413', 'nama_lengkap' => 'Ali Ridho', 'jenis_kelamin' => 'L', 'kelas' => '6A', 'alamat' => 'Jl. Melati No. 14, Batam', 'nama_ortu' => 'Sunardi', 'pekerjaan_ortu' => 'Pedagang Kecil', 'penghasilan_ortu' => 1300000, 'jumlah_tanggungan' => 5],
            ['nis' => '2414', 'nama_lengkap' => 'Husna Maulida', 'jenis_kelamin' => 'P', 'kelas' => '6B', 'alamat' => 'Jl. Anggrek No. 6, Batam', 'nama_ortu' => 'Widodo', 'pekerjaan_ortu' => 'Karyawan Swasta', 'penghasilan_ortu' => 2600000, 'jumlah_tanggungan' => 2],
            ['nis' => '2415', 'nama_lengkap' => 'Yusuf Hakim', 'jenis_kelamin' => 'L', 'kelas' => '4A', 'alamat' => 'Jl. Kenanga No. 11, Batam', 'nama_ortu' => 'Joko Susilo', 'pekerjaan_ortu' => 'Buruh Bangunan', 'penghasilan_ortu' => 1700000, 'jumlah_tanggungan' => 4],
            ['nis' => '2416', 'nama_lengkap' => 'Latifah Nur', 'jenis_kelamin' => 'P', 'kelas' => '4B', 'alamat' => 'Jl. Dahlia No. 16, Batam', 'nama_ortu' => 'Slamet Riyanto', 'pekerjaan_ortu' => 'Tukang Ojek', 'penghasilan_ortu' => 1000000, 'jumlah_tanggungan' => 6],
            ['nis' => '2417', 'nama_lengkap' => 'Hasan Basri', 'jenis_kelamin' => 'L', 'kelas' => '5A', 'alamat' => 'Jl. Cempaka No. 3, Batam', 'nama_ortu' => 'Teguh Santoso', 'pekerjaan_ortu' => 'Wiraswasta', 'penghasilan_ortu' => 2900000, 'jumlah_tanggungan' => 3],
            ['nis' => '2418', 'nama_lengkap' => 'Nafisah Rahmah', 'jenis_kelamin' => 'P', 'kelas' => '5B', 'alamat' => 'Jl. Tulip No. 19, Batam', 'nama_ortu' => 'Hadi Purnomo', 'pekerjaan_ortu' => 'Pedagang Kecil', 'penghasilan_ortu' => 1200000, 'jumlah_tanggungan' => 5],
            ['nis' => '2419', 'nama_lengkap' => 'Said Abdullah', 'jenis_kelamin' => 'L', 'kelas' => '6A', 'alamat' => 'Jl. Seruni No. 4, Batam', 'nama_ortu' => 'Prayitno', 'pekerjaan_ortu' => 'Karyawan Swasta', 'penghasilan_ortu' => 2100000, 'jumlah_tanggungan' => 3],
            ['nis' => '2420', 'nama_lengkap' => 'Wardah Safira', 'jenis_kelamin' => 'P', 'kelas' => '6B', 'alamat' => 'Jl. Bougenville No. 13, Batam', 'nama_ortu' => 'Sukiman', 'pekerjaan_ortu' => 'Buruh Harian', 'penghasilan_ortu' => 800000, 'jumlah_tanggungan' => 6],
        ];

        foreach ($siswa as $item) {
            Siswa::create($item);
        }
    }
}