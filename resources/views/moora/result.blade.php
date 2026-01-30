@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <!-- Header Result -->
            <div class="card mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-check-circle"></i> Hasil Perhitungan MOORA</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-success">
                        <h6 class="alert-heading"><i class="fas fa-info-circle"></i> Informasi Perhitungan</h6>
                        <p class="mb-0">
                            <strong>Periode:</strong> {{ $periodeAktif->nama_periode }}<br>
                            <strong>Tahun Ajaran:</strong> {{ $periodeAktif->tahun_ajaran }}<br>
                            <strong>Kuota Beasiswa:</strong> {{ $periodeAktif->kuota_beasiswa }} siswa<br>
                            <strong>Total Siswa Dinilai:</strong> {{ count($result['siswa']) }} siswa<br>
                            <strong>Tanggal Perhitungan:</strong> {{ now()->format('d F Y, H:i') }} WIB
                        </p>
                    </div>
                </div>
            </div>

            <!-- Matriks Keputusan -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h6 class="mb-0"><i class="fas fa-table"></i> Matriks Keputusan Awal</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th width="5%" class="text-center">No</th>
                                    <th width="10%">NIS</th>
                                    <th width="20%">Nama Siswa</th>
                                    @foreach($result['kriteria'] as $k)
                                        <th class="text-center">{{ $k->kode_kriteria }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($result['siswa'] as $i => $s)
                                <tr>
                                    <td class="text-center">{{ $i + 1 }}</td>
                                    <td>{{ $s->nis }}</td>
                                    <td>{{ $s->nama_lengkap }}</td>
                                    @foreach($result['decision_matrix'][$i] as $nilai)
                                        <td class="text-center">{{ number_format($nilai, 2) }}</td>
                                    @endforeach
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Matriks Ternormalisasi -->
            <div class="card mb-4">
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0"><i class="fas fa-calculator"></i> Matriks Ternormalisasi</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm table-hover">
                            <thead class="table-info">
                                <tr>
                                    <th width="5%" class="text-center">No</th>
                                    <th width="30%">Nama Siswa</th>
                                    @foreach($result['kriteria'] as $k)
                                        <th class="text-center">{{ $k->kode_kriteria }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($result['siswa'] as $i => $s)
                                <tr>
                                    <td class="text-center">{{ $i + 1 }}</td>
                                    <td>{{ $s->nama_lengkap }}</td>
                                    @foreach($result['normalized_matrix'][$i] as $nilai)
                                        <td class="text-center">{{ number_format($nilai, 4) }}</td>
                                    @endforeach
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Bobot Kriteria -->
            <div class="card mb-4">
                <div class="card-header bg-warning text-dark">
                    <h6 class="mb-0"><i class="fas fa-weight"></i> Bobot Kriteria yang Digunakan</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-warning">
                                <tr>
                                    <th class="text-center">Kode</th>
                                    <th>Nama Kriteria</th>
                                    <th class="text-center">Jenis</th>
                                    <th class="text-center">Bobot</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($result['kriteria'] as $k)
                                <tr>
                                    <td class="text-center"><strong>{{ $k->kode_kriteria }}</strong></td>
                                    <td>{{ $k->nama_kriteria }}</td>
                                    <td class="text-center">
                                        @if($k->jenis == 'benefit')
                                            <span class="badge bg-success">Benefit</span>
                                        @else
                                            <span class="badge bg-danger">Cost</span>
                                        @endif
                                    </td>
                                    <td class="text-center"><strong>{{ number_format($k->bobot, 4) }}</strong></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Matriks Terbobot -->
            <div class="card mb-4">
                <div class="card-header bg-secondary text-white">
                    <h6 class="mb-0"><i class="fas fa-balance-scale"></i> Matriks Terbobot (Normalisasi × Bobot)</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm table-hover">
                            <thead class="table-secondary">
                                <tr>
                                    <th width="5%" class="text-center">No</th>
                                    <th width="30%">Nama Siswa</th>
                                    @foreach($result['kriteria'] as $k)
                                        <th class="text-center">{{ $k->kode_kriteria }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($result['siswa'] as $i => $s)
                                <tr>
                                    <td class="text-center">{{ $i + 1 }}</td>
                                    <td>{{ $s->nama_lengkap }}</td>
                                    @foreach($result['weighted_matrix'][$i] as $nilai)
                                        <td class="text-center">{{ number_format($nilai, 4) }}</td>
                                    @endforeach
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Hasil Ranking -->
            <div class="card mb-4">
                <div class="card-header bg-success text-white">
                    <h6 class="mb-0"><i class="fas fa-trophy"></i> Hasil Ranking Siswa (Nilai Yi & Status)</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-success">
                                <tr>
                                    <th width="5%" class="text-center">Rank</th>
                                    <th width="10%">NIS</th>
                                    <th width="25%">Nama Siswa</th>
                                    <th width="10%">Kelas</th>
                                    <th width="15%" class="text-center">Nilai Yi</th>
                                    <th width="15%" class="text-center">Status</th>
                                    <th width="20%" class="text-center">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($result['final_ranking'] as $item)
                                <tr class="{{ $item['status_penerima'] == 'layak' ? 'table-success' : ($item['status_penerima'] == 'cadangan' ? 'table-warning' : '') }}">
                                    <td class="text-center">
                                        <strong class="fs-5">{{ $item['ranking'] }}</strong>
                                        @if($item['ranking'] <= 3)
                                            @if($item['ranking'] == 1) 🥇
                                            @elseif($item['ranking'] == 2) 🥈
                                            @elseif($item['ranking'] == 3) 🥉
                                            @endif
                                        @endif
                                    </td>
                                    <td>{{ $item['siswa']->nis }}</td>
                                    <td><strong>{{ $item['siswa']->nama_lengkap }}</strong></td>
                                    <td class="text-center">{{ $item['siswa']->kelas }}</td>
                                    <td class="text-center">
                                        <strong class="text-primary">{{ number_format($item['nilai_yi'], 6) }}</strong>
                                    </td>
                                    <td class="text-center">
                                        @if($item['status_penerima'] == 'layak')
                                            <span class="badge bg-success">✓ LAYAK</span>
                                        @elseif($item['status_penerima'] == 'cadangan')
                                            <span class="badge bg-warning">⚠ CADANGAN</span>
                                        @else
                                            <span class="badge bg-secondary">✗ TIDAK LAYAK</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($item['status_penerima'] == 'layak')
                                            <small>Penerima Beasiswa</small>
                                        @elseif($item['status_penerima'] == 'cadangan')
                                            <small>Cadangan Penerima</small>
                                        @else
                                            <small>-</small>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="alert alert-info mt-3">
                        <strong><i class="fas fa-info-circle"></i> Keterangan Status:</strong>
                        <ul class="mb-0">
                            <li><span class="badge bg-success">LAYAK</span> = Ranking 1 - {{ $periodeAktif->kuota_beasiswa }} (Penerima Beasiswa)</li>
                            <li><span class="badge bg-warning">CADANGAN</span> = Cadangan jika ada yang mengundurkan diri</li>
                            <li><span class="badge bg-secondary">TIDAK LAYAK</span> = Tidak memenuhi kuota</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Aksi -->
            <div class="d-flex justify-content-between mb-4">
                <a href="{{ route('moora.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                <div class="btn-group">
                    <a href="{{ route('moora.ranking') }}" class="btn btn-primary">
                        <i class="fas fa-list"></i> Lihat Daftar Ranking
                    </a>
                    <button type="button" class="btn btn-success dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown">
                        <i class="fas fa-download"></i> Export
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
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
                            <a class="dropdown-item" href="{{ route('export.laporan.pdf') }}" target="_blank">
                                <i class="fas fa-file-pdf text-danger"></i> Laporan Lengkap (PDF)
                            </a>
                        </li>
                    </ul>
                    <button onclick="window.print()" class="btn btn-info">
                        <i class="fas fa-print"></i> Cetak
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    .btn, .card-header, nav, .alert { display: none !important; }
    .card { border: 1px solid #000 !important; }
}
</style>
@endsection