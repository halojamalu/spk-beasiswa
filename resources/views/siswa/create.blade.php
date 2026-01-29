@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Tambah Data Siswa Baru</h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('siswa.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="text-primary mb-3">Data Pribadi Siswa</h6>

                                <div class="mb-3">
                                    <label for="nis" class="form-label">NIS <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('nis') is-invalid @enderror" 
                                        id="nis" name="nis" value="{{ old('nis') }}" 
                                        placeholder="Contoh: 2401" required>
                                    @error('nis')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="nama_lengkap" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror" 
                                        id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap') }}" 
                                        placeholder="Nama lengkap siswa" required>
                                    @error('nama_lengkap')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                                    <select class="form-select @error('jenis_kelamin') is-invalid @enderror" 
                                        id="jenis_kelamin" name="jenis_kelamin" required>
                                        <option value="">-- Pilih Jenis Kelamin --</option>
                                        <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                    @error('jenis_kelamin')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="kelas" class="form-label">Kelas <span class="text-danger">*</span></label>
                                    <select class="form-select @error('kelas') is-invalid @enderror" 
                                        id="kelas" name="kelas" required>
                                        <option value="">-- Pilih Kelas --</option>
                                        <option value="4A" {{ old('kelas') == '4A' ? 'selected' : '' }}>4A</option>
                                        <option value="4B" {{ old('kelas') == '4B' ? 'selected' : '' }}>4B</option>
                                        <option value="5A" {{ old('kelas') == '5A' ? 'selected' : '' }}>5A</option>
                                        <option value="5B" {{ old('kelas') == '5B' ? 'selected' : '' }}>5B</option>
                                        <option value="6A" {{ old('kelas') == '6A' ? 'selected' : '' }}>6A</option>
                                        <option value="6B" {{ old('kelas') == '6B' ? 'selected' : '' }}>6B</option>
                                    </select>
                                    @error('kelas')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="alamat" class="form-label">Alamat</label>
                                    <textarea class="form-control @error('alamat') is-invalid @enderror" 
                                        id="alamat" name="alamat" rows="3" 
                                        placeholder="Alamat lengkap siswa">{{ old('alamat') }}</textarea>
                                    @error('alamat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <h6 class="text-primary mb-3">Data Orang Tua/Wali</h6>

                                <div class="mb-3">
                                    <label for="nama_ortu" class="form-label">Nama Orang Tua/Wali</label>
                                    <input type="text" class="form-control @error('nama_ortu') is-invalid @enderror" 
                                        id="nama_ortu" name="nama_ortu" value="{{ old('nama_ortu') }}" 
                                        placeholder="Nama orang tua/wali">
                                    @error('nama_ortu')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="pekerjaan_ortu" class="form-label">Pekerjaan Orang Tua</label>
                                    <input type="text" class="form-control @error('pekerjaan_ortu') is-invalid @enderror" 
                                        id="pekerjaan_ortu" name="pekerjaan_ortu" value="{{ old('pekerjaan_ortu') }}" 
                                        placeholder="Contoh: Buruh Pabrik, Pedagang, dll">
                                    @error('pekerjaan_ortu')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="penghasilan_ortu" class="form-label">Penghasilan Orang Tua (Rp/bulan)</label>
                                    <input type="number" class="form-control @error('penghasilan_ortu') is-invalid @enderror" 
                                        id="penghasilan_ortu" name="penghasilan_ortu" value="{{ old('penghasilan_ortu', 0) }}" 
                                        placeholder="Contoh: 2000000" min="0" step="1000">
                                    @error('penghasilan_ortu')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="jumlah_tanggungan" class="form-label">Jumlah Tanggungan Keluarga</label>
                                    <input type="number" class="form-control @error('jumlah_tanggungan') is-invalid @enderror" 
                                        id="jumlah_tanggungan" name="jumlah_tanggungan" value="{{ old('jumlah_tanggungan', 0) }}" 
                                        placeholder="Jumlah anak/tanggungan" min="0">
                                    @error('jumlah_tanggungan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Jumlah anak/tanggungan dalam keluarga</small>
                                </div>

                                <div class="mb-3 form-check">
                                    <input type="checkbox" class="form-check-input" id="is_active" name="is_active" 
                                        {{ old('is_active', true) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">
                                        Status Aktif (Siswa masih bersekolah)
                                    </label>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('siswa.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan Data Siswa
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection