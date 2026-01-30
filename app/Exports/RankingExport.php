<?php

namespace App\Exports;

use App\Models\HasilPerhitungan;
use App\Models\PeriodeSeleksi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RankingExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle, ShouldAutoSize
{
    protected $periodeId;

    public function __construct($periodeId)
    {
        $this->periodeId = $periodeId;
    }

    public function collection()
    {
        return HasilPerhitungan::where('periode_id', $this->periodeId)
            ->with('siswa')
            ->orderBy('ranking', 'asc')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Ranking',
            'NIS',
            'Nama Siswa',
            'Jenis Kelamin',
            'Kelas',
            'Nama Orang Tua',
            'Pekerjaan Ortu',
            'Penghasilan Ortu',
            'Jumlah Tanggungan',
            'Nilai Yi (MOORA)',
            'Status Penerima',
        ];
    }

    public function map($hasil): array
    {
        return [
            $hasil->ranking,
            $hasil->siswa->nis,
            $hasil->siswa->nama_lengkap,
            $hasil->siswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan',
            $hasil->siswa->kelas,
            $hasil->siswa->nama_ortu ?? '-',
            $hasil->siswa->pekerjaan_ortu ?? '-',
            'Rp ' . number_format($hasil->siswa->penghasilan_ortu, 0, ',', '.'),
            $hasil->siswa->jumlah_tanggungan . ' orang',
            number_format($hasil->nilai_moora, 6),
            strtoupper($hasil->status_penerima),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'size' => 12],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '059669']
                ],
                'font' => ['color' => ['rgb' => 'FFFFFF'], 'bold' => true],
            ],
        ];
    }

    public function title(): string
    {
        return 'Ranking Penerima Beasiswa';
    }
}