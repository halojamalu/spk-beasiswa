<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use App\Models\PeriodeSeleksi;
use App\Models\PerbandinganKriteria;
use App\Models\LogPerhitungan;
use App\Services\FuzzyAhpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class FuzzyAhpController extends Controller
{
    protected $fuzzyAhpService;

    public function __construct(FuzzyAhpService $fuzzyAhpService)
    {
        $this->middleware('auth');
        $this->fuzzyAhpService = $fuzzyAhpService;
    }

    /**
     * Tampilkan halaman input perbandingan
     */
    public function index()
    {
        $periodeAktif = PeriodeSeleksi::where('status', 'aktif')->first();
        
        if (!$periodeAktif) {
            return redirect()->route('home')
                ->with('error', 'Tidak ada periode seleksi yang aktif!');
        }

        $kriteria = Kriteria::active()->orderBy('kode_kriteria')->get();

        if ($kriteria->count() < 2) {
            return redirect()->route('kriteria.index')
                ->with('error', 'Minimal harus ada 2 kriteria untuk melakukan perbandingan!');
        }

        // Cek apakah sudah ada data perbandingan
        $perbandingan = PerbandinganKriteria::where('periode_id', $periodeAktif->id)->get();

        return view('fuzzy-ahp.index', compact('periodeAktif', 'kriteria', 'perbandingan'));
    }

    /**
     * Tampilkan form input perbandingan
     */
    public function create()
    {
        $periodeAktif = PeriodeSeleksi::where('status', 'aktif')->first();
        
        if (!$periodeAktif) {
            return redirect()->route('home')
                ->with('error', 'Tidak ada periode seleksi yang aktif!');
        }

        $kriteria = Kriteria::active()->orderBy('kode_kriteria')->get();

        return view('fuzzy-ahp.create', compact('periodeAktif', 'kriteria'));
    }

    /**
     * Simpan data perbandingan
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'periode_id' => 'required|exists:periode_seleksi,id',
            'perbandingan' => 'required|array',
        ]);

        DB::beginTransaction();
        try {
            // Hapus data perbandingan lama untuk periode ini
            PerbandinganKriteria::where('periode_id', $validated['periode_id'])->delete();

            // Simpan data perbandingan baru
            foreach ($validated['perbandingan'] as $key => $nilai) {
                list($k1, $k2) = explode('_', $key);
                
                $fuzzy = $this->fuzzyAhpService->crispToFuzzy($nilai);
                
                PerbandinganKriteria::create([
                    'periode_id' => $validated['periode_id'],
                    'kriteria_1' => $k1,
                    'kriteria_2' => $k2,
                    'nilai_crisp' => $nilai,
                    'nilai_fuzzy_l' => $fuzzy[0],
                    'nilai_fuzzy_m' => $fuzzy[1],
                    'nilai_fuzzy_u' => $fuzzy[2],
                ]);
            }

            DB::commit();

            return redirect()->route('fuzzy-ahp.calculate')
                ->with('success', 'Data perbandingan berhasil disimpan! Silakan lakukan perhitungan.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal menyimpan data: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Hitung bobot dengan Fuzzy-AHP
     */
    public function calculate()
    {
        $periodeAktif = PeriodeSeleksi::where('status', 'aktif')->first();
        
        if (!$periodeAktif) {
            return redirect()->route('home')
                ->with('error', 'Tidak ada periode seleksi yang aktif!');
        }

        $kriteria = Kriteria::active()->orderBy('kode_kriteria')->get();
        $n = $kriteria->count();

        // Ambil data perbandingan
        $perbandingan = PerbandinganKriteria::where('periode_id', $periodeAktif->id)->get();

        if ($perbandingan->isEmpty()) {
            return redirect()->route('fuzzy-ahp.create')
                ->with('error', 'Belum ada data perbandingan kriteria! Silakan input terlebih dahulu.');
        }

        // Buat comparison matrix
        $comparisonMatrix = [];
        for ($i = 0; $i < $n; $i++) {
            for ($j = 0; $j < $n; $j++) {
                if ($i == $j) {
                    $comparisonMatrix[$i][$j] = 1;
                } else {
                    $k1 = $kriteria[$i]->id;
                    $k2 = $kriteria[$j]->id;
                    
                    $data = $perbandingan->where('kriteria_1', $k1)
                                        ->where('kriteria_2', $k2)
                                        ->first();
                    
                    if ($data) {
                        $comparisonMatrix[$i][$j] = $data->nilai_crisp;
                    } else {
                        // Reciprocal
                        $dataReciprocal = $perbandingan->where('kriteria_1', $k2)
                                                      ->where('kriteria_2', $k1)
                                                      ->first();
                        if ($dataReciprocal) {
                            $comparisonMatrix[$i][$j] = 1 / $dataReciprocal->nilai_crisp;
                        } else {
                            $comparisonMatrix[$i][$j] = 1;
                        }
                    }
                }
            }
        }

        // Proses Fuzzy-AHP
        $result = $this->fuzzyAhpService->process($comparisonMatrix, $n);

        // Simpan bobot ke database
        DB::beginTransaction();
        try {
            foreach ($kriteria as $index => $k) {
                $k->update(['bobot' => $result['weights'][$index]]);
            }

            // Log perhitungan
            LogPerhitungan::create([
                'periode_id' => $periodeAktif->id,
                'user_id' => Auth::id(),
                'jenis_proses' => 'fuzzy-ahp',
                'detail_proses' => json_encode($result),
                'keterangan' => 'Perhitungan bobot kriteria dengan Fuzzy-AHP',
            ]);

            DB::commit();

            return view('fuzzy-ahp.result', compact('periodeAktif', 'kriteria', 'result', 'comparisonMatrix'));

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal menyimpan hasil perhitungan: ' . $e->getMessage());
        }
    }

    /**
     * Reset perhitungan
     */
    public function reset(Request $request)
    {
        $periodeId = $request->input('periode_id');

        DB::beginTransaction();
        try {
            // Hapus data perbandingan
            PerbandinganKriteria::where('periode_id', $periodeId)->delete();

            // Reset bobot kriteria ke 0
            Kriteria::query()->update(['bobot' => 0]);

            // Log reset
            LogPerhitungan::create([
                'periode_id' => $periodeId,
                'user_id' => Auth::id(),
                'jenis_proses' => 'reset',
                'detail_proses' => json_encode(['action' => 'reset_fuzzy_ahp']),
                'keterangan' => 'Reset perhitungan Fuzzy-AHP',
            ]);

            DB::commit();

            return redirect()->route('fuzzy-ahp.index')
                ->with('success', 'Data perbandingan dan bobot kriteria berhasil direset!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal mereset data: ' . $e->getMessage());
        }
    }
}