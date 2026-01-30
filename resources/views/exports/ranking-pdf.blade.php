<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Ranking Penerima Beasiswa</title>
    <style>
        @page {
            margin: 20px;
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 10pt;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 3px solid #059669;
            padding-bottom: 10px;
        }
        .header h2 {
            margin: 5px 0;
            color: #059669;
        }
        .header p {
            margin: 3px 0;
            font-size: 9pt;
        }
        .info-box {
            background: #f0f9ff;
            padding: 10px;
            margin-bottom: 15px;
            border-left: 4px solid #059669;
        }
        .info-box table {
            width: 100%;
        }
        .info-box td {
            padding: 3px 5px;
            font-size: 9pt;
        }
        table.data {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
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
        .rank-badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-weight: bold;
            font-size: 10pt;
        }
        .rank-1 { background: #ffd700; color: #000; }
        .rank-2 { background: #c0c0c0; color: #000; }
        .rank-3 { background: #cd7f32; color: #fff; }
        .status-layak { 
            background: #d1fae5; 
            color: #065f46; 
            padding: 2px 6px; 
            border-radius: 3px;
            font-weight: bold;
        }
        .status-cadangan { 
            background: #fef3c7; 
            color: #92400e; 
            padding: 2px 6px; 
            border-radius: 3px;
            font-weight: bold;
        }
        .status-tidak { 
            background: #e5e7eb; 
            color: #374151; 
            padding: 2px 6px; 
            border-radius: 3px;
        }
        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 9pt;
        }
        .signature {
            margin-top: 50px;
            text-align: center;
        }
        .signature-box {
            display: inline-block;
            text-align: center;
            margin: 0 30px;
        }
        .signature-line {
            margin-top: 60px;
            border-top: 1px solid #000;
            width: 200px;
            display: inline-block;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h2>LAPORAN HASIL RANKING PENERIMA BEASISWA</h2>
        <h3 style="margin: 5px 0;">Madrasah Ibtidaiyah Daarul Ishlah Batam</h3>
        <p>Metode Fuzzy-AHP dan MOORA</p>
    </div>

    <!-- Info Periode -->
    <div class="info-box">
        <table>
            <tr>
                <td width="25%"><strong>Periode Seleksi</strong></td>
                <td width="2%">:</td>
                <td>{{ $periode->nama_periode }}</td>
                <td width="25%"><strong>Kuota Beasiswa</strong></td>
                <td width="2%">:</td>
                <td>{{ $periode->kuota_beasiswa }} siswa</td>
            </tr>
            <tr>
                <td><strong>Tahun Ajaran</strong></td>
                <td>:</td>
                <td>{{ $periode->tahun_ajaran }}</td>
                <td><strong>Total Peserta</strong></td>
                <td>:</td>
                <td>{{ $hasil->count() }} siswa</td>
            </tr>
            <tr>
                <td><strong>Tanggal Cetak</strong></td>
                <td>:</td>
                <td>{{ $tanggal }}</td>
                <td><strong>Penerima Layak</strong></td>
                <td>:</td>
                <td>{{ $hasil->where('status_penerima', 'layak')->count() }} siswa</td>
            </tr>
        </table>
    </div>

    <!-- Tabel Ranking -->
    <table class="data">
        <thead>
            <tr>
                <th width="5%">Rank</th>
                <th width="8%">NIS</th>
                <th width="22%">Nama Siswa</th>
                <th width="5%">L/P</th>
                <th width="7%">Kelas</th>
                <th width="18%">Nama Orang Tua</th>
                <th width="10%">Penghasilan</th>
                <th width="12%">Nilai Yi</th>
                <th width="13%">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($hasil as $item)
            <tr>
                <td align="center">
                    @if($item->ranking <= 3)
                        <span class="rank-badge rank-{{ $item->ranking }}">{{ $item->ranking }}</span>
                    @else
                        <strong>{{ $item->ranking }}</strong>
                    @endif
                </td>
                <td>{{ $item->siswa->nis }}</td>
                <td><strong>{{ $item->siswa->nama_lengkap }}</strong></td>
                <td align="center">{{ $item->siswa->jenis_kelamin }}</td>
                <td align="center">{{ $item->siswa->kelas }}</td>
                <td>{{ $item->siswa->nama_ortu ?? '-' }}</td>
                <td align="right">Rp {{ number_format($item->siswa->penghasilan_ortu, 0, ',', '.') }}</td>
                <td align="center"><strong>{{ number_format($item->nilai_moora, 6) }}</strong></td>
                <td align="center">
                    @if($item->status_penerima == 'layak')
                        <span class="status-layak">LAYAK</span>
                    @elseif($item->status_penerima == 'cadangan')
                        <span class="status-cadangan">CADANGAN</span>
                    @else
                        <span class="status-tidak">TIDAK LAYAK</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Summary -->
    <div class="info-box">
        <table>
            <tr>
                <td width="25%"><strong>Total Siswa Layak</strong></td>
                <td width="2%">:</td>
                <td width="23%">{{ $hasil->where('status_penerima', 'layak')->count() }} siswa</td>
                <td width="25%"><strong>Total Siswa Cadangan</strong></td>
                <td width="2%">:</td>
                <td>{{ $hasil->where('status_penerima', 'cadangan')->count() }} siswa</td>
            </tr>
        </table>
    </div>

    <!-- Keterangan -->
    <div style="margin-top: 20px; font-size: 9pt;">
        <strong>Keterangan:</strong>
        <ul style="margin: 5px 0;">
            <li><strong>Nilai Yi</strong> adalah hasil optimasi metode MOORA (semakin tinggi semakin baik)</li>
            <li><strong>Status LAYAK</strong> untuk ranking 1 - {{ $periode->kuota_beasiswa }}</li>
            <li><strong>Status CADANGAN</strong> untuk siswa setelah kuota sebagai pengganti jika ada yang mengundurkan diri</li>
        </ul>
    </div>

    <!-- Signature -->
    <div class="signature">
        <div class="signature-box">
            <p>Mengetahui,<br><strong>Kepala Madrasah</strong></p>
            <div class="signature-line"></div>
            <p><strong>(__________________)</strong></p>
        </div>
        <div class="signature-box">
            <p>Batam, {{ $tanggal }}<br><strong>Panitia Seleksi Beasiswa</strong></p>
            <div class="signature-line"></div>
            <p><strong>(__________________)</strong></p>
        </div>
    </div>
</body>
</html>