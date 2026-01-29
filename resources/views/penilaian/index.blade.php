@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0"><i class="fas fa-clipboard-list"></i> Input Penilaian Siswa</h5>
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
                            <strong>Total Siswa:</strong> {{ $siswa->count() }} siswa<br>
                            <strong>Total Kriteria:</strong> {{ $kriteria->count() }} kriteria
                        </p>
                    </div>

                    <!-- Progress Keseluruhan -->
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h6 class="mb-0"><i class="fas fa-tasks"></i> Progress Penilaian Keseluruhan</h6>
                        </div>
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-9">
                                    <div class="progress" style="height: 30px;">
                                        <div class="progress-bar bg-success progress-bar-striped progress-bar-animated" 
                                             style="width: {{ $progressPercentage }}%">
                                            {{ number_format($progressPercentage, 1) }}%
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 text-end">
                                    <h5 class="mb-0">
                                        <strong>{{ $completedTotal }}</strong> / {{ $expectedTotal }}
                                    </h5>
                                    <small class="text-muted">Penilaian Lengkap</small>
                                </div>
                            </div>

                            @if($progressPercentage >= 100)
                                <div class="alert alert-success mt-3 mb-0">
                                    <i class="fas fa-check-circle"></i> 
                                    <strong>Penilaian Sudah Lengkap!</strong> Semua siswa telah dinilai untuk semua kriteria.
                                </div>
                            @elseif($progressPercentage > 0)
                                <div class="alert alert-warning mt-3 mb-0">
                                    <i class="fas fa-exclamation-triangle"></i> 
                                    Masih ada {{ $expectedTotal - $completedTotal }} penilaian yang belum dilengkapi.
                                </div>
                            @else
                                <div class="alert alert-info mt-3 mb-0">
                                    <i class="fas fa-info-circle"></i> 
                                    Belum ada penilaian yang diinput. Silakan mulai input penilaian per kriteria.
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Daftar Kriteria & Progress -->
                    <div class="card mb-4">
                        <div class="card-header bg-light d-flex justify-content-between align-items-center">
                            <h6 class="mb-0"><i class="fas fa-list-check"></i> Daftar Kriteria & Progress Penilaian</h6>
                            <span class="badge bg-primary">{{ $kriteria->count() }} Kriteria</span>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="10%">Kode</th>
                                            <th width="30%">Nama Kriteria</th>
                                            <th width="10%" class="text-center">Jenis</th>
                                            <th width="25%">Progress</th>
                                            <th width="25%" class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($kriteria as $k)
                                        @php
                                            $progress = $progressPerKriteria[$k->id];
                                            $isComplete = $progress['completed'] == $progress['total'];
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
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="progress flex-grow-1 me-2" style="height: 20px;">
                                                        <div class="progress-bar {{ $isComplete ? 'bg-success' : 'bg-warning' }}" 
                                                             style="width: {{ $progress['percentage'] }}%">
                                                            {{ number_format($progress['percentage'], 0) }}%
                                                        </div>
                                                    </div>
                                                    <small class="text-muted">
                                                        {{ $progress['completed'] }}/{{ $progress['total'] }}
                                                    </small>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('penilaian.create', ['kriteria_id' => $k->id]) }}" 
                                                   class="btn btn-sm {{ $isComplete ? 'btn-success' : 'btn-warning' }}">
                                                    <i class="fas {{ $isComplete ? 'fa-edit' : 'fa-plus' }}"></i> 
                                                    {{ $isComplete ? 'Edit' : 'Input' }} Nilai
                                                </a>
                                                
                                                @if($progress['completed'] > 0)
                                                <button type="button" class="btn btn-sm btn-danger" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#deleteModal{{ $k->id }}">
                                                    <i class="fas fa-trash"></i> Hapus
                                                </button>
                                                @endif
                                            </td>
                                        </tr>

                                        <!-- Modal Delete -->
                                        <div class="modal fade" id="deleteModal{{ $k->id }}" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-danger text-white">
                                                        <h5 class="modal-title">
                                                            <i class="fas fa-exclamation-triangle"></i> Konfirmasi Hapus
                                                        </h5>
                                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <form action="{{ route('penilaian.destroy') }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <input type="hidden" name="periode_id" value="{{ $periodeAktif->id }}">
                                                        <input type="hidden" name="kriteria_id" value="{{ $k->id }}">
                                                        <div class="modal-body">
                                                            <p>Apakah Anda yakin ingin menghapus <strong>semua penilaian</strong> untuk kriteria:</p>
                                                            <div class="alert alert-warning">
                                                                <strong>{{ $k->kode_kriteria }} - {{ $k->nama_kriteria }}</strong><br>
                                                                <small>{{ $progress['completed'] }} penilaian akan dihapus</small>
                                                            </div>
                                                            <p class="text-danger mb-0">
                                                                <i class="fas fa-exclamation-circle"></i> 
                                                                Data yang dihapus tidak dapat dikembalikan!
                                                            </p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-danger">Ya, Hapus Data</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="card">
                        <div class="card-header bg-light">
                            <h6 class="mb-0"><i class="fas fa-users"></i> Lihat Detail Penilaian Per Siswa</h6>
                        </div>
                        <div class="card-body">
                            <div class="row g-2">
                                @foreach($siswa->take(10) as $s)
                                <div class="col-md-6">
                                    <a href="{{ route('penilaian.show', $s->id) }}" class="btn btn-outline-primary btn-sm w-100 text-start">
                                        <i class="fas fa-user"></i> {{ $s->nis }} - {{ $s->nama_lengkap }}
                                    </a>
                                </div>
                                @endforeach
                            </div>
                            @if($siswa->count() > 10)
                            <div class="text-center mt-3">
                                <small class="text-muted">Menampilkan 10 dari {{ $siswa->count() }} siswa</small>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('home') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
                        </a>
                        @if($progressPercentage >= 100)
                        <a href="{{ route('moora.index') }}" class="btn btn-success">
                            <i class="fas fa-arrow-right"></i> Lanjut ke Perhitungan MOORA
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection