<?php

namespace App\Services;

class FuzzyAhpService
{
    /**
     * Tabel konversi nilai crisp ke Fuzzy Triangular Number
     */
    private $fuzzyScale = [
        1 => [1, 1, 1],      // Sama penting
        2 => [1, 2, 3],      // Antara 1 dan 3
        3 => [2, 3, 4],      // Sedikit lebih penting
        4 => [3, 4, 5],      // Antara 3 dan 5
        5 => [4, 5, 6],      // Lebih penting
        6 => [5, 6, 7],      // Antara 5 dan 7
        7 => [6, 7, 8],      // Sangat lebih penting
        8 => [7, 8, 9],      // Antara 7 dan 9
        9 => [8, 9, 9],      // Mutlak lebih penting
    ];

    /**
     * Random Index untuk perhitungan CR
     */
    private $randomIndex = [
        1 => 0,
        2 => 0,
        3 => 0.58,
        4 => 0.90,
        5 => 1.12,
        6 => 1.24,
        7 => 1.32,
        8 => 1.41,
        9 => 1.45,
        10 => 1.49,
    ];

    /**
     * Konversi nilai crisp ke fuzzy triangular
     */
    public function crispToFuzzy($crisp)
    {
        $crisp = round($crisp);
        
        if (isset($this->fuzzyScale[$crisp])) {
            return $this->fuzzyScale[$crisp];
        }
        
        // Jika nilai reciprocal (1/x)
        if ($crisp < 1 && $crisp > 0) {
            $inverseCrisp = round(1 / $crisp);
            if (isset($this->fuzzyScale[$inverseCrisp])) {
                $fuzzy = $this->fuzzyScale[$inverseCrisp];
                return [1 / $fuzzy[2], 1 / $fuzzy[1], 1 / $fuzzy[0]];
            }
        }
        
        return [1, 1, 1];
    }

    /**
     * Hitung Synthetic Extent (Si) untuk setiap kriteria
     */
    public function calculateSyntheticExtent($fuzzyMatrix, $n)
    {
        $syntheticExtent = [];
        
        // Hitung sum untuk setiap baris
        for ($i = 0; $i < $n; $i++) {
            $rowSum = [0, 0, 0];
            for ($j = 0; $j < $n; $j++) {
                $rowSum[0] += $fuzzyMatrix[$i][$j][0];
                $rowSum[1] += $fuzzyMatrix[$i][$j][1];
                $rowSum[2] += $fuzzyMatrix[$i][$j][2];
            }
            $syntheticExtent[$i] = $rowSum;
        }
        
        // Hitung total sum dari semua baris
        $totalSum = [0, 0, 0];
        for ($i = 0; $i < $n; $i++) {
            $totalSum[0] += $syntheticExtent[$i][0];
            $totalSum[1] += $syntheticExtent[$i][1];
            $totalSum[2] += $syntheticExtent[$i][2];
        }
        
        // Normalisasi: Si = row_sum / total_sum
        // Si = (l, m, u) / (U, M, L) = (l/U, m/M, u/L)
        for ($i = 0; $i < $n; $i++) {
            $syntheticExtent[$i] = [
                $syntheticExtent[$i][0] / $totalSum[2],
                $syntheticExtent[$i][1] / $totalSum[1],
                $syntheticExtent[$i][2] / $totalSum[0],
            ];
        }
        
        return $syntheticExtent;
    }

    /**
     * Hitung degree of possibility V(S1 >= S2)
     */
    public function degreeOfPossibility($s1, $s2)
    {
        if ($s1[1] >= $s2[1]) {
            return 1;
        } elseif ($s2[0] >= $s1[2]) {
            return 0;
        } else {
            return ($s2[0] - $s1[2]) / (($s1[1] - $s1[2]) - ($s2[1] - $s2[0]));
        }
    }

