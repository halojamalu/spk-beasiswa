@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-trophy"></i> Daftar Ranking Penerima Beasiswa</h5>
                    <span class="badge bg-light text-dark">{{ $hasil->count() }} Siswa</span>
                </div>

                <div class="card-body">
                    <!-- Info Periode -->
                    <div class="alert alert-info">
                        <div class="row">
                            <div class="col-md-6">
                                <strong>Periode:</strong> {{ $periodeAktif->nama_periode }}<br>
                                <strong>Tahun Ajaran:</strong> {{ $periodeAktif->tahun_ajaran }}
                            </div>
                            <div class="col-md-6 text-end">
                                <strong>Kuota Beasiswa:</strong> {{ $periodeAktif->kuota_beasiswa }} siswa<br>
                                <strong>Penerima Layak:</strong> {{ $hasil->where('status_penerima', 'layak')->count() }} siswa
                            </div>
                        </div>
                    </div>

                    <!-- Filter Status -->
                    <div class="btn-group mb-3" role="group">
                        <button type="button" class="btn btn-outline-success active" onclick="filterStatus('all')">
                            <i class="fas fa-list"></i> Semua ({{ $hasil->count() }})
                        </button>
                        <button type="button" class="btn btn-outline-success" onclick="filterStatus('layak')">
                            <i class="fas fa-check-circle"></i> Layak ({{ $hasil->where('status_penerima', 'layak')->count() }})
                        </button>
                        <button type="button" class="btn btn-outline-warning" onclick="filterStatus('cadangan')">
                            <i class="fas fa-clock"></i> Cadangan ({{ $hasil->where('status_penerima', 'cadangan')->count() }})
                        </button>
                        <button type="button" class="btn btn-outline-secondary" onclick="filterStatus('tidak_layak')">
                            <i class="fas fa-times-circle"></i> Tidak Layak ({{ $hasil->where('status_penerima', 'tidak_layak')->count() }})
                        </button>
                    </div>

                    <!-- Tabel Ranking -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="tableRanking">
                            <thead class="table-dark">
                                <tr>
                                    <th width="8%" class="text-center">Ranking</th>
                                    <th width="10%">NIS</th>
                                    <th width="25%">Nama Siswa</th>
                                    <th width="10%">Kelas</th>
                                    <th width="12%">Nama Orang Tua</th>
                                    <th width="15%" class="text-center">Nilai Yi (MOORA)</th>
                                    <th width="20%" class="text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($hasil as $item)
                                <tr data-status="{{ $item->status_penerima }}" 
                                    class="{{ $item->status_penerima == 'layak' ? 'table-success' : ($item->status_penerima == 'cadangan' ? 'table-warning' : '') }}">
                                    <td class="text-center">
                                        <strong class="fs-5">
                                            {{ $item->ranking }}
                                            @if($item->ranking <= 3)
                                                @if($item->ranking == 1) 🥇
                                                @elseif($item->ranking == 2) 🥈
                                                @elseif($item->ranking == 3) 🥉
                                                @endif
                                            @endif
                                        </strong>
                                    </td>
                                    <td>{{ $item->siswa->nis }}</td>
                                    <td>
                                        <strong>{{ $item->siswa->nama_lengkap }}</strong><br>
                                        <small class="text-muted">{{ $item->siswa->jenis_kelamin_lengkap }}</small>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-primary">{{ $item->siswa->kelas }}</span>
                                    </td>
                                    <td>{{ $item->siswa->nama_ortu ?? '-' }}</td>
                                    <td class="text-center">
                                        <strong class="text-primary">{{ number_format($item->nilai_moora, 6) }}</strong>
                                    </td>
                                    <td class="text-center">
                                        @if($item->status_penerima == 'layak')
                                            <span class="badge bg-success fs-6">
                                                <i class="fas fa-check-circle"></i> LAYAK MENERIMA
                                            </span>
                                        @elseif($item->status_penerima == 'cadangan')
                                            <span class="badge bg-warning fs-6">
                                                <i class="fas fa-clock"></i> CADANGAN
                                            </span>
                                        @else
                                            <span class="badge bg-secondary fs-6">
                                                <i class="fas fa-times-circle"></i> TIDAK LAYAK
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Summary -->
                    <div class="row mt-4">
                        <div class="col-md-4">
                            <div class="card border-success">
                                <div class="card-body text-center">
                                    <h1 class="text-success">{{ $hasil->where('status_penerima', 'layak')->count() }}</h1>
                                    <p class="mb-0">Siswa Layak Menerima</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card border-warning">
                                <div class="card-body text-center">
                                    <h1 class="text-warning">{{ $hasil->where('status_penerima', 'cadangan')->count() }}</h1>
                                    <p class="mb-0">Siswa Cadangan</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card border-secondary">
                                <div class="card-body text-center">
                                    <h1 class="text-secondary">{{ $hasil->where('status_penerima', 'tidak_layak')->count() }}</h1>
                                    <p class="mb-0">Siswa Tidak Layak</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ route('moora.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        <div class="btn-group">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown">
                                <i class="fas fa-download"></i> Export Laporan
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <h6 class="dropdown-header">Export Ranking</h6>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('export.ranking.pdf') }}" target="_blank">
                                        <i class="fas fa-file-pdf text-danger"></i> Ranking (PDF)
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('export.ranking.excel') }}">
                                        <i class="fas fa-file-excel text-success"></i> Ranking (Excel)
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <h6 class="dropdown-header">Export Detail</h6>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('export.detail.pdf') }}" target="_blank">
                                        <i class="fas fa-file-pdf text-danger"></i> Detail Penilaian (PDF)
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('export.detail.excel') }}">
                                        <i class="fas fa-file-excel text-success"></i> Detail Penilaian (Excel)
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('export.laporan.pdf') }}" target="_blank">
                                        <i class="fas fa-file-pdf text-danger"></i> Laporan Lengkap (PDF)
                                    </a>
                                </li>
                            </ul>
                            <a href="{{ route('moora.calculate') }}" class="btn btn-info">
                                <i class="fas fa-calculator"></i> Lihat Detail Perhitungan
                            </a>
                            <button onclick="window.print()" class="btn btn-success">
                                <i class="fas fa-print"></i> Cetak
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function filterStatus(status) {
    const rows = document.querySelectorAll('#tableRanking tbody tr');
    const buttons = document.querySelectorAll('.btn-group button');
    
    // Reset button active state
    buttons.forEach(btn => btn.classList.remove('active'));
    
    if (status === 'all') {
        rows.forEach(row => row.style.display = '');
        buttons[0].classList.add('active');
    } else {
        rows.forEach(row => {
            if (row.getAttribute('data-status') === status) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
        
        // Set active button
        if (status === 'layak') buttons[1].classList.add('active');
        else if (status === 'cadangan') buttons[2].classList.add('active');
        else if (status === 'tidak_layak') buttons[3].classList.add('active');
    }
}
</script>

<style>
@media print {
    .btn, .card-header, .card-footer, nav, .btn-group { display: none !important; }
    .card { border: 1px solid #000 !important; }
    tr { page-break-inside: avoid; }
}
</style>
@endsection