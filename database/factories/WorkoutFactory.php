<?php

namespace Database\Factories;

use App\Models\Workout;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class WorkoutFactory extends Factory
{
    protected $model = Workout::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3), // Genera un título aleatorio
            'description' => $this->faker->paragraph(3), // Genera una descripción aleatoria
            'user_id' => User::inRandomOrder()->first()->id ?? 1, // Asigna un usuario aleatorio o el ID 1
        ];
    }
}
