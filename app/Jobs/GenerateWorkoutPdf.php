<?php
namespace App\Jobs;

use App\Models\Workout;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class GenerateWorkoutPdf implements ShouldQueue
{
    use Dispatchable, Queueable, InteractsWithQueue, SerializesModels;

    protected $workout;

    public function __construct(Workout $workout)
    {
        $this->workout = $workout;
    }

    public function handle()
    {
        $exercises = $this->workout->exercises;

        $pdf = Pdf::loadView('workouts.pdf', compact('exercises'));

        // Guardar el PDF en la carpeta pública
        $pdf->save(public_path('pdfs/workout_' . $this->workout->id . '.pdf'));
    }
}
