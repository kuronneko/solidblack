<?php

namespace App\Exports;

use App\Models\Logger;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LoggersExport implements FromCollection, WithHeadings, WithStyles
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Logger::where('user_id', Auth::user()->id)->orderBy("created_at", 'desc')->get();
    }

    public function headings(): array
    {
        //dinamic column name
        return array_keys($this->collection()->first()->toArray());

        //personalize column name
        /*  return [
            'id',
            'user_id',
            'ip',
            'country',
            'city',
            'browser',
            'browser_version',
            'platform',
            'platform_version',
            'agent',
            'host',
            'created_at',
            'updated_at',
        ]; */
    }

    public function styles(Worksheet $sheet)
    {
        /*
        return [
            // Style the first row as bold text and text size 13.
            1    => ['font' => ['bold' => true, 'size' => 13]],

        ]; */

        $sheet->getStyle('A1:P1')->getFill()->applyFromArray(['fillType' => 'solid','rotation' => 0, 'color' => ['rgb' => '1f2937'],]);
        $sheet->getStyle('A1:P1')
        ->getFont()
        ->setSize(13)
        ->setBold(true)
        ->getColor()->setRGB('ffffff');
    }
}
