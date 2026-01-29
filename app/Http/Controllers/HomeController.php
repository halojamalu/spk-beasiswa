<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use App\Models\Siswa;
use App\Models\PeriodeSeleksi;
use App\Models\PenilaianSiswa;
use App\Models\HasilPerhitungan;
use App\Models\LogPerhitungan;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // Periode Aktif
        $periodeAktif = PeriodeSeleksi::where('status', 'aktif')->first();
        
        // Statistik Master Data
        $totalKriteria = Kriteria::active()->count();
        $totalSiswa = Siswa::active()->count();
        $kriteriaWithBobot = Kriteria::active()->where('bobot', '>', 0)->count();
        
        // Statistik Penilaian
        $totalPenilaian = 0;
        $expectedPenilaian = 0;
        $persentasePenilaian = 0;
        
        if ($periodeAktif) {
            $totalPenilaian = PenilaianSiswa::where('periode_id', $periodeAktif->id)->count();
            $expectedPenilaian = $totalSiswa * $totalKriteria;
            $persentasePenilaian = $expectedPenilaian > 0 ? ($totalPenilaian / $expectedPenilaian) * 100 : 0;
        }
        
        // Statistik Hasil
        $hasilCount = 0;
        $hasilLayak = 0;
        $hasilCadangan = 0;
        $hasilTidakLayak = 0;
        
        if ($periodeAktif) {
            $hasilCount = HasilPerhitungan::where('periode_id', $periodeAktif->id)->count();
            $hasilLayak = HasilPerhitungan::where('periode_id', $periodeAktif->id)
                ->where('status_penerima', 'layak')->count();
            $hasilCadangan = HasilPerhitungan::where('periode_id', $periodeAktif->id)
                ->where('status_penerima', 'cadangan')->count();
            $hasilTidakLayak = HasilPerhitungan::where('periode_id', $periodeAktif->id)
                ->where('status_penerima', 'tidak_layak')->count();
        }
        
        // Top 10 Ranking
        $topRanking = [];
        if ($periodeAktif && $hasilCount > 0) {
            $topRanking = HasilPerhitungan::where('periode_id', $periodeAktif->id)
                ->with('siswa')
                ->orderBy('ranking', 'asc')
                ->limit(10)
                ->get();
        }
        
        // Log Aktivitas Terbaru
        $recentLogs = [];
        if ($periodeAktif) {
            $recentLogs = LogPerhitungan::where('periode_id', $periodeAktif->id)
                ->with('user')
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();
        }
        
        // Distribusi Siswa per Kelas
        $siswaPerKelas = Siswa::active()
            ->selectRaw('kelas, COUNT(*) as jumlah')
            ->groupBy('kelas')
            ->orderBy('kelas')
            ->get();
        
        // Distribusi Jenis Kelamin
        $siswaLaki = Siswa::active()->where('jenis_kelamin', 'L')->count();
        $siswaPerempuan = Siswa::active()->where('jenis_kelamin', 'P')->count();
        
        return view('home', compact(
            'periodeAktif',
            'totalKriteria',
            'totalSiswa',
            'kriteriaWithBobot',
            'totalPenilaian',
            'expectedPenilaian',
            'persentasePenilaian',
            'hasilCount',
            'hasilLayak',
            'hasilCadangan',
            'hasilTidakLayak',
            'topRanking',
            'recentLogs',
            'siswaPerKelas',
            'siswaLaki',
            'siswaPerempuan'
        ));
    }
}