<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Lengkap Seleksi Beasiswa</title>
    <style>
        @page {
            margin: 25px;
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 10pt;
        }
        .header {
            text-align: center;
            margin-bottom: 25px;
            border-bottom: 3px solid #059669;
            padding-bottom: 15px;
        }
        .header h1 {
            margin: 5px 0;
            color: #059669;
            font-size: 16pt;
        }
        .header h3 {
            margin: 5px 0;
            font-size: 12pt;
        }
        .section {
            margin-bottom: 25px;
        }
        .section-title {
            background: #059669;
            color: white;
            padding: 8px 10px;
            font-weight: bold;
            font-size: 11pt;
            margin-bottom: 10px;
        }
        .info-table {
            width: 100%;
            margin-bottom: 15px;
        }
        .info-table td {
            padding: 5px;
            font-size: 9pt;
        }
        table.data {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        table.data th {
            background: #059669;
            color: white;
            padding: 8px 5px;
            font-size: 9pt;
            border: 1px solid #047857;
        }
        table.data td {
            padding: 6px 5px;
            border: 1px solid #d1d5db;
            font-size: 9pt;
        }
        table.data tr:nth-child(even) {
            background: #f9fafb;
        }
        .page-break {
            page-break-after: always;
        }
        .highlight {
            background: #fef3c7;
            padding: 10px;
            border-left: 4px solid #f59e0b;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <!-- Cover Page -->
    <div style="text-align: center; margin-top: 150px;">
        <h1 style="font-size: 22pt; color: #059669;">LAPORAN LENGKAP</h1>
        <h2 style="font-size: 18pt; margin: 20px 0;">SELEKSI PENERIMA BEASISWA</h2>
        <h3 style="font-size: 14pt; margin: 30px 0;">Madrasah Ibtidaiyah Daarul Ishlah Batam</h3>
        
        <div style="margin-top: 80px; font-size: 12pt;">
            <p><strong>Periode:</strong> {{ $periode->nama_periode }}</p>
            <p><strong>Tahun Ajaran:</strong> {{ $periode->tahun_ajaran }}</p>
        </div>
        
        <div style="margin-top: 100px; font-size: 10pt;">
            <p>Metode Hibrid:</p>
            <p><strong>Fuzzy-AHP & MOORA</strong></p>
        </div>
    </div>

    <div class="page-break"></div>

    <!-- Page 1: Informasi Umum -->
    <div class="header">
        <h1>LAPORAN LENGKAP SELEKSI BEASISWA</h1>
        <h3>{{ $periode->nama_periode }}</h3>
    </div>

    <!-- Informasi Periode -->
    <div class="section">
        <div class="section-title">I. INFORMASI PERIODE SELEKSI</div>
        <table class="info-table">
            <tr>
                <td width="30%"><strong>Nama Periode</strong></td>
                <td width="2%">:</td>
                <td>{{ $periode->nama_periode }}</td>
            </tr>
            <tr>
                <td><strong>Tahun Ajaran</strong></td>
                <td>:</td>
                <td>{{ $periode->tahun_ajaran }}</td>
            </tr>
            <tr>
                <td><strong>Tanggal Seleksi</strong></td>
                <td>:</td>
                <td>{{ $periode->tanggal_mulai->format('d F Y') }} s/d {{ $periode->tanggal_selesai->format('d F Y') }}</td>
            </tr>
            <tr>
                <td><strong>Kuota Beasiswa</strong></td>
                <td>:</td>
                <td><strong>{{ $periode->kuota_beasiswa }} siswa</strong></td>
            </tr>
            <tr>
                <td><strong>Total Peserta</strong></td>
                <td>:</td>
                <td>{{ $hasil->count() }} siswa</td>
            </tr>
        </table>
    </div>

    <!-- Kriteria Penilaian -->
    <div class="section">
        <div class="section-title">II. KRITERIA PENILAIAN DAN BOBOT</div>
        <table class="data">
            <thead>
                <tr>
                    <th width="10%">Kode</th>
                    <th width="50%">Nama Kriteria</th>
                    <th width="15%">Jenis</th>
                    <th width="25%">Bobot (Fuzzy-AHP)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($kriteria as $k)
                <tr>
                    <td align="center"><strong>{{ $k->kode_kriteria }}</strong></td>
                    <td>{{ $k->nama_kriteria }}</td>
                    <td align="center">
                        @if($k->jenis == 'benefit')
                            <strong style="color: #059669;">BENEFIT</strong>
                        @else
                            <strong style="color: #dc2626;">COST</strong>
                        @endif
                    </td>
                    <td align="center"><strong>{{ number_format($k->bobot, 4) }}</strong></td>
                </tr>
                @endforeach
                <tr style="background: #f3f4f6;">
                    <td colspan="3" align="right"><strong>TOTAL BOBOT</strong></td>
                    <td align="center"><strong>{{ number_format($kriteria->sum('bobot'), 4) }}</strong></td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Metodologi -->
    <div class="section">
        <div class="section-title">III. METODOLOGI SELEKSI</div>
        <p style="text-align: justify; line-height: 1.6;">
            Seleksi penerima beasiswa ini menggunakan <strong>metode hibrid Fuzzy-AHP dan MOORA</strong>. 
            Fuzzy-AHP digunakan untuk menentukan bobot kepentingan setiap kriteria dengan menangani ketidakpastian 
            dalam penilaian perbandingan berpasangan. Kemudian MOORA (Multi-Objective Optimization on the basis of 
            Ratio Analysis) digunakan untuk meranking siswa berdasarkan nilai kriteria dan bobot yang telah ditentukan.
        </p>
        <div class="highlight">
            <strong>Tahapan Proses:</strong>
            <ol style="margin: 5px 0;">
                <li>Input data kriteria dan siswa</li>
                <li>Perbandingan berpasangan kriteria dengan skala Saaty (1-9)</li>
                <li>Perhitungan bobot kriteria menggunakan Fuzzy-AHP</li>
                <li>Normalisasi matriks keputusan</li>
                <li>Optimasi dengan MOORA: Yi = Σ(benefit × bobot) - Σ(cost × bobot)</li>
                <li>Ranking berdasarkan nilai Yi (descending)</li>
            </ol>
        </div>
    </div>

    <div class="page-break"></div>

    <!-- Page 2: Hasil Ranking -->
    <div class="section">
        <div class="section-title">IV. HASIL RANKING PENERIMA BEASISWA</div>
        <table class="data">
            <thead>
                <tr>
                    <th width="5%">Rank</th>
                    <th width="8%">NIS</th>
                    <th width="25%">Nama Siswa</th>
                    <th width="7%">Kelas</th>
                    <th width="20%">Nama Orang Tua</th>
                    <th width="15%">Nilai Yi</th>
                    <th width="20%">Status Penerima</th>
                </tr>
            </thead>
            <tbody>
                @foreach($hasil as $item)
                <tr style="{{ $item->status_penerima == 'layak' ? 'background: #d1fae5;' : '' }}">
                    <td align="center"><strong>{{ $item->ranking }}</strong></td>
                    <td>{{ $item->siswa->nis }}</td>
                    <td><strong>{{ $item->siswa->nama_lengkap }}</strong></td>
                    <td align="center">{{ $item->siswa->kelas }}</td>
                    <td>{{ $item->siswa->nama_ortu ?? '-' }}</td>
                    <td align="center"><strong>{{ number_format($item->nilai_moora, 6) }}</strong></td>
                    <td align="center">
                        @if($item->status_penerima == 'layak')
                            <strong style="color: #065f46;">✓ LAYAK</strong>
                        @elseif($item->status_penerima == 'cadangan')
                            <strong style="color: #92400e;">⚠ CADANGAN</strong>
                        @else
                            <span style="color: #6b7280;">✗ TIDAK LAYAK</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Kesimpulan -->
    <div class="section">
        <div class="section-title">V. KESIMPULAN</div>
        <table class="info-table">
            <tr>
                <td width="40%"><strong>Total Siswa yang Mengikuti Seleksi</strong></td>
                <td width="2%">:</td>
                <td><strong>{{ $hasil->count() }} siswa</strong></td>
            </tr>
            <tr>
                <td><strong>Siswa yang Layak Menerima Beasiswa</strong></td>
                <td>:</td>
                <td><strong style="color: #059669;">{{ $hasil->where('status_penerima', 'layak')->count() }} siswa</strong></td>
            </tr>
            <tr>
                <td><strong>Siswa Cadangan</strong></td>
                <td>:</td>
                <td><strong style="color: #f59e0b;">{{ $hasil->where('status_penerima', 'cadangan')->count() }} siswa</strong></td>
            </tr>
            <tr>
                <td><strong>Kuota Beasiswa</strong></td>
                <td>:</td>
                <td><strong>{{ $periode->kuota_beasiswa }} siswa</strong></td>
            </tr>
        </table>

        <div class="highlight">
            <p style="margin: 0;"><strong>Rekomendasi:</strong> Berdasarkan hasil perhitungan menggunakan metode 
            Fuzzy-AHP dan MOORA, direkomendasikan untuk memberikan beasiswa kepada 
            <strong>{{ $hasil->where('status_penerima', 'layak')->count() }} siswa</strong> dengan ranking tertinggi 
            sesuai kuota yang tersedia.</p>
        </div>
    </div>

    <!-- TTD -->
    <div style="margin-top: 50px;">
        <table width="100%">
            <tr>
                <td width="50%" align="center" valign="top">
                    <p>Mengetahui,<br><strong>Kepala Madrasah</strong></p>
                    <div style="height: 60px;"></div>
                    <p><strong>(__________________)</strong></p>
                </td>
                <td width="50%" align="center" valign="top">
                    <p>Batam, {{ $tanggal }}<br><strong>Panitia Seleksi Beasiswa</strong></p>
                    <div style="height: 60px;"></div>
                    <p><strong>(__________________)</strong></p>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>