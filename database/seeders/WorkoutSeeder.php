<?php

namespace Database\Seeders;

use App\Models\Workout;
use App\Models\Exercise;
use Illuminate\Database\Seeder;

class WorkoutSeeder extends Seeder
{
    public function run(): void
    {
        // Crear 20 entrenamientos aleatorios
        Workout::factory(20)->create()->each(function ($workout) {
            // Obtener ejercicios aleatorios (entre 3 y 6 por entrenamiento)
            $exercises = Exercise::inRandomOrder()->limit(rand(3, 6))->get();

            // Asociar los ejercicios al entrenamiento con series y repeticiones aleatorias
            foreach ($exercises as $exercise) {
                $workout->exercises()->attach($exercise->id, [
                    'sets' => rand(3, 5),
                    'reps' => rand(8, 15),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        });
    }
}
