@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-user-graduate"></i> Detail Penilaian Siswa
                    </h5>
                </div>

                <div class="card-body">
                    <!-- Info Siswa -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card border-primary">
                                <div class="card-header bg-primary text-white">
                                    <h6 class="mb-0">Data Siswa</h6>
                                </div>
                                <div class="card-body">
                                    <table class="table table-sm mb-0">
                                        <tr>
                                            <th width="40%">NIS</th>
                                            <td><strong>{{ $siswa->nis }}</strong></td>
                                        </tr>
                                        <tr>
                                            <th>Nama Lengkap</th>
                                            <td><strong>{{ $siswa->nama_lengkap }}</strong></td>
                                        </tr>
                                        <tr>
                                            <th>Jenis Kelamin</th>
                                            <td>{{ $siswa->jenis_kelamin_lengkap }}</td>
                                        </tr>
                                        <tr>
                                            <th>Kelas</th>
                                            <td><span class="badge bg-primary">{{ $siswa->kelas }}</span></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card border-success">
                                <div class="card-header bg-success text-white">
                                    <h6 class="mb-0">Data Orang Tua</h6>
                                </div>
                                <div class="card-body">
                                    <table class="table table-sm mb-0">
                                        <tr>
                                            <th width="40%">Nama Orang Tua</th>
                                            <td>{{ $siswa->nama_ortu ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Pekerjaan</th>
                                            <td>{{ $siswa->pekerjaan_ortu ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Penghasilan</th>
                                            <td>Rp {{ number_format($siswa->penghasilan_ortu, 0, ',', '.') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Jumlah Tanggungan</th>
                                            <td>{{ $siswa->jumlah_tanggungan }} orang</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Info Periode -->
                    <div class="alert alert-info">
                        <strong>Periode Seleksi:</strong> {{ $periodeAktif->nama_periode }} - {{ $periodeAktif->tahun_ajaran }}
                    </div>

                    <!-- Tabel Penilaian -->
                    <div class="card">
                        <div class="card-header bg-light">
                            <h6 class="mb-0"><i class="fas fa-clipboard-check"></i> Nilai Per Kriteria</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead class="table-dark">
                                        <tr>
                                            <th width="10%" class="text-center">Kode</th>
                                            <th width="35%">Nama Kriteria</th>
                                            <th width="15%" class="text-center">Jenis</th>
                                            <th width="20%" class="text-center">Nilai</th>
                                            <th width="20%" class="text-center">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $totalNilai = 0;
                                            $jumlahDinilai = 0;
                                        @endphp
                                        @foreach($kriteria as $k)
                                        @php
                                            $nilai = $penilaian->get($k->id);
                                            if ($nilai) {
                                                $totalNilai += $nilai->nilai;
                                                $jumlahDinilai++;
                                            }
                                        @endphp
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
                                                @if($nilai)
                                                    <strong class="text-primary fs-5">
                                                        {{ number_format($nilai->nilai, 2) }}
                                                    </strong>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if($nilai)
                                                    <span class="badge bg-success">
                                                        <i class="fas fa-check"></i> Sudah Dinilai
                                                    </span>
                                                @else
                                                    <span class="badge bg-secondary">
                                                        <i class="fas fa-times"></i> Belum Dinilai
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot class="table-light">
                                        <tr>
                                            <td colspan="3" class="text-end"><strong>Rata-rata Nilai:</strong></td>
                                            <td class="text-center">
                                                <strong class="text-primary fs-5">
                                                    {{ $jumlahDinilai > 0 ? number_format($totalNilai / $jumlahDinilai, 2) : '-' }}
                                                </strong>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-info">
                                                    {{ $jumlahDinilai }}/{{ $kriteria->count() }} Kriteria
                                                </span>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                            @if($jumlahDinilai < $kriteria->count())
                                <div class="alert alert-warning mt-3">
                                    <i class="fas fa-exclamation-triangle"></i> 
                                    Siswa ini masih memiliki <strong>{{ $kriteria->count() - $jumlahDinilai }} kriteria</strong> yang belum dinilai.
                                </div>
                            @else
                                <div class="alert alert-success mt-3">
                                    <i class="fas fa-check-circle"></i> 
                                    Siswa ini sudah dinilai untuk <strong>semua kriteria</strong>.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('penilaian.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        <a href="{{ route('siswa.show', $siswa->id) }}" class="btn btn-primary">
                            <i class="fas fa-user"></i> Lihat Detail Siswa
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection