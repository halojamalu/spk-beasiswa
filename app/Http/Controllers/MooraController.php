<?php

namespace App\Http\Controllers;

use App\Models\PeriodeSeleksi;
use App\Models\HasilPerhitungan;
use App\Models\LogPerhitungan;
use App\Services\MooraService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class MooraController extends Controller
{
    protected $mooraService;

    public function __construct(MooraService $mooraService)
    {
        $this->middleware('auth');
        $this->mooraService = $mooraService;
    }

    /**
     * Halaman utama MOORA
     */
    public function index()
    {
        $periodeAktif = PeriodeSeleksi::where('status', 'aktif')->first();
        
        if (!$periodeAktif) {
            return redirect()->route('home')
                ->with('error', 'Tidak ada periode seleksi yang aktif!');
        }

        // Cek apakah sudah ada hasil perhitungan
        $hasilCount = HasilPerhitungan::where('periode_id', $periodeAktif->id)->count();

        return view('moora.index', compact('periodeAktif', 'hasilCount'));
    }

    /**
     * Hitung ranking dengan MOORA
     */
    public function calculate()
    {
        $periodeAktif = PeriodeSeleksi::where('status', 'aktif')->first();
        
        if (!$periodeAktif) {
            return redirect()->route('home')
                ->with('error', 'Tidak ada periode seleksi yang aktif!');
        }

        DB::beginTransaction();
        try {
            // Proses MOORA
            $result = $this->mooraService->process($periodeAktif->id);
            
            // Tentukan status berdasarkan kuota
            $ranking = $this->mooraService->determineStatus(
                $result['ranking'], 
                $periodeAktif->kuota_beasiswa
            );
            
            // Hapus hasil perhitungan lama
            HasilPerhitungan::where('periode_id', $periodeAktif->id)->delete();
            
            // Simpan hasil ke database
            foreach ($ranking as $item) {
                HasilPerhitungan::create([
                    'periode_id' => $periodeAktif->id,
                    'siswa_id' => $item['siswa_id'],
                    'nilai_moora' => $item['nilai_yi'],
                    'ranking' => $item['ranking'],
                    'status_penerima' => $item['status_penerima'],
                ]);
            }
            
            // Log perhitungan
            LogPerhitungan::create([
                'periode_id' => $periodeAktif->id,
                'user_id' => Auth::id(),
                'jenis_proses' => 'moora',
                'detail_proses' => json_encode([
                    'total_siswa' => count($ranking),
                    'kuota' => $periodeAktif->kuota_beasiswa,
                ]),
                'keterangan' => 'Perhitungan ranking siswa dengan MOORA',
            ]);
            
            DB::commit();

            // Tambahkan ranking ke result untuk ditampilkan
            $result['final_ranking'] = $ranking;

            return view('moora.result', compact('periodeAktif', 'result'));

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal melakukan perhitungan: ' . $e->getMessage());
        }
    }

    /**
     * Tampilkan hasil ranking
     */
    public function ranking()
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
            return redirect()->route('moora.index')
                ->with('error', 'Belum ada hasil perhitungan! Silakan lakukan perhitungan terlebih dahulu.');
        }

        return view('moora.ranking', compact('periodeAktif', 'hasil'));
    }

    /**
     * Reset perhitungan MOORA
     */
    public function reset(Request $request)
    {
        $periodeId = $request->input('periode_id');

        DB::beginTransaction();
        try {
            // Hapus hasil perhitungan
            HasilPerhitungan::where('periode_id', $periodeId)->delete();
            
            // Log reset
            LogPerhitungan::create([
                'periode_id' => $periodeId,
                'user_id' => Auth::id(),
                'jenis_proses' => 'reset',
                'detail_proses' => json_encode(['action' => 'reset_moora']),
                'keterangan' => 'Reset perhitungan MOORA',
            ]);

            DB::commit();

            return redirect()->route('moora.index')
                ->with('success', 'Hasil perhitungan MOORA berhasil direset!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal mereset data: ' . $e->getMessage());
        }
    }
}