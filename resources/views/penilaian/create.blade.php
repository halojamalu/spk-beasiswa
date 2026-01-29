@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">
                        <i class="fas fa-edit"></i> Input Penilaian: {{ $kriteria->kode_kriteria }} - {{ $kriteria->nama_kriteria }}
                    </h5>
                </div>

                <div class="card-body">
                    <!-- Info Kriteria -->
                    <div class="alert alert-info">
                        <div class="row">
                            <div class="col-md-4">
                                <strong>Periode:</strong> {{ $periodeAktif->nama_periode }}
                            </div>
                            <div class="col-md-4">
                                <strong>Kriteria:</strong> {{ $kriteria->kode_kriteria }} - {{ $kriteria->nama_kriteria }}
                            </div>
                            <div class="col-md-4">
                                <strong>Jenis:</strong> 
                                @if($kriteria->jenis == 'benefit')
                                    <span class="badge bg-success">Benefit (Semakin tinggi semakin baik)</span>
                                @else
                                    <span class="badge bg-danger">Cost (Semakin rendah semakin baik)</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Panduan Input -->
                    <div class="alert alert-warning">
                        <h6 class="alert-heading"><i class="fas fa-info-circle"></i> Panduan Input Nilai</h6>
                        <p class="mb-0">{{ $kriteria->keterangan ?? 'Masukkan nilai sesuai kriteria penilaian.' }}</p>
                        
                        @if($kriteria->kode_kriteria == 'C1')
                            <ul class="mb-0 mt-2">
                                <li>Nilai Akademik: 0-100 (Rata-rata rapor)</li>
                            </ul>
                        @elseif($kriteria->kode_kriteria == 'C2')
                            <ul class="mb-0 mt-2">
                                <li>Penghasilan Orang Tua dalam Rupiah/bulan</li>
                                <li>Contoh: 2000000 untuk Rp 2.000.000</li>
                            </ul>
                        @elseif($kriteria->kode_kriteria == 'C3')
                            <ul class="mb-0 mt-2">
                                <li>Jumlah Tanggungan Keluarga (dalam angka)</li>
                                <li>Contoh: 4 untuk 4 orang anak</li>
                            </ul>
                        @elseif($kriteria->kode_kriteria == 'C4')
                            <ul class="mb-0 mt-2">
                                <li>Skor Prestasi: 0-100</li>
                                <li>0 = Tidak ada prestasi, 60 = Sekolah, 70 = Kecamatan, 85 = Kota, 100 = Provinsi/Nasional</li>
                            </ul>
                        @elseif($kriteria->kode_kriteria == 'C5')
                            <ul class="mb-0 mt-2">
                                <li>Persentase Kehadiran: 0-100%</li>
                                <li>Contoh: 95 untuk 95%</li>
                            </ul>
                        @elseif($kriteria->kode_kriteria == 'C6')
                            <ul class="mb-0 mt-2">
                                <li>Skor Kelakuan: 0-100</li>
                                <li>A = 100, B = 85, C = 70, D = 55</li>
                            </ul>
                        @endif
                    </div>

                    <!-- Form Input -->
                    <form action="{{ route('penilaian.store') }}" method="POST" id="formPenilaian">
                        @csrf
                        <input type="hidden" name="periode_id" value="{{ $periodeAktif->id }}">
                        <input type="hidden" name="kriteria_id" value="{{ $kriteria->id }}">

                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="table-warning">
                                    <tr>
                                        <th width="5%" class="text-center">No</th>
                                        <th width="10%">NIS</th>
                                        <th width="25%">Nama Siswa</th>
                                        <th width="10%" class="text-center">Kelas</th>
                                        <th width="10%" class="text-center">L/P</th>
                                        <th width="25%" class="text-center">Nilai {{ $kriteria->kode_kriteria }}</th>
                                        <th width="15%" class="text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($siswa as $index => $s)
                                    @php
                                        $nilaiExisting = $existingPenilaian->get($s->id);
                                    @endphp
                                    <tr>
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td>{{ $s->nis }}</td>
                                        <td><strong>{{ $s->nama_lengkap }}</strong></td>
                                        <td class="text-center">
                                            <span class="badge bg-primary">{{ $s->kelas }}</span>
                                        </td>
                                        <td class="text-center">
                                            @if($s->jenis_kelamin == 'L')
                                                <span class="badge bg-info">L</span>
                                            @else
                                                <span class="badge bg-danger">P</span>
                                            @endif
                                        </td>
                                        <td>
                                            <input type="number" 
                                                   class="form-control form-control-sm @error('nilai.'.$s->id) is-invalid @enderror" 
                                                   name="nilai[{{ $s->id }}]" 
                                                   value="{{ old('nilai.'.$s->id, $nilaiExisting ? $nilaiExisting->nilai : '') }}"
                                                   placeholder="0"
                                                   step="0.01"
                                                   min="0"
                                                   required>
                                            @error('nilai.'.$s->id)
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </td>
                                        <td class="text-center">
                                            @if($nilaiExisting)
                                                <span class="badge bg-success">Sudah Dinilai</span>
                                            @else
                                                <span class="badge bg-secondary">Belum</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="table-light">
                                    <tr>
                                        <td colspan="7" class="text-center">
                                            <strong>Total: {{ $siswa->count() }} siswa</strong>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <div class="alert alert-info mt-3">
                            <i class="fas fa-lightbulb"></i> 
                            <strong>Tips:</strong> Gunakan tombol Tab untuk berpindah antar input dengan cepat.
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('penilaian.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-success btn-lg px-5">
                                <i class="fas fa-save"></i> Simpan Semua Nilai
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Quick Fill (Optional) -->
            <div class="card mt-3">
                <div class="card-header bg-light">
                    <h6 class="mb-0"><i class="fas fa-magic"></i> Quick Fill (Isi Cepat)</h6>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-3">
                        Gunakan fitur ini untuk mengisi nilai yang sama ke semua siswa sekaligus (opsional).
                    </p>
                    <div class="row align-items-end">
                        <div class="col-md-4">
                            <label class="form-label">Nilai yang akan diisi:</label>
                            <input type="number" class="form-control" id="quickFillValue" placeholder="Contoh: 80">
                        </div>
                        <div class="col-md-4">
                            <button type="button" class="btn btn-primary" onclick="quickFill()">
                                <i class="fas fa-fill"></i> Isi Semua
                            </button>
                            <button type="button" class="btn btn-secondary" onclick="clearAll()">
                                <i class="fas fa-eraser"></i> Kosongkan Semua
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function quickFill() {
    const value = document.getElementById('quickFillValue').value;
    if (!value) {
        alert('Masukkan nilai terlebih dahulu!');
        return;
    }
    
    const inputs = document.querySelectorAll('input[name^="nilai"]');
    inputs.forEach(input => {
        input.value = value;
    });
    
    alert(`Berhasil mengisi ${inputs.length} input dengan nilai ${value}`);
}

function clearAll() {
    if (!confirm('Yakin ingin mengosongkan semua input?')) return;
    
    const inputs = document.querySelectorAll('input[name^="nilai"]');
    inputs.forEach(input => {
        input.value = '';
    });
}

// Auto-save to localStorage (optional)
const inputs = document.querySelectorAll('input[name^="nilai"]');
inputs.forEach(input => {
    input.addEventListener('change', function() {
        localStorage.setItem('penilaian_' + this.name, this.value);
    });
    
    // Load from localStorage
    const savedValue = localStorage.getItem('penilaian_' + input.name);
    if (savedValue && !input.value) {
        input.value = savedValue;
    }
});

// Clear localStorage after submit
document.getElementById('formPenilaian').addEventListener('submit', function() {
    inputs.forEach(input => {
        localStorage.removeItem('penilaian_' + input.name);
    });
});
</script>
@endsection