@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-chart-line"></i> Perhitungan Ranking Siswa (MOORA)</h5>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Info Periode -->
                    <div class="alert alert-info">
                        <h6 class="alert-heading"><i class="fas fa-info-circle"></i> Informasi Periode Seleksi</h6>
                        <p class="mb-0">
                            <strong>Periode:</strong> {{ $periodeAktif->nama_periode }}<br>
                            <strong>Tahun Ajaran:</strong> {{ $periodeAktif->tahun_ajaran }}<br>
                            <strong>Kuota Beasiswa:</strong> <span class="badge bg-primary">{{ $periodeAktif->kuota_beasiswa }} siswa</span><br>
                            <strong>Status:</strong> <span class="badge bg-success">{{ strtoupper($periodeAktif->status) }}</span>
                        </p>
                    </div>

                    <!-- Prasyarat -->
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h6 class="mb-0"><i class="fas fa-clipboard-check"></i> Prasyarat Perhitungan MOORA</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="card text-center">
                                        <div class="card-body">
                                            @php
                                                $kriteriaCount = \App\Models\Kriteria::active()->count();
                                                $bobotReady = \App\Models\Kriteria::active()->where('bobot', '>', 0)->count();
                                            @endphp
                                            <i class="fas fa-list-check fa-3x {{ $bobotReady == $kriteriaCount ? 'text-success' : 'text-warning' }} mb-3"></i>
                                            <h6>Data Kriteria</h6>
                                            <p class="mb-0">
                                                @if($bobotReady == $kriteriaCount)
                                                    <span class="badge bg-success">✓ Bobot Sudah Dihitung</span>
                                                @else
                                                    <span class="badge bg-warning">⚠ Hitung Fuzzy-AHP Dulu</span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card text-center">
                                        <div class="card-body">
                                            @php
                                                $siswaCount = \App\Models\Siswa::active()->count();
                                            @endphp
                                            <i class="fas fa-users fa-3x {{ $siswaCount > 0 ? 'text-success' : 'text-danger' }} mb-3"></i>
                                            <h6>Data Siswa</h6>
                                            <p class="mb-0">
                                                @if($siswaCount > 0)
                                                    <span class="badge bg-success">✓ {{ $siswaCount }} Siswa</span>
                                                @else
                                                    <span class="badge bg-danger">✗ Belum Ada Data</span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card text-center">
                                        <div class="card-body">
                                            @php
                                                $penilaianCount = \App\Models\PenilaianSiswa::where('periode_id', $periodeAktif->id)->count();
                                                $expectedCount = $siswaCount * $kriteriaCount;
                                            @endphp
                                            <i class="fas fa-clipboard-list fa-3x {{ $penilaianCount == $expectedCount ? 'text-success' : 'text-warning' }} mb-3"></i>
                                            <h6>Data Penilaian</h6>
                                            <p class="mb-0">
                                                @if($penilaianCount == $expectedCount)
                                                    <span class="badge bg-success">✓ Lengkap ({{ $penilaianCount }})</span>
                                                @else
                                                    <span class="badge bg-warning">{{ $penilaianCount }}/{{ $expectedCount }}</span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Status Perhitungan -->
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h6 class="mb-0"><i class="fas fa-tasks"></i> Status Perhitungan</h6>
                        </div>
                        <div class="card-body">
                            @if($hasilCount == 0)
                                <div class="alert alert-warning mb-0">
                                    <i class="fas fa-exclamation-triangle"></i> 
                                    Belum ada hasil perhitungan MOORA untuk periode ini.
                                </div>
                            @else
                                <div class="alert alert-success mb-0">
                                    <i class="fas fa-check-circle"></i> 
                                    Hasil perhitungan sudah tersedia ({{ $hasilCount }} siswa sudah diranking).
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Aksi -->
                    @php
                        $canCalculate = $bobotReady == $kriteriaCount && $siswaCount > 0 && $penilaianCount > 0;
                    @endphp

                    <div class="d-flex justify-content-between gap-2">
                        <a href="{{ route('home') }}" class="btn btn-secondary btn-lg">
                            <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
                        </a>
                        
                        <div class="btn-group">
                            @if(!$canCalculate)
                                <button class="btn btn-success" disabled title="Lengkapi prasyarat terlebih dahulu">
                                    <i class="fas fa-calculator"></i> Hitung Ranking (Disabled)
                                </button>
                            @else
                                <a href="{{ route('moora.calculate') }}" class="btn btn-success btn-lg">
                                    <i class="fas fa-calculator"></i> Hitung Ranking MOORA
                                </a>
                            @endif

                            @if($hasilCount > 0)
                                <a href="{{ route('moora.ranking') }}" class="btn btn-primary btn-lg">
                                    <i class="fas fa-trophy"></i> Lihat Hasil Ranking
                                </a>
                                <button type="button" class="btn btn-danger btn-lg" data-bs-toggle="modal" data-bs-target="#resetModal">
                                    <i class="fas fa-redo"></i> Reset
                                </button>
                            @endif
                        </div>
                    </div>

                    @if(!$canCalculate)
                        <div class="alert alert-warning mt-3">
                            <strong><i class="fas fa-info-circle"></i> Untuk melakukan perhitungan MOORA:</strong>
                            <ul class="mb-0 mt-2">
                                @if($bobotReady != $kriteriaCount)
                                    <li>Hitung bobot kriteria dengan <a href="{{ route('fuzzy-ahp.index') }}">Fuzzy-AHP</a> terlebih dahulu</li>
                                @endif
                                @if($siswaCount == 0)
                                    <li>Tambahkan data <a href="{{ route('siswa.index') }}">siswa</a></li>
                                @endif
                                @if($penilaianCount < $expectedCount)
                                    <li>Lengkapi data penilaian siswa (saat ini: {{ $penilaianCount }}/{{ $expectedCount }})</li>
                                @endif
                            </ul>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Info MOORA -->
            <div class="card mt-4">
                <div class="card-header bg-light">
                    <h6 class="mb-0"><i class="fas fa-question-circle"></i> Tentang MOORA</h6>
                </div>
                <div class="card-body">
                    <p><strong>MOORA (Multi-Objective Optimization on the basis of Ratio Analysis)</strong> adalah metode pengambilan keputusan multi-kriteria yang sederhana namun efektif untuk meranking alternatif.</p>
                    
                    <h6>Langkah-langkah MOORA:</h6>
                    <ol>
                        <li><strong>Matriks Keputusan:</strong> Membuat matriks m×n (m=siswa, n=kriteria)</li>
                        <li><strong>Normalisasi:</strong> xij* = xij / √(Σxij²)</li>
                        <li><strong>Optimasi:</strong> Yi = Σ(benefit × bobot) - Σ(cost × bobot)</li>
                        <li><strong>Ranking:</strong> Urutkan berdasarkan Yi (tertinggi = ranking 1)</li>
                    </ol>
                    
                    <h6>Kelebihan MOORA:</h6>
                    <ul class="mb-0">
                        <li>Perhitungan sederhana dan cepat</li>
                        <li>Dapat menangani kriteria benefit dan cost secara bersamaan</li>
                        <li>Hasil ranking yang objektif berdasarkan data numerik</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Reset -->
<div class="modal fade" id="resetModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title"><i class="fas fa-exclamation-triangle"></i> Konfirmasi Reset</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('moora.reset') }}" method="POST">
                @csrf
                <input type="hidden" name="periode_id" value="{{ $periodeAktif->id }}">
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin mereset hasil perhitungan MOORA?</p>
                    <div class="alert alert-warning">
                        <strong>Perhatian!</strong> Tindakan ini akan:
                        <ul class="mb-0">
                            <li>Menghapus semua hasil ranking siswa</li>
                            <li>Data tidak dapat dikembalikan</li>
                            <li>Anda perlu menghitung ulang</li>
                        </ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Ya, Reset Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection