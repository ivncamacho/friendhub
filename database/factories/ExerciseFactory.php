<?php

namespace Database\Factories;

use App\Models\Exercise;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Exercise>
 */
class ExerciseFactory extends Factory
{
    protected $model = Exercise::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3), // Genera un título aleatorio
            'description' => $this->faker->paragraph(3), // Genera una descripción aleatoria
            'media' => $this->faker->sentence(),
            'youtube_video_id' => $this->faker->sentence(),
            'user_id' => User::inRandomOrder()->first()->id ?? 1,
        ];
    }
}
