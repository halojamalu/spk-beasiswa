<?php

namespace App\Exports;

use App\Models\PenilaianSiswa;
use App\Models\Kriteria;
use App\Models\Siswa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DetailPerhitunganExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle, ShouldAutoSize
{
    protected $periodeId;

    public function __construct($periodeId)
    {
        $this->periodeId = $periodeId;
    }

    public function collection()
    {
        return Siswa::active()
            ->orderBy('nis')
            ->get();
    }

    public function headings(): array
    {
        $kriteria = Kriteria::active()->orderBy('kode_kriteria')->get();
        
        $headers = ['No', 'NIS', 'Nama Siswa', 'Kelas'];
        
        foreach ($kriteria as $k) {
            $headers[] = $k->kode_kriteria . ' - ' . $k->nama_kriteria;
        }
        
        return $headers;
    }

    public function map($siswa): array
    {
        static $no = 0;
        $no++;
        
        $kriteria = Kriteria::active()->orderBy('kode_kriteria')->get();
        
        $row = [
            $no,
            $siswa->nis,
            $siswa->nama_lengkap,
            $siswa->kelas,
        ];
        
        foreach ($kriteria as $k) {
            $penilaian = PenilaianSiswa::where('periode_id', $this->periodeId)
                ->where('siswa_id', $siswa->id)
                ->where('kriteria_id', $k->id)
                ->first();
            
            $row[] = $penilaian ? number_format($penilaian->nilai, 2) : '-';
        }
        
        return $row;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'size' => 12],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '0891b2']
                ],
                'font' => ['color' => ['rgb' => 'FFFFFF'], 'bold' => true],
            ],
        ];
    }

    public function title(): string
    {
        return 'Detail Penilaian Siswa';
    }
}