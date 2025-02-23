<?php

namespace App\Jobs;

use App\Exports\ExercisesExport;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Maatwebsite\Excel\Facades\Excel;

class ExportDailyExercises implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $fileName = 'daily-reports/report_'.now()->format('Y_m_d').'.xlsx';
        Excel::store(new ExercisesExport, $fileName, 'public');
    }
}
