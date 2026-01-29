@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <!-- Header Result -->
            <div class="card mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-check-circle"></i> Hasil Perhitungan Fuzzy-AHP</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-success">
                        <h6 class="alert-heading"><i class="fas fa-info-circle"></i> Informasi</h6>
                        <p class="mb-0">
                            <strong>Periode:</strong> {{ $periodeAktif->nama_periode }}<br>
                            <strong>Tahun Ajaran:</strong> {{ $periodeAktif->tahun_ajaran }}<br>
                            <strong>Tanggal Perhitungan:</strong> {{ now()->format('d F Y, H:i') }} WIB
                        </p>
                    </div>
                </div>
            </div>

            <!-- Matriks Perbandingan Crisp -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h6 class="mb-0"><i class="fas fa-table"></i> Matriks Perbandingan Berpasangan (Crisp)</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm">
                            <thead class="table-dark">
                                <tr>
                                    <th class="text-center">Kriteria</th>
                                    @foreach($kriteria as $k)
                                        <th class="text-center">{{ $k->kode_kriteria }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($kriteria as $i => $k1)
                                <tr>
                                    <td class="text-center table-secondary"><strong>{{ $k1->kode_kriteria }}</strong></td>
                                    @foreach($kriteria as $j => $k2)
                                        <td class="text-center">
                                            {{ number_format($comparisonMatrix[$i][$j], 4) }}
                                        </td>
                                    @endforeach
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Matriks Fuzzy -->
            <div class="card mb-4">
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0"><i class="fas fa-project-diagram"></i> Matriks Fuzzy Triangular (l, m, u)</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm">
                            <thead class="table-dark">
                                <tr>
                                    <th class="text-center">Kriteria</th>
                                    @foreach($kriteria as $k)
                                        <th class="text-center">{{ $k->kode_kriteria }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($kriteria as $i => $k1)
                                <tr>
                                    <td class="text-center table-secondary"><strong>{{ $k1->kode_kriteria }}</strong></td>
                                    @foreach($kriteria as $j => $k2)
                                        <td class="text-center" style="font-size: 0.85em;">
                                            ({{ number_format($result['fuzzy_matrix'][$i][$j][0], 2) }}, 
                                             {{ number_format($result['fuzzy_matrix'][$i][$j][1], 2) }}, 
                                             {{ number_format($result['fuzzy_matrix'][$i][$j][2], 2) }})
                                        </td>
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
                <div class="card-header bg-success text-white">
                    <h6 class="mb-0"><i class="fas fa-weight"></i> Bobot Kriteria (Hasil Akhir)</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-success">
                                <tr>
                                    <th width="10%" class="text-center">No</th>
                                    <th width="15%" class="text-center">Kode</th>
                                    <th width="45%">Nama Kriteria</th>
                                    <th width="15%" class="text-center">Bobot</th>
                                    <th width="15%" class="text-center">Persentase</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($kriteria as $i => $k)
                                <tr>
                                    <td class="text-center">{{ $i + 1 }}</td>
                                    <td class="text-center"><strong>{{ $k->kode_kriteria }}</strong></td>
                                    <td>{{ $k->nama_kriteria }}</td>
                                    <td class="text-center">
                                        <strong class="text-primary">{{ number_format($result['weights'][$i], 4) }}</strong>
                                    </td>
                                    <td class="text-center">
                                        <strong>{{ number_format($result['weights'][$i] * 100, 2) }}%</strong>
                                    </td>
                                </tr>
                                @endforeach
                                <tr class="table-secondary">
                                    <td colspan="3" class="text-end"><strong>TOTAL</strong></td>
                                    <td class="text-center"><strong>{{ number_format(array_sum($result['weights']), 4) }}</strong></td>
                                    <td class="text-center"><strong>100%</strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Consistency Ratio -->
            <div class="card mb-4">
                <div class="card-header {{ $result['consistency']['cr'] < 0.1 ? 'bg-success' : 'bg-danger' }} text-white">
                    <h6 class="mb-0"><i class="fas fa-check-double"></i> Uji Konsistensi (Consistency Ratio)</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="card text-center">
                                <div class="card-body">
                                    <h6 class="text-muted">Lambda Max (λmax)</h6>
                                    <h4 class="text-primary">{{ number_format($result['consistency']['lambda_max'], 4) }}</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-center">
                                <div class="card-body">
                                    <h6 class="text-muted">Consistency Index (CI)</h6>
                                    <h4 class="text-info">{{ number_format($result['consistency']['ci'], 4) }}</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-center">
                                <div class="card-body">
                                    <h6 class="text-muted">Random Index (RI)</h6>
                                    <h4 class="text-warning">{{ number_format($result['consistency']['ri'], 4) }}</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-center">
                                <div class="card-body">
                                    <h6 class="text-muted">Consistency Ratio (CR)</h6>
                                    <h4 class="{{ $result['consistency']['cr'] < 0.1 ? 'text-success' : 'text-danger' }}">
                                        {{ number_format($result['consistency']['cr'], 4) }}
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    @if($result['consistency']['cr'] < 0.1)
                        <div class="alert alert-success mb-0">
                            <h5 class="alert-heading"><i class="fas fa-check-circle"></i> Hasil Konsisten!</h5>
                            <p class="mb-0">
                                Consistency Ratio (CR) = <strong>{{ number_format($result['consistency']['cr'], 4) }}</strong> < 0.1<br>
                                Matriks perbandingan yang Anda input sudah konsisten dan dapat digunakan untuk perhitungan selanjutnya.
                            </p>
                        </div>
                    @else
                        <div class="alert alert-danger mb-0">
                            <h5 class="alert-heading"><i class="fas fa-exclamation-triangle"></i> Hasil Tidak Konsisten!</h5>
                            <p class="mb-0">
                                Consistency Ratio (CR) = <strong>{{ number_format($result['consistency']['cr'], 4) }}</strong> ≥ 0.1<br>
                                Matriks perbandingan tidak konsisten. Harap periksa kembali nilai perbandingan dan lakukan revisi.
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Aksi -->
            <div class="d-flex justify-content-between mb-4">
                <a href="{{ route('fuzzy-ahp.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                <div class="btn-group">
                    @if($result['consistency']['cr'] >= 0.1)
                        <a href="{{ route('fuzzy-ahp.create') }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Revisi Perbandingan
                        </a>
                    @endif
                    <button onclick="window.print()" class="btn btn-primary">
                        <i class="fas fa-print"></i> Cetak Hasil
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    .btn, .card-header, nav { display: none !important; }
}
</style>
@endsection