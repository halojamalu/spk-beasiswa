@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Data Kriteria Penilaian</h5>
                    <a href="{{ route('kriteria.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Tambah Kriteria
                    </a>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="10%">Kode</th>
                                    <th width="30%">Nama Kriteria</th>
                                    <th width="10%">Jenis</th>
                                    <th width="10%">Bobot</th>
                                    <th width="10%">Status</th>
                                    <th width="25%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($kriteria as $index => $item)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td class="text-center"><strong>{{ $item->kode_kriteria }}</strong></td>
                                    <td>{{ $item->nama_kriteria }}</td>
                                    <td class="text-center">
                                        @if($item->jenis == 'benefit')
                                            <span class="badge bg-success">Benefit</span>
                                        @else
                                            <span class="badge bg-danger">Cost</span>
                                        @endif
                                    </td>
                                    <td class="text-center">{{ number_format($item->bobot, 4) }}</td>
                                    <td class="text-center">
                                        @if($item->is_active)
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-secondary">Nonaktif</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('kriteria.show', $item->id) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i> Detail
                                        </a>
                                        <a href="{{ route('kriteria.edit', $item->id) }}" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('kriteria.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">Tidak ada data kriteria</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection