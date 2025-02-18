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

class GenerateWorkoutPDF implements ShouldQueue
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

        // Asegúrate de que la ruta de las imágenes sea correcta
        foreach ($exercises as $exercise) {
            $imagePath = storage_path('app/public/assets/img/exercises/' . $exercise->media);

            if (file_exists($imagePath)) {
                // Codificar la imagen a Base64
                $imageData = base64_encode(Storage::disk('public')->get('assets/img/exercises/' . $exercise->media));
                $imageExtension = pathinfo($exercise->media, PATHINFO_EXTENSION);

                // Asignar la imagen codificada en Base64 a la propiedad 'media' de cada ejercicio
                $exercise->media = "data:image/{$imageExtension};base64,{$imageData}";
            } else {
                // Si la imagen no existe, asignar una imagen por defecto
                $exercise->media = "data:image/png;base64," . base64_encode(Storage::disk('public')->get('assets/img/exercises/default.png'));
            }
        }

        // Generar el PDF con los ejercicios
        $pdf = Pdf::loadView('workouts.pdf', compact('exercises'));

        // Guardar el PDF en la carpeta pública
        $pdf->save(public_path('pdfs/workout_' . $this->workout->id . '.pdf'));
    }
}
