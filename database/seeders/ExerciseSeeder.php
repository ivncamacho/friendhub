<?php
namespace Database\Seeders;

use App\Models\Exercise;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class ExerciseSeeder extends Seeder
{
    public function run()
    {
        $json = File::get(database_path('data/exercises.json'));
        $exercises = json_decode($json, true);

        foreach ($exercises as $exercise) {
            Exercise::create([
                'title' => $exercise['title'],
                'description' => $exercise['description'],
                'media' => $exercise['media'],
                'youtube_video_id' => $exercise['youtube_video_id'],
            ]);
        }
    }
}
