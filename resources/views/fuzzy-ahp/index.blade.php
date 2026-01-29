@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-calculator"></i> Perhitungan Bobot Kriteria (Fuzzy-AHP)</h5>
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
                            <strong>Status:</strong> <span class="badge bg-success">{{ strtoupper($periodeAktif->status) }}</span>
                        </p>
                    </div>

                    <!-- Info Kriteria -->
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h6 class="mb-0"><i class="fas fa-list"></i> Daftar Kriteria ({{ $kriteria->count() }} kriteria)</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered">
                                    <thead class="table-secondary">
                                        <tr>
                                            <th width="10%">Kode</th>
                                            <th width="50%">Nama Kriteria</th>
                                            <th width="15%">Jenis</th>
                                            <th width="25%">Bobot Saat Ini</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($kriteria as $k)
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
                                            <td class="text-center">
                                                @if($k->bobot > 0)
                                                    <strong class="text-primary">{{ number_format($k->bobot, 4) }}</strong>
                                                @else
                                                    <span class="text-muted">Belum dihitung</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Status Perhitungan -->
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h6 class="mb-0"><i class="fas fa-tasks"></i> Status Perhitungan</h6>
                        </div>
                        <div class="card-body">
                            @if($perbandingan->isEmpty())
                                <div class="alert alert-warning mb-0">
                                    <i class="fas fa-exclamation-triangle"></i> 
                                    Belum ada data perbandingan kriteria untuk periode ini.
                                </div>
                            @else
                                <div class="alert alert-success mb-0">
                                    <i class="fas fa-check-circle"></i> 
                                    Data perbandingan sudah tersedia ({{ $perbandingan->count() }} perbandingan).
                                    @if($kriteria->where('bobot', '>', 0)->count() > 0)
                                        <br><strong>Bobot kriteria sudah dihitung!</strong>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Aksi -->
                    <div class="d-flex justify-content-between gap-2">
                        <a href="{{ route('home') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
                        </a>
                        
                        <div class="btn-group">
                            @if($perbandingan->isEmpty())
                                <a href="{{ route('fuzzy-ahp.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Input Perbandingan Kriteria
                                </a>
                            @else
                                <a href="{{ route('fuzzy-ahp.create') }}" class="btn btn-warning">
                                    <i class="fas fa-edit"></i> Edit Perbandingan
                                </a>
                                <a href="{{ route('fuzzy-ahp.calculate') }}" class="btn btn-success">
                                    <i class="fas fa-calculator"></i> Hitung Bobot
                                </a>
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#resetModal">
                                    <i class="fas fa-redo"></i> Reset
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Info Fuzzy-AHP -->
            <div class="card mt-4">
                <div class="card-header bg-light">
                    <h6 class="mb-0"><i class="fas fa-question-circle"></i> Tentang Fuzzy-AHP</h6>
                </div>
                <div class="card-body">
                    <p><strong>Fuzzy-AHP (Fuzzy Analytical Hierarchy Process)</strong> adalah metode pengambilan keputusan multi-kriteria yang menggabungkan logika fuzzy dengan AHP untuk menangani ketidakpastian dalam penilaian perbandingan.</p>
                    
                    <h6>Skala Perbandingan:</h6>
                    <table class="table table-sm table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>Nilai</th>
                                <th>Keterangan</th>
                                <th>Fuzzy Triangular (l, m, u)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr><td>1</td><td>Sama penting</td><td>(1, 1, 1)</td></tr>
                            <tr><td>3</td><td>Sedikit lebih penting</td><td>(2, 3, 4)</td></tr>
                            <tr><td>5</td><td>Lebih penting</td><td>(4, 5, 6)</td></tr>
                            <tr><td>7</td><td>Sangat lebih penting</td><td>(6, 7, 8)</td></tr>
                            <tr><td>9</td><td>Mutlak lebih penting</td><td>(8, 9, 9)</td></tr>
                            <tr><td>2,4,6,8</td><td>Nilai antara</td><td>-</td></tr>
                        </tbody>
                    </table>
                    
                    <p class="mb-0"><strong>Consistency Ratio (CR):</strong> Hasil perhitungan harus memiliki CR < 0.1 untuk dianggap konsisten.</p>
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
            <form action="{{ route('fuzzy-ahp.reset') }}" method="POST">
                @csrf
                <input type="hidden" name="periode_id" value="{{ $periodeAktif->id }}">
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin mereset perhitungan Fuzzy-AHP?</p>
                    <div class="alert alert-warning">
                        <strong>Perhatian!</strong> Tindakan ini akan:
                        <ul class="mb-0">
                            <li>Menghapus semua data perbandingan kriteria</li>
                            <li>Mereset bobot kriteria ke 0</li>
                            <li>Data tidak dapat dikembalikan</li>
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