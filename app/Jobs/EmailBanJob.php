<?php

namespace App\Jobs;

use App\Mail\SendBanMailClass;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class EmailBanJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $student;
    protected $score;

    /**
     * Create a new job instance.
     */
    public function __construct($student,$score)
    {
        $this->student = $student;
        $this->score = $score;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
//        Log::info('Showing user profile for user: ' . $this->student);
        Mail::to($this->student->user->email)
            ->send(new SendBanMailClass($this->student, $this->score));
    }

}
