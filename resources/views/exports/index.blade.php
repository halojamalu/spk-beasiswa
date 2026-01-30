@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-download"></i> Export & Cetak Laporan</h5>
                </div>

                <div class="card-body">
                    @php
                        $periodeAktif = \App\Models\PeriodeSeleksi::where('status', 'aktif')->first();
                        $hasilCount = $periodeAktif ? \App\Models\HasilPerhitungan::where('periode_id', $periodeAktif->id)->count() : 0;
                    @endphp

                    @if(!$periodeAktif)
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i> Tidak ada periode seleksi yang aktif!
                        </div>
                    @elseif($hasilCount == 0)
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> Belum ada hasil perhitungan untuk diexport. 
                            Silakan <a href="{{ route('moora.index') }}">hitung ranking MOORA</a> terlebih dahulu.
                        </div>
                    @else
                        <!-- Info Periode -->
                        <div class="alert alert-info">
                            <h6 class="alert-heading"><i class="fas fa-info-circle"></i> Informasi</h6>
                            <p class="mb-0">
                                <strong>Periode:</strong> {{ $periodeAktif->nama_periode }}<br>
                                <strong>Tahun Ajaran:</strong> {{ $periodeAktif->tahun_ajaran }}<br>
                                <strong>Total Hasil:</strong> {{ $hasilCount }} siswa
                            </p>
                        </div>

                        <!-- Export Options -->
                        <div class="row g-4 mt-2">
                            <!-- Ranking PDF -->
                            <div class="col-md-6">
                                <div class="card border-danger h-100">
                                    <div class="card-body text-center">
                                        <div class="mb-3">
                                            <i class="fas fa-file-pdf fa-4x text-danger"></i>
                                        </div>
                                        <h5 class="card-title">Ranking Siswa (PDF)</h5>
                                        <p class="card-text text-muted">
                                            Laporan ranking lengkap dengan status penerima dalam format PDF (Landscape)
                                        </p>
                                        <a href="{{ route('export.ranking.pdf') }}" target="_blank" class="btn btn-danger">
                                            <i class="fas fa-download"></i> Download PDF
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Ranking Excel -->
                            <div class="col-md-6">
                                <div class="card border-success h-100">
                                    <div class="card-body text-center">
                                        <div class="mb-3">
                                            <i class="fas fa-file-excel fa-4x text-success"></i>
                                        </div>
                                        <h5 class="card-title">Ranking Siswa (Excel)</h5>
                                        <p class="card-text text-muted">
                                            Data ranking dalam format Excel untuk analisis lebih lanjut
                                        </p>
                                        <a href="{{ route('export.ranking.excel') }}" class="btn btn-success">
                                            <i class="fas fa-download"></i> Download Excel
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Detail Penilaian PDF -->
                            <div class="col-md-6">
                                <div class="card border-danger h-100">
                                    <div class="card-body text-center">
                                        <div class="mb-3">
                                            <i class="fas fa-file-pdf fa-4x text-danger"></i>
                                        </div>
                                        <h5 class="card-title">Detail Penilaian (PDF)</h5>
                                        <p class="card-text text-muted">
                                            Detail nilai siswa per kriteria dalam format PDF (Landscape)
                                        </p>
                                        <a href="{{ route('export.detail.pdf') }}" target="_blank" class="btn btn-danger">
                                            <i class="fas fa-download"></i> Download PDF
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Detail Penilaian Excel -->
                            <div class="col-md-6">
                                <div class="card border-success h-100">
                                    <div class="card-body text-center">
                                        <div class="mb-3">
                                            <i class="fas fa-file-excel fa-4x text-success"></i>
                                        </div>
                                        <h5 class="card-title">Detail Penilaian (Excel)</h5>
                                        <p class="card-text text-muted">
                                            Detail nilai siswa per kriteria dalam format Excel
                                        </p>
                                        <a href="{{ route('export.detail.excel') }}" class="btn btn-success">
                                            <i class="fas fa-download"></i> Download Excel
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Laporan Lengkap -->
                            <div class="col-md-12">
                                <div class="card border-primary">
                                    <div class="card-body text-center">
                                        <div class="mb-3">
                                            <i class="fas fa-file-pdf fa-4x text-primary"></i>
                                        </div>
                                        <h5 class="card-title">Laporan Lengkap (PDF)</h5>
                                        <p class="card-text text-muted">
                                            Laporan komprehensif mencakup informasi periode, kriteria, metodologi, dan hasil ranking
                                        </p>
                                        <a href="{{ route('export.laporan.pdf') }}" target="_blank" class="btn btn-primary btn-lg">
                                            <i class="fas fa-download"></i> Download Laporan Lengkap
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tips -->
                        <div class="alert alert-success mt-4">
                            <h6 class="alert-heading"><i class="fas fa-lightbulb"></i> Tips:</h6>
                            <ul class="mb-0">
                                <li>File PDF akan terbuka di tab baru, Anda dapat langsung mencetak dari browser</li>
                                <li>File Excel dapat dibuka dengan Microsoft Excel atau Google Sheets</li>
                                <li>Gunakan Laporan Lengkap untuk dokumentasi resmi dan presentasi</li>
                            </ul>
                        </div>
                    @endif
                </div>

                <div class="card-footer">
                    <a href="{{ route('home') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection