<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Models\Student;
use Illuminate\Support\Facades\DB;
use App\Enums\Network;

class StudentRepository extends BaseRepository
{
    public function getModel()
    {
        return Student::class;
    }

    public function filter(array $data)
    {
        $query = $this->model->select('id', 'user_id', 'student_code', 'gender', 'birthday', 'status')->with('user:id,name', 'subjects:id');

        if (isset($data['age_from'])) {
            $dateFrom = Carbon::now()->subYears($data['age_from'])->startOfDay()->toDateString();
            $query->where('birthday', '<=', $dateFrom);
        }
        if (isset($data['age_to'])) {
            $dateTo = Carbon::now()->subYears($data['age_to'])->endOfDay()->toDateString();;
            $query->where('birthday', '>=', $dateTo);
        }
        if (isset($data['score_from']) || isset($data['score_to'])) {
            $query->whereHas('subjects', function ($query) use ($data) {
                $query->select(DB::raw('AVG(score) as avg_score'))
                    ->groupBy('student_id');

                if (isset($data['score_from'])) {
                    $query->having('avg_score', '>=', $data['score_from']);
                }
                if (isset($data['score_to'])) {
                    $query->having('avg_score', '<=', $data['score_to']);
                }
            });
        }

        if (!empty($data['network']) && array_filter($data['network'])) {
            $data['network'] = array_filter($data['network']);
            $conditions = [];
            foreach ($data['network'] as $network) {
                $networkEnum = Network::from($network);
                switch ($networkEnum) {
                    case Network::VINAPHONE:
                        $conditions[] = "phone REGEXP '^08[2-5]'";
                        break;
                    case Network::VIETTEL:
                        $conditions[] = "phone REGEXP '^03[2-9]|^09[0-9]|^086'";
                        break;
                    case Network::MOBIFONE:
                        $conditions[] = "phone REGEXP '^07[0-9]'";
                        break;
                    default:
                        break;
                }
            }
            if (!empty($conditions)) {
                $query->whereRaw(implode(' OR ', $conditions));
            }
        }

        if (!empty($data['status']) && array_filter($data['status'])) {
            $data['status'] = array_filter($data['status']);
            $query->whereIn('status', $data['status']);
        }
        return $query->paginate($data['size'] ?? 10);
    }

    public function updateStudent($data, $id)
    {
        $student = $this->model->findOrFail($id);
        return $student->update($data);
    }

    public function show($id)
    {
        return $this->model->with('user', 'department', 'subjects')->findOrFail($id);
    }

    public function getScoreByStudentSubjectId($studentId, $subjectId)
    {
        $student = $this->model->with(['subjects' => function ($query) use ($subjectId) {
            $query->where('subjects.id', $subjectId);
        }])->findOrFail($studentId);

        $subject = $student->subjects->first();

        if ($subject) {
            return $subject->pivot->score;
        } else {
            return null;
        }
    }

    public function updateScore($studentId, $scores)
    {
        $student = $this->findOrFail($studentId);
        $student->subjects()->syncWithoutDetaching($scores);
    }

    public function registerSubject($studentId, $subjectId)
    {
        $student = $this->model->findOrFail($studentId);
        $student->subjects()->attach($subjectId);
        if ($student->status == \App\Enums\Status::NOT_STUDIED_YET->value) {
            $student->update(['status' => \App\Enums\Status::STUDYING->value]);
        }
        return $student;
    }
}
