<?php

namespace App\Jobs;

use App\Models\Workout;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\File;

class GenerateWorkoutPdf implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $workout;

    public function __construct(Workout $workout)
    {
        $this->workout = $workout;
    }

    public function handle()
    {
        $workout = Workout::with('exercises')->findOrFail($this->workout->id);

        $pdf = Pdf::loadView('workouts.pdf', compact('workout'));

        $pdfDirectory = public_path('pdfs');
        if (! File::exists($pdfDirectory)) {
            File::makeDirectory($pdfDirectory, 0755, true);
        }

        $pdfPath = $pdfDirectory.'/workout_'.$this->workout->id.'.pdf';
        $pdf->save($pdfPath);

    }
}
