<?php

namespace App\Services;

use App\Models\Kriteria;
use App\Models\PenilaianSiswa;
use App\Models\Siswa;
use App\Models\PeriodeSeleksi;

class MooraService
{
    /**
     * Ambil data matriks keputusan
     */
    public function getDecisionMatrix($periodeId)
    {
        $siswa = Siswa::active()->orderBy('nis')->get();
        $kriteria = Kriteria::active()->orderBy('kode_kriteria')->get();
        
        $matrix = [];
        foreach ($siswa as $s) {
            $row = [];
            foreach ($kriteria as $k) {
                $nilai = PenilaianSiswa::where('periode_id', $periodeId)
                    ->where('siswa_id', $s->id)
                    ->where('kriteria_id', $k->id)
                    ->first();
                
                $row[] = $nilai ? (float) $nilai->nilai : 0;
            }
            $matrix[] = $row;
        }
        
        return [
            'matrix' => $matrix,
            'siswa' => $siswa,
            'kriteria' => $kriteria,
        ];
    }

    /**
     * Normalisasi matriks keputusan
     * Formula: xij* = xij / sqrt(sum(xij^2))
     */
    public function normalizeMatrix($matrix)
    {
        $m = count($matrix);        // jumlah siswa
        $n = count($matrix[0]);     // jumlah kriteria
        
        $normalized = [];
        
        // Hitung untuk setiap kolom (kriteria)
        for ($j = 0; $j < $n; $j++) {
            // Hitung sum of squares untuk kolom j
            $sumSquares = 0;
            for ($i = 0; $i < $m; $i++) {
                $sumSquares += pow($matrix[$i][$j], 2);
            }
            
            $sqrtSumSquares = sqrt($sumSquares);
            
            // Normalisasi setiap nilai di kolom j
            for ($i = 0; $i < $m; $i++) {
                if ($sqrtSumSquares != 0) {
                    $normalized[$i][$j] = $matrix[$i][$j] / $sqrtSumSquares;
                } else {
                    $normalized[$i][$j] = 0;
                }
            }
        }
        
        return $normalized;
    }

    /**
     * Kalikan matriks ternormalisasi dengan bobot
     */
    public function multiplyByWeights($normalized, $kriteria)
    {
        $m = count($normalized);
        $n = count($normalized[0]);
        
        $weighted = [];
        
        for ($i = 0; $i < $m; $i++) {
            for ($j = 0; $j < $n; $j++) {
                $weight = (float) $kriteria[$j]->bobot;
                $weighted[$i][$j] = $normalized[$i][$j] * $weight;
            }
        }
        
        return $weighted;
    }

    /**
     * Hitung nilai Yi (optimasi)
     * Yi = sum(benefit) - sum(cost)
     */
    public function calculateYi($weighted, $kriteria)
    {
        $m = count($weighted);
        $yi = [];
        
        for ($i = 0; $i < $m; $i++) {
            $sumBenefit = 0;
            $sumCost = 0;
            
            foreach ($kriteria as $j => $k) {
                if ($k->jenis == 'benefit') {
                    $sumBenefit += $weighted[$i][$j];
                } else { // cost
                    $sumCost += $weighted[$i][$j];
                }
            }
            
            $yi[$i] = $sumBenefit - $sumCost;
        }
        
        return $yi;
    }

    /**
     * Ranking berdasarkan Yi (descending)
     */
    public function ranking($yi, $siswa)
    {
        $results = [];
        
        foreach ($siswa as $i => $s) {
            $results[] = [
                'siswa_id' => $s->id,
                'siswa' => $s,
                'nilai_yi' => $yi[$i],
            ];
        }
        
        // Sort descending berdasarkan nilai_yi
        usort($results, function($a, $b) {
            return $b['nilai_yi'] <=> $a['nilai_yi'];
        });
        
        // Tambahkan ranking
        foreach ($results as $index => &$result) {
            $result['ranking'] = $index + 1;
        }
        
        return $results;
    }

    /**
     * Proses lengkap MOORA
     */
    public function process($periodeId)
    {
        // 1. Ambil data
        $data = $this->getDecisionMatrix($periodeId);
        $matrix = $data['matrix'];
        $siswa = $data['siswa'];
        $kriteria = $data['kriteria'];
        
        // Validasi bobot
        $totalBobot = $kriteria->sum('bobot');
        if ($totalBobot <= 0) {
            throw new \Exception('Bobot kriteria belum dihitung! Silakan hitung Fuzzy-AHP terlebih dahulu.');
        }
        
        // 2. Normalisasi
        $normalized = $this->normalizeMatrix($matrix);
        
        // 3. Kalikan dengan bobot
        $weighted = $this->multiplyByWeights($normalized, $kriteria);
        
        // 4. Hitung Yi
        $yi = $this->calculateYi($weighted, $kriteria);
        
        // 5. Ranking
        $ranking = $this->ranking($yi, $siswa);
        
        return [
            'decision_matrix' => $matrix,
            'normalized_matrix' => $normalized,
            'weighted_matrix' => $weighted,
            'yi_values' => $yi,
            'ranking' => $ranking,
            'siswa' => $siswa,
            'kriteria' => $kriteria,
        ];
    }

    /**
     * Tentukan status penerima berdasarkan kuota
     */
    public function determineStatus($ranking, $kuota)
    {
        $cadanganCount = ceil($kuota * 0.2); // 20% dari kuota sebagai cadangan
        
        foreach ($ranking as &$item) {
            if ($item['ranking'] <= $kuota) {
                $item['status_penerima'] = 'layak';
            } elseif ($item['ranking'] <= ($kuota + $cadanganCount)) {
                $item['status_penerima'] = 'cadangan';
            } else {
                $item['status_penerima'] = 'tidak_layak';
            }
        }
        
        return $ranking;
    }
}