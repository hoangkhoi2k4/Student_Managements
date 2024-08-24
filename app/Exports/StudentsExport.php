<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class StudentsExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return collect([
            ['202323', 1, 85],
            ['202323', 2, 90],
            ['202323', 3, 78],
            ['202333', 1, 88],
            ['202333', 3, 84],
            ['202411', 2, 76],
            ['202411', 4, 82],
        ]);
    }

    public function headings(): array
    {
        return [
            'student_code' => 'Mã Sinh Viên',
            'subject_id' => 'ID Môn Học',
            'score' => 'Điểm Môn Học',
        ];
    }
}
