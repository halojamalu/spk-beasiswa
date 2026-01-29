@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Tambah Kriteria Baru</h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('kriteria.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="kode_kriteria" class="form-label">Kode Kriteria <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('kode_kriteria') is-invalid @enderror" 
                                id="kode_kriteria" name="kode_kriteria" value="{{ old('kode_kriteria') }}" 
                                placeholder="Contoh: C1, C2, C3" required>
                            @error('kode_kriteria')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="nama_kriteria" class="form-label">Nama Kriteria <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama_kriteria') is-invalid @enderror" 
                                id="nama_kriteria" name="nama_kriteria" value="{{ old('nama_kriteria') }}" 
                                placeholder="Contoh: Nilai Akademik" required>
                            @error('nama_kriteria')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="jenis" class="form-label">Jenis Kriteria <span class="text-danger">*</span></label>
                            <select class="form-select @error('jenis') is-invalid @enderror" id="jenis" name="jenis" required>
                                <option value="">-- Pilih Jenis --</option>
                                <option value="benefit" {{ old('jenis') == 'benefit' ? 'selected' : '' }}>Benefit (Semakin tinggi semakin baik)</option>
                                <option value="cost" {{ old('jenis') == 'cost' ? 'selected' : '' }}>Cost (Semakin rendah semakin baik)</option>
                            </select>
                            @error('jenis')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <textarea class="form-control @error('keterangan') is-invalid @enderror" 
                                id="keterangan" name="keterangan" rows="3" 
                                placeholder="Keterangan tambahan...">{{ old('keterangan') }}</textarea>
                            @error('keterangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="is_active" name="is_active" 
                                {{ old('is_active', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Aktifkan kriteria ini
                            </label>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('kriteria.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection