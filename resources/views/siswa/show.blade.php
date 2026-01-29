@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Detail Data Siswa</h5>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-primary mb-3">Data Pribadi Siswa</h6>
                            <table class="table table-bordered">
                                <tr>
                                    <th width="40%">NIS</th>
                                    <td><strong>{{ $siswa->nis }}</strong></td>
                                </tr>
                                <tr>
                                    <th>Nama Lengkap</th>
                                    <td>{{ $siswa->nama_lengkap }}</td>
                                </tr>
                                <tr>
                                    <th>Jenis Kelamin</th>
                                    <td>{{ $siswa->jenis_kelamin_lengkap }}</td>
                                </tr>
                                <tr>
                                    <th>Kelas</th>
                                    <td><span class="badge bg-primary">{{ $siswa->kelas }}</span></td>
                                </tr>
                                <tr>
                                    <th>Alamat</th>
                                    <td>{{ $siswa->alamat ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        @if($siswa->is_active)
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-secondary">Nonaktif</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <div class="col-md-6">
                            <h6 class="text-primary mb-3">Data Orang Tua/Wali</h6>
                            <table class="table table-bordered">
                                <tr>
                                    <th width="40%">Nama Orang Tua</th>
                                    <td>{{ $siswa->nama_ortu ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Pekerjaan</th>
                                    <td>{{ $siswa->pekerjaan_ortu ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Penghasilan/Bulan</th>
                                    <td>Rp {{ number_format($siswa->penghasilan_ortu, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <th>Jumlah Tanggungan</th>
                                    <td>{{ $siswa->jumlah_tanggungan }} orang</td>
                                </tr>
                                <tr>
                                    <th>Dibuat</th>
                                    <td>{{ $siswa->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Terakhir Diupdate</th>
                                    <td>{{ $siswa->updated_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between mt-3">
                        <a href="{{ route('siswa.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        <a href="{{ route('siswa.edit', $siswa->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit Data
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection