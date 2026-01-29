<?php

namespace App\Http\Controllers;

use App\Models\PenilaianSiswa;
use App\Models\Siswa;
use App\Models\Kriteria;
use App\Models\PeriodeSeleksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenilaianSiswaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Halaman utama penilaian
     */
    public function index()
    {
        $periodeAktif = PeriodeSeleksi::where('status', 'aktif')->first();
        
        if (!$periodeAktif) {
            return redirect()->route('home')
                ->with('error', 'Tidak ada periode seleksi yang aktif!');
        }

        $kriteria = Kriteria::active()->orderBy('kode_kriteria')->get();
        $siswa = Siswa::active()->orderBy('nis')->get();

        // Hitung progress penilaian
        $totalSiswa = $siswa->count();
        $totalKriteria = $kriteria->count();
        $expectedTotal = $totalSiswa * $totalKriteria;
        $completedTotal = PenilaianSiswa::where('periode_id', $periodeAktif->id)->count();
        $progressPercentage = $expectedTotal > 0 ? ($completedTotal / $expectedTotal) * 100 : 0;

        // Progress per kriteria
        $progressPerKriteria = [];
        foreach ($kriteria as $k) {
            $completed = PenilaianSiswa::where('periode_id', $periodeAktif->id)
                ->where('kriteria_id', $k->id)
                ->count();
            $progressPerKriteria[$k->id] = [
                'completed' => $completed,
                'total' => $totalSiswa,
                'percentage' => $totalSiswa > 0 ? ($completed / $totalSiswa) * 100 : 0,
            ];
        }

        return view('penilaian.index', compact(
            'periodeAktif',
            'kriteria',
            'siswa',
            'expectedTotal',
            'completedTotal',
            'progressPercentage',
            'progressPerKriteria'
        ));
    }

    /**
     * Form input penilaian per kriteria
     */
    public function create(Request $request)
    {
        $periodeAktif = PeriodeSeleksi::where('status', 'aktif')->first();
        
        if (!$periodeAktif) {
            return redirect()->route('home')
                ->with('error', 'Tidak ada periode seleksi yang aktif!');
        }

        $kriteriaId = $request->get('kriteria_id');
        
        if (!$kriteriaId) {
            return redirect()->route('penilaian.index')
                ->with('error', 'Silakan pilih kriteria terlebih dahulu!');
        }

        $kriteria = Kriteria::findOrFail($kriteriaId);
        $siswa = Siswa::active()->orderBy('nis')->get();

        // Ambil data penilaian yang sudah ada
        $existingPenilaian = PenilaianSiswa::where('periode_id', $periodeAktif->id)
            ->where('kriteria_id', $kriteriaId)
            ->get()
            ->keyBy('siswa_id');

        return view('penilaian.create', compact(
            'periodeAktif',
            'kriteria',
            'siswa',
            'existingPenilaian'
        ));
    }

    /**
     * Simpan penilaian batch
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'periode_id' => 'required|exists:periode_seleksi,id',
            'kriteria_id' => 'required|exists:kriteria,id',
            'nilai' => 'required|array',
            'nilai.*' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            $periodeId = $validated['periode_id'];
            $kriteriaId = $validated['kriteria_id'];

            foreach ($validated['nilai'] as $siswaId => $nilai) {
                // Update or create
                PenilaianSiswa::updateOrCreate(
                    [
                        'periode_id' => $periodeId,
                        'siswa_id' => $siswaId,
                        'kriteria_id' => $kriteriaId,
                    ],
                    [
                        'nilai' => $nilai,
                    ]
                );
            }

            DB::commit();

            return redirect()->route('penilaian.index')
                ->with('success', 'Data penilaian berhasil disimpan!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal menyimpan data: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Lihat detail penilaian siswa
     */
    public function show($siswaId)
    {
        $periodeAktif = PeriodeSeleksi::where('status', 'aktif')->first();
        
        if (!$periodeAktif) {
            return redirect()->route('home')
                ->with('error', 'Tidak ada periode seleksi yang aktif!');
        }

        $siswa = Siswa::findOrFail($siswaId);
        $kriteria = Kriteria::active()->orderBy('kode_kriteria')->get();

        $penilaian = PenilaianSiswa::where('periode_id', $periodeAktif->id)
            ->where('siswa_id', $siswaId)
            ->with('kriteria')
            ->get()
            ->keyBy('kriteria_id');

        return view('penilaian.show', compact(
            'periodeAktif',
            'siswa',
            'kriteria',
            'penilaian'
        ));
    }

    /**
     * Hapus penilaian per kriteria
     */
    public function destroy(Request $request)
    {
        $validated = $request->validate([
            'periode_id' => 'required|exists:periode_seleksi,id',
            'kriteria_id' => 'required|exists:kriteria,id',
        ]);

        try {
            PenilaianSiswa::where('periode_id', $validated['periode_id'])
                ->where('kriteria_id', $validated['kriteria_id'])
                ->delete();

            return redirect()->route('penilaian.index')
                ->with('success', 'Data penilaian untuk kriteria ini berhasil dihapus!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}