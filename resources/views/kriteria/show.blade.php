@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Detail Kriteria</h5>
                </div>

                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th width="30%">Kode Kriteria</th>
                            <td><strong>{{ $kriterium->kode_kriteria }}</strong></td>
                        </tr>
                        <tr>
                            <th>Nama Kriteria</th>
                            <td>{{ $kriterium->nama_kriteria }}</td>
                        </tr>
                        <tr>
                            <th>Jenis</th>
                            <td>
                                @if($kriterium->jenis == 'benefit')
                                    <span class="badge bg-success">Benefit</span>
                                @else
                                    <span class="badge bg-danger">Cost</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Bobot</th>
                            <td>{{ number_format($kriterium->bobot, 4) }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                @if($kriterium->is_active)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Nonaktif</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Keterangan</th>
                            <td>{{ $kriterium->keterangan ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Dibuat</th>
                            <td>{{ $kriterium->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        <tr>
                            <th>Terakhir Diupdate</th>
                            <td>{{ $kriterium->updated_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    </table>

                    <div class="d-flex justify-content-between mt-3">
                        <a href="{{ route('kriteria.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        <a href="{{ route('kriteria.edit', $kriterium->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection