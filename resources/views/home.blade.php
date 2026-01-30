@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <!-- Header Dashboard -->
            <div class="card mb-4 border-0 shadow-sm">
                <div class="card-body bg-primary text-white rounded">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h4 class="mb-2"><i class="fas fa-tachometer-alt"></i> Dashboard SPK Beasiswa</h4>
                            <p class="mb-0">Sistem Pendukung Keputusan Hibrid Fuzzy-AHP dan MOORA</p>
                            <p class="mb-0"><small>Madrasah Ibtidaiyah Daarul Ishlah Batam</small></p>
                        </div>
                        <div class="col-md-4 text-end">
                            <h6 class="mb-1">{{ now()->format('l, d F Y') }}</h6>
                            <p class="mb-0" id="clock">{{ now()->format('H:i:s') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Info Periode Aktif -->
            @if($periodeAktif)
            <div class="alert alert-info shadow-sm">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h6 class="alert-heading mb-2"><i class="fas fa-calendar-check"></i> Periode Seleksi Aktif</h6>
                        <strong>{{ $periodeAktif->nama_periode }}</strong> - {{ $periodeAktif->tahun_ajaran }}<br>
                        <small>
                            {{ $periodeAktif->tanggal_mulai->format('d M Y') }} s/d 
                            {{ $periodeAktif->tanggal_selesai->format('d M Y') }}
                        </small>
                    </div>
                    <div class="col-md-4 text-end">
                        <div class="badge bg-primary fs-6 px-3 py-2">
                            <i class="fas fa-award"></i> Kuota: {{ $periodeAktif->kuota_beasiswa }} Beasiswa
                        </div>
                    </div>
                </div>
            </div>
            @else
            <div class="alert alert-warning">
                <i class="fas fa-exclamation-triangle"></i> Tidak ada periode seleksi yang aktif saat ini.
            </div>
            @endif

            <!-- Statistik Cards -->
            <div class="row mb-4">
                <!-- Card Master Data -->
                <div class="col-md-3 mb-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="text-muted mb-2">Data Kriteria</h6>
                                    <h2 class="mb-0">{{ $totalKriteria }}</h2>
                                    <small class="text-success">
                                        <i class="fas fa-check"></i> {{ $kriteriaWithBobot }} dengan bobot
                                    </small>
                                </div>
                                <div>
                                    <div class="bg-primary bg-opacity-10 rounded p-3">
                                        <i class="fas fa-list-check fa-2x text-primary"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3">
                                <a href="{{ route('kriteria.index') }}" class="btn btn-sm btn-outline-primary w-100">
                                    <i class="fas fa-arrow-right"></i> Kelola Kriteria
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card Siswa -->
                <div class="col-md-3 mb-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="text-muted mb-2">Data Siswa</h6>
                                    <h2 class="mb-0">{{ $totalSiswa }}</h2>
                                    <small class="text-info">
                                        <i class="fas fa-male"></i> {{ $siswaLaki }} L | 
                                        <i class="fas fa-female"></i> {{ $siswaPerempuan }} P
                                    </small>
                                </div>
                                <div>
                                    <div class="bg-success bg-opacity-10 rounded p-3">
                                        <i class="fas fa-users fa-2x text-success"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3">
                                <a href="{{ route('siswa.index') }}" class="btn btn-sm btn-outline-success w-100">
                                    <i class="fas fa-arrow-right"></i> Kelola Siswa
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card Penilaian -->
                <div class="col-md-3 mb-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="text-muted mb-2">Data Penilaian</h6>
                                    <h2 class="mb-0">{{ $totalPenilaian }}</h2>
                                    <small class="text-warning">
                                        dari {{ $expectedPenilaian }} expected
                                    </small>
                                </div>
                                <div>
                                    <div class="bg-warning bg-opacity-10 rounded p-3">
                                        <i class="fas fa-clipboard-list fa-2x text-warning"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3">
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar bg-warning" style="width: {{ $persentasePenilaian }}%"></div>
                                </div>
                                <small class="text-muted">{{ number_format($persentasePenilaian, 1) }}% lengkap</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card Hasil -->
                <div class="col-md-3 mb-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="text-muted mb-2">Hasil Ranking</h6>
                                    <h2 class="mb-0">{{ $hasilCount }}</h2>
                                    <small class="text-success">
                                        <i class="fas fa-trophy"></i> {{ $hasilLayak }} layak
                                    </small>
                                </div>
                                <div>
                                    <div class="bg-danger bg-opacity-10 rounded p-3">
                                        <i class="fas fa-chart-line fa-2x text-danger"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3">
                                <a href="{{ route('moora.ranking') }}" class="btn btn-sm btn-outline-danger w-100">
                                    <i class="fas fa-arrow-right"></i> Lihat Ranking
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Quick Actions -->
                <div class="col-md-4 mb-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-bottom">
                            <h6 class="mb-0"><i class="fas fa-bolt"></i> Aksi Cepat</h6>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <a href="{{ route('fuzzy-ahp.index') }}" class="btn btn-outline-primary">
                                    <i class="fas fa-calculator"></i> Hitung Bobot (Fuzzy-AHP)
                                </a>
                                <a href="{{ route('moora.index') }}" class="btn btn-outline-success">
                                    <i class="fas fa-chart-line"></i> Hitung Ranking (MOORA)
                                </a>
                                <a href="{{ route('kriteria.create') }}" class="btn btn-outline-info">
                                    <i class="fas fa-plus"></i> Tambah Kriteria
                                </a>
                                <a href="{{ route('siswa.create') }}" class="btn btn-outline-warning">
                                    <i class="fas fa-user-plus"></i> Tambah Siswa
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Distribusi Siswa per Kelas -->
                    <div class="card border-0 shadow-sm mt-4">
                        <div class="card-header bg-white border-bottom">
                            <h6 class="mb-0"><i class="fas fa-chart-pie"></i> Siswa per Kelas</h6>
                        </div>
                        <div class="card-body">
                            @foreach($siswaPerKelas as $item)
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-1">
                                    <span>Kelas {{ $item->kelas }}</span>
                                    <strong>{{ $item->jumlah }} siswa</strong>
                                </div>
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar bg-primary" 
                                         style="width: {{ $totalSiswa > 0 ? ($item->jumlah / $totalSiswa) * 100 : 0 }}%">
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Top 10 Ranking -->
                <div class="col-md-8 mb-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
                            <h6 class="mb-0"><i class="fas fa-trophy"></i> Top 10 Ranking Siswa</h6>
                            <div class="btn-group">
                                @if($hasilCount > 0)
                                <a href="{{ route('moora.ranking') }}" class="btn btn-sm btn-outline-primary">
                                    Lihat Semua <i class="fas fa-arrow-right"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-success dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown">
                                    <i class="fas fa-download"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('export.ranking.pdf') }}" target="_blank">
                                            <i class="fas fa-file-pdf text-danger"></i> Export PDF
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('export.ranking.excel') }}">
                                            <i class="fas fa-file-excel text-success"></i> Export Excel
                                        </a>
                                    </li>
                                </ul>
                                @endif
                            </div>
                        </div>
                        <div class="card-body">
                            @if($topRanking->isEmpty())
                                <div class="text-center py-5 text-muted">
                                    <i class="fas fa-info-circle fa-3x mb-3"></i>
                                    <p>Belum ada hasil perhitungan ranking.</p>
                                    <a href="{{ route('moora.index') }}" class="btn btn-primary">
                                        <i class="fas fa-calculator"></i> Hitung Sekarang
                                    </a>
                                </div>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th width="10%" class="text-center">Rank</th>
                                                <th width="12%">NIS</th>
                                                <th width="30%">Nama Siswa</th>
                                                <th width="10%">Kelas</th>
                                                <th width="18%" class="text-center">Nilai Yi</th>
                                                <th width="20%" class="text-center">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($topRanking as $item)
                                            <tr class="{{ $item->status_penerima == 'layak' ? 'table-success' : '' }}">
                                                <td class="text-center">
                                                    <strong class="fs-5">
                                                        {{ $item->ranking }}
                                                        @if($item->ranking == 1) 🥇
                                                        @elseif($item->ranking == 2) 🥈
                                                        @elseif($item->ranking == 3) 🥉
                                                        @endif
                                                    </strong>
                                                </td>
                                                <td>{{ $item->siswa->nis }}</td>
                                                <td><strong>{{ $item->siswa->nama_lengkap }}</strong></td>
                                                <td><span class="badge bg-primary">{{ $item->siswa->kelas }}</span></td>
                                                <td class="text-center">
                                                    <strong class="text-primary">{{ number_format($item->nilai_moora, 4) }}</strong>
                                                </td>
                                                <td class="text-center">
                                                    @if($item->status_penerima == 'layak')
                                                        <span class="badge bg-success">LAYAK</span>
                                                    @elseif($item->status_penerima == 'cadangan')
                                                        <span class="badge bg-warning">CADANGAN</span>
                                                    @else
                                                        <span class="badge bg-secondary">TIDAK LAYAK</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Status Distribusi -->
                    @if($hasilCount > 0)
                    <div class="row mt-4">
                        <div class="col-md-4">
                            <div class="card border-0 shadow-sm border-start border-success border-4">
                                <div class="card-body text-center">
                                    <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                                    <h3 class="mb-0">{{ $hasilLayak }}</h3>
                                    <small class="text-muted">Siswa Layak</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card border-0 shadow-sm border-start border-warning border-4">
                                <div class="card-body text-center">
                                    <i class="fas fa-clock fa-2x text-warning mb-2"></i>
                                    <h3 class="mb-0">{{ $hasilCadangan }}</h3>
                                    <small class="text-muted">Siswa Cadangan</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card border-0 shadow-sm border-start border-secondary border-4">
                                <div class="card-body text-center">
                                    <i class="fas fa-times-circle fa-2x text-secondary mb-2"></i>
                                    <h3 class="mb-0">{{ $hasilTidakLayak }}</h3>
                                    <small class="text-muted">Tidak Layak</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Log Aktivitas -->
            @if($recentLogs->isNotEmpty())
            <div class="row">
                <div class="col-md-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-bottom">
                            <h6 class="mb-0"><i class="fas fa-history"></i> Aktivitas Terbaru</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-sm mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Waktu</th>
                                            <th>User</th>
                                            <th>Jenis Proses</th>
                                            <th>Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($recentLogs as $log)
                                        <tr>
                                            <td>{{ $log->created_at->format('d/m/Y H:i') }}</td>
                                            <td>{{ $log->user->name }}</td>
                                            <td>
                                                @if($log->jenis_proses == 'fuzzy-ahp')
                                                    <span class="badge bg-primary">Fuzzy-AHP</span>
                                                @elseif($log->jenis_proses == 'moora')
                                                    <span class="badge bg-success">MOORA</span>
                                                @else
                                                    <span class="badge bg-secondary">{{ strtoupper($log->jenis_proses) }}</span>
                                                @endif
                                            </td>
                                            <td>{{ $log->keterangan }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<script>
// Real-time clock
function updateClock() {
    const now = new Date();
    const hours = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');
    const seconds = String(now.getSeconds()).padStart(2, '0');
    document.getElementById('clock').textContent = `${hours}:${minutes}:${seconds}`;
}
setInterval(updateClock, 1000);
</script>
@endsection