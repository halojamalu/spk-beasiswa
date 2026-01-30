<?php

namespace App\Http\Controllers;

use App\Models\PeriodeSeleksi;
use App\Models\HasilPerhitungan;
use App\Models\Kriteria;
use App\Models\Siswa;
use App\Models\PenilaianSiswa;
use App\Exports\RankingExport;
use App\Exports\DetailPerhitunganExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Export Ranking ke PDF
     */
    public function rankingPdf()
    {
        $periodeAktif = PeriodeSeleksi::where('status', 'aktif')->first();
        
        if (!$periodeAktif) {
            return redirect()->route('home')
                ->with('error', 'Tidak ada periode seleksi yang aktif!');
        }

        $hasil = HasilPerhitungan::where('periode_id', $periodeAktif->id)
            ->with('siswa')
            ->orderBy('ranking', 'asc')
            ->get();

        if ($hasil->isEmpty()) {
            return redirect()->back()
                ->with('error', 'Belum ada hasil perhitungan untuk diexport!');
        }

        $data = [
            'periode' => $periodeAktif,
            'hasil' => $hasil,
            'tanggal' => now()->format('d F Y'),
        ];

        $pdf = Pdf::loadView('exports.ranking-pdf', $data)
            ->setPaper('a4', 'landscape');

        return $pdf->download('Ranking_Beasiswa_' . $periodeAktif->tahun_ajaran . '.pdf');
    }

    /**
     * Export Ranking ke Excel
     */
    public function rankingExcel()
    {
        $periodeAktif = PeriodeSeleksi::where('status', 'aktif')->first();
        
        if (!$periodeAktif) {
            return redirect()->route('home')
                ->with('error', 'Tidak ada periode seleksi yang aktif!');
        }

        return Excel::download(
            new RankingExport($periodeAktif->id), 
            'Ranking_Beasiswa_' . $periodeAktif->tahun_ajaran . '.xlsx'
        );
    }

    /**
     * Export Detail Perhitungan ke PDF
     */
    public function detailPdf()
    {
        $periodeAktif = PeriodeSeleksi::where('status', 'aktif')->first();
        
        if (!$periodeAktif) {
            return redirect()->route('home')
                ->with('error', 'Tidak ada periode seleksi yang aktif!');
        }

        $siswa = Siswa::active()->orderBy('nis')->get();
        $kriteria = Kriteria::active()->orderBy('kode_kriteria')->get();
        
        $penilaian = [];
        foreach ($siswa as $s) {
            $nilai = [];
            foreach ($kriteria as $k) {
                $p = PenilaianSiswa::where('periode_id', $periodeAktif->id)
                    ->where('siswa_id', $s->id)
                    ->where('kriteria_id', $k->id)
                    ->first();
                $nilai[$k->id] = $p ? $p->nilai : '-';
            }
            $penilaian[$s->id] = $nilai;
        }

        $data = [
            'periode' => $periodeAktif,
            'siswa' => $siswa,
            'kriteria' => $kriteria,
            'penilaian' => $penilaian,
            'tanggal' => now()->format('d F Y'),
        ];

        $pdf = Pdf::loadView('exports.detail-pdf', $data)
            ->setPaper('a4', 'landscape');

        return $pdf->download('Detail_Penilaian_' . $periodeAktif->tahun_ajaran . '.pdf');
    }

    /**
     * Export Detail Perhitungan ke Excel
     */
    public function detailExcel()
    {
        $periodeAktif = PeriodeSeleksi::where('status', 'aktif')->first();
        
        if (!$periodeAktif) {
            return redirect()->route('home')
                ->with('error', 'Tidak ada periode seleksi yang aktif!');
        }

        return Excel::download(
            new DetailPerhitunganExport($periodeAktif->id), 
            'Detail_Penilaian_' . $periodeAktif->tahun_ajaran . '.xlsx'
        );
    }

    /**
     * Export Laporan Lengkap ke PDF
     */
    public function laporanLengkapPdf()
    {
        $periodeAktif = PeriodeSeleksi::where('status', 'aktif')->first();
        
        if (!$periodeAktif) {
            return redirect()->route('home')
                ->with('error', 'Tidak ada periode seleksi yang aktif!');
        }

        $hasil = HasilPerhitungan::where('periode_id', $periodeAktif->id)
            ->with('siswa')
            ->orderBy('ranking', 'asc')
            ->get();

        $kriteria = Kriteria::active()->orderBy('kode_kriteria')->get();

        $data = [
            'periode' => $periodeAktif,
            'hasil' => $hasil,
            'kriteria' => $kriteria,
            'tanggal' => now()->format('d F Y'),
        ];

        $pdf = Pdf::loadView('exports.laporan-lengkap-pdf', $data)
            ->setPaper('a4', 'portrait');

        return $pdf->download('Laporan_Lengkap_Beasiswa_' . $periodeAktif->tahun_ajaran . '.pdf');
    }

    /**
     * Halaman index export
     */
    public function index()
    {
        return view('exports.index');
    }

}