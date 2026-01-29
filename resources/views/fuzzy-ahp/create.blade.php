@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-edit"></i> Input Perbandingan Berpasangan Kriteria</h5>
                </div>

                <div class="card-body">
                    <div class="alert alert-info">
                        <h6 class="alert-heading"><i class="fas fa-info-circle"></i> Petunjuk Pengisian</h6>
                        <ol class="mb-0">
                            <li>Bandingkan setiap pasangan kriteria dengan menggunakan skala 1-9</li>
                            <li>Nilai 1 = sama penting, 3 = sedikit lebih penting, 5 = lebih penting, 7 = sangat lebih penting, 9 = mutlak lebih penting</li>
                            <li>Nilai 2, 4, 6, 8 adalah nilai antara</li>
                            <li>Perbandingan dilakukan dari perspektif <strong>Kriteria Baris</strong> terhadap <strong>Kriteria Kolom</strong></li>
                        </ol>
                    </div>

                    <form action="{{ route('fuzzy-ahp.store') }}" method="POST" id="formPerbandingan">
                        @csrf
                        <input type="hidden" name="periode_id" value="{{ $periodeAktif->id }}">

                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th width="15%" class="text-center">Kriteria</th>
                                        @foreach($kriteria as $k)
                                            <th class="text-center">{{ $k->kode_kriteria }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($kriteria as $i => $k1)
                                    <tr>
                                        <td class="table-secondary text-center">
                                            <strong>{{ $k1->kode_kriteria }}</strong><br>
                                            <small>{{ $k1->nama_kriteria }}</small>
                                        </td>
                                        @foreach($kriteria as $j => $k2)
                                            <td class="text-center">
                                                @if($i == $j)
                                                    <input type="number" class="form-control form-control-sm text-center" 
                                                        value="1" readonly style="background-color: #e9ecef;">
                                                @elseif($i < $j)
                                                    <select class="form-select form-select-sm" 
                                                        name="perbandingan[{{ $k1->id }}_{{ $k2->id }}]" 
                                                        required onchange="updateReciprocal({{ $k1->id }}, {{ $k2->id }}, this.value)">
                                                        <option value="">-</option>
                                                        <option value="9">9 - Mutlak lebih penting</option>
                                                        <option value="8">8 - Antara 7 dan 9</option>
                                                        <option value="7">7 - Sangat lebih penting</option>
                                                        <option value="6">6 - Antara 5 dan 7</option>
                                                        <option value="5">5 - Lebih penting</option>
                                                        <option value="4">4 - Antara 3 dan 5</option>
                                                        <option value="3">3 - Sedikit lebih penting</option>
                                                        <option value="2">2 - Antara 1 dan 3</option>
                                                        <option value="1" selected>1 - Sama penting</option>
                                                    </select>
                                                @else
                                                    <input type="text" 
                                                        class="form-control form-control-sm text-center reciprocal" 
                                                        id="reciprocal_{{ $k2->id }}_{{ $k1->id }}"
                                                        value="1" 
                                                        readonly 
                                                        style="background-color: #fff3cd;">
                                                @endif
                                            </td>
                                        @endforeach
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="alert alert-warning mt-3">
                            <strong><i class="fas fa-lightbulb"></i> Catatan:</strong>
                            <ul class="mb-0">
                                <li>Sel berwarna <span class="badge bg-secondary">Abu-abu</span> adalah diagonal (nilai 1)</li>
                                <li>Sel berwarna <span class="badge" style="background-color: #fff3cd; color: #000;">Kuning</span> akan otomatis terisi reciprocal (1/nilai)</li>
                                <li>Pastikan semua perbandingan sudah diisi sebelum menyimpan</li>
                            </ul>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('fuzzy-ahp.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save"></i> Simpan Perbandingan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Reference Card -->
            <div class="card mt-3">
                <div class="card-header bg-light">
                    <h6 class="mb-0"><i class="fas fa-book"></i> Referensi Skala Perbandingan</h6>
                </div>
                <div class="card-body">
                    <table class="table table-sm table-bordered mb-0">
                        <thead class="table-light">
                            <tr>
                                <th width="10%">Nilai</th>
                                <th>Keterangan</th>
                                <th width="30%">Contoh</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr><td class="text-center">1</td><td>Sama penting</td><td>Kedua kriteria sama pentingnya</td></tr>
                            <tr><td class="text-center">3</td><td>Sedikit lebih penting</td><td>Kriteria A sedikit lebih penting dari B</td></tr>
                            <tr><td class="text-center">5</td><td>Lebih penting</td><td>Kriteria A lebih penting dari B</td></tr>
                            <tr><td class="text-center">7</td><td>Sangat lebih penting</td><td>Kriteria A sangat lebih penting dari B</td></tr>
                            <tr><td class="text-center">9</td><td>Mutlak lebih penting</td><td>Kriteria A mutlak lebih penting dari B</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function updateReciprocal(id1, id2, value) {
    const reciprocalField = document.getElementById('reciprocal_' + id2 + '_' + id1);
    if (reciprocalField && value) {
        const reciprocal = (1 / parseFloat(value)).toFixed(4);
        reciprocalField.value = reciprocal;
    }
}

// Initialize reciprocals on page load
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('select[name^="perbandingan"]').forEach(function(select) {
        if (select.value) {
            const match = select.name.match(/\[(\d+)_(\d+)\]/);
            if (match) {
                updateReciprocal(match[1], match[2], select.value);
            }
        }
    });
});
</script>
@endsection