<?php
namespace App\Console\Commands;

use App\Models\Exercise;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class ImportarEjercicios extends Command
{
    protected $signature = 'ejercicios:importar';
    protected $description = 'Importa ejercicios desde la API de Ninja';

    public function handle()
    {
        $response = Http::withHeaders([
            'X-Api-Key' => config('services.api_ninja.key')
        ])->get(config('services.api_ninja.url'), [
             // Puedes cambiarlo por otro músculo o quitarlo para traer todos
        ]);

        if ($response->failed()) {
            $this->error('Error al obtener datos de la API.');
            return;
        }

        $ejercicios = $response->json();

        foreach ($ejercicios as $ejercicio) {
            Exercise::updateOrCreate(
                ['title' => $ejercicio['name']],
                [
                    'description' => $ejercicio['instructions'],
                    'media' => $ejercicio['gifUrl'] ?? 'default.jpg' // Si no tiene imagen, usa una por defecto
                ]
            );
        }

        $this->info('Ejercicios importados correctamente.');
    }
}
