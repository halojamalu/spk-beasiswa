@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Data Siswa Calon Penerima Beasiswa</h5>
                    <a href="{{ route('siswa.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Tambah Siswa
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
                        <table class="table table-bordered table-striped table-hover table-sm">
                            <thead class="table-dark">
                                <tr>
                                    <th width="3%">No</th>
                                    <th width="8%">NIS</th>
                                    <th width="15%">Nama Lengkap</th>
                                    <th width="5%">JK</th>
                                    <th width="6%">Kelas</th>
                                    <th width="12%">Nama Ortu</th>
                                    <th width="10%">Penghasilan</th>
                                    <th width="7%">Tanggungan</th>
                                    <th width="7%">Status</th>
                                    <th width="17%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($siswa as $index => $item)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td class="text-center"><strong>{{ $item->nis }}</strong></td>
                                    <td>{{ $item->nama_lengkap }}</td>
                                    <td class="text-center">
                                        @if($item->jenis_kelamin == 'L')
                                            <span class="badge bg-primary">L</span>
                                        @else
                                            <span class="badge bg-danger">P</span>
                                        @endif
                                    </td>
                                    <td class="text-center">{{ $item->kelas }}</td>
                                    <td>{{ $item->nama_ortu ?? '-' }}</td>
                                    <td class="text-end">Rp {{ number_format($item->penghasilan_ortu, 0, ',', '.') }}</td>
                                    <td class="text-center">{{ $item->jumlah_tanggungan }} orang</td>
                                    <td class="text-center">
                                        @if($item->is_active)
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-secondary">Nonaktif</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('siswa.show', $item->id) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i>Detail
                                        </a>
                                        <a href="{{ route('siswa.edit', $item->id) }}" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i>Edit
                                        </a>
                                        <form action="{{ route('siswa.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data siswa ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash"></i>Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="10" class="text-center">Tidak ada data siswa</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        <small class="text-muted">Total: <strong>{{ $siswa->count() }}</strong> siswa</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection