<?php

namespace App\Imports;

use App\Models\Student;
use App\Models\Subject;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class StudentsImport implements ToCollection, WithHeadingRow, WithValidation
{

    public $errors = [];
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function collection(Collection $rows)
    {
        $studentCodes = $rows->pluck('ma_sinh_vien')->toArray();
        $students = Student::whereIn('student_code', $studentCodes)->with('subjects')->get();
        foreach ($rows as $row) {
            if (empty($row['ma_sinh_vien']) || empty($row['id_mon_hoc'])) {
                $this->errors[] = "Student code or Subject ID is missing.";
                return;
            }

            $student = $students->firstWhere('student_code', $row['ma_sinh_vien']);

            if (!$student) {
                $this->errors[] = "Student with code {$row['ma_sinh_vien']} not found.";
                return;
            }

            if (!$student->subjects->contains('id', $row['id_mon_hoc'])) {
                $this->errors[] = "Subject with ID {$row['id_mon_hoc']} not found for student with code {$row['ma_sinh_vien']}.";
                return;
            }

            $student->subjects()->syncWithoutDetaching([$row['id_mon_hoc'] => ['score' => $row['diem_mon_hoc']]]);
        }
    }
    public function rules(): array
    {
        return [
            'ma_sinh_vien' => 'required',
            'id_mon_hoc' => 'required|numeric',
            'diem_mon_hoc' => 'required|numeric',
        ];
    }
    public function getErrors()
    {
        return $this->errors;
    }
}
