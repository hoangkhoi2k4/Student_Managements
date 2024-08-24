<?php

namespace App\Console\Commands;

use App\Jobs\EmailBanJob;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\Student;

class ResultStudy extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:result-study';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email when student finish study, if score < 5 ban account';


    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting ResultStudy Command');

        try {
            DB::beginTransaction();
            $listStudentFinished = Student::whereDoesntHave('subjects', function ($query) {
                $query->whereNull('score');
            })->whereHas('subjects', function ($query) {
                $query->whereNotNull('score');
            })->get();
            foreach ($listStudentFinished as $student) {
                $scoreAvg = $student->subjects->avg('pivot.score');
                if ($scoreAvg < 5) {
                    $student->update(['status' => 0]);
                    EmailBanJob::dispatch($student, $scoreAvg);
                    $this->info('Email sent to ' . $student->user->email);
                } else {
                    $student->update(['status' => 3]);
                    $this->info('Email not sent to because score > 5 ' . $student->user->email);
                }
            }
            DB::commit();
            $this->info('Command executed successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            $this->error('Error: ' . $e->getMessage());
        }
    }
}