    /**
     * Hitung bobot kriteria dari Fuzzy-AHP
     */
    public function calculateWeights($fuzzyMatrix, $n)
    {
        // 1. Hitung Synthetic Extent
        $syntheticExtent = $this->calculateSyntheticExtent($fuzzyMatrix, $n);
        
        // 2. Hitung degree of possibility untuk setiap pasangan
        $weights = [];
        for ($i = 0; $i < $n; $i++) {
            $minValues = [];
            for ($j = 0; $j < $n; $j++) {
                if ($i != $j) {
                    $v = $this->degreeOfPossibility($syntheticExtent[$i], $syntheticExtent[$j]);
                    $minValues[] = $v;
                }
            }
            $weights[$i] = empty($minValues) ? 1 : min($minValues);
        }
        
        // 3. Normalisasi bobot
        $sumWeights = array_sum($weights);
        if ($sumWeights > 0) {
            for ($i = 0; $i < $n; $i++) {
                $weights[$i] = $weights[$i] / $sumWeights;
            }
        }
        
        return $weights;
    }

    /**
     * Konversi fuzzy matrix ke crisp matrix (untuk CR)
     */
    public function fuzzyToCrispMatrix($fuzzyMatrix, $n)
    {
        $crispMatrix = [];
        for ($i = 0; $i < $n; $i++) {
            for ($j = 0; $j < $n; $j++) {
                // Gunakan middle value (m) sebagai crisp
                $crispMatrix[$i][$j] = $fuzzyMatrix[$i][$j][1];
            }
        }
        return $crispMatrix;
    }

    /**
     * Hitung Consistency Ratio (CR)
     */
    public function calculateConsistencyRatio($crispMatrix, $n)
    {
        // Hitung bobot dengan AHP biasa (tidak fuzzy)
        $columnSum = array_fill(0, $n, 0);
        for ($i = 0; $i < $n; $i++) {
            for ($j = 0; $j < $n; $j++) {
                $columnSum[$j] += $crispMatrix[$i][$j];
            }
        }
        
        // Normalisasi matrix
        $normalizedMatrix = [];
        for ($i = 0; $i < $n; $i++) {
            for ($j = 0; $j < $n; $j++) {
                $normalizedMatrix[$i][$j] = $crispMatrix[$i][$j] / $columnSum[$j];
            }
        }
        
        // Hitung rata-rata per baris (priority vector)
        $priorityVector = [];
        for ($i = 0; $i < $n; $i++) {
            $sum = 0;
            for ($j = 0; $j < $n; $j++) {
                $sum += $normalizedMatrix[$i][$j];
            }
            $priorityVector[$i] = $sum / $n;
        }
        
        // Hitung weighted sum vector
        $weightedSum = array_fill(0, $n, 0);
        for ($i = 0; $i < $n; $i++) {
            for ($j = 0; $j < $n; $j++) {
                $weightedSum[$i] += $crispMatrix[$i][$j] * $priorityVector[$j];
            }
        }
        
        // Hitung lambda max
        $lambdaMax = 0;
        for ($i = 0; $i < $n; $i++) {
            if ($priorityVector[$i] != 0) {
                $lambdaMax += $weightedSum[$i] / $priorityVector[$i];
            }
        }
        $lambdaMax = $lambdaMax / $n;
        
        // Hitung CI (Consistency Index)
        $ci = ($lambdaMax - $n) / ($n - 1);
        
        // Hitung CR (Consistency Ratio)
        $ri = $this->randomIndex[$n] ?? 1.24;
        $cr = $ri != 0 ? $ci / $ri : 0;
        
        return [
            'lambda_max' => $lambdaMax,
            'ci' => $ci,
            'ri' => $ri,
            'cr' => $cr,
        ];
    }

    /**
     * Proses lengkap Fuzzy-AHP
     */
    public function process($comparisonMatrix, $n)
    {
        // 1. Konversi crisp ke fuzzy
        $fuzzyMatrix = [];
        for ($i = 0; $i < $n; $i++) {
            for ($j = 0; $j < $n; $j++) {
                $fuzzyMatrix[$i][$j] = $this->crispToFuzzy($comparisonMatrix[$i][$j]);
            }
        }
        
        // 2. Hitung bobot
        $weights = $this->calculateWeights($fuzzyMatrix, $n);
        
        // 3. Hitung CR
        $crispMatrix = $this->fuzzyToCrispMatrix($fuzzyMatrix, $n);
        $consistency = $this->calculateConsistencyRatio($crispMatrix, $n);
        
        return [
            'fuzzy_matrix' => $fuzzyMatrix,
            'weights' => $weights,
            'consistency' => $consistency,
        ];
    }
}