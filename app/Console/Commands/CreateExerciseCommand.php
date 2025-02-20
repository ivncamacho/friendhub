<?php

namespace App\Console\Commands;

use App\Models\Exercise;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;

class CreateExerciseCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'exercise:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create an exercise';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->ask('Escribe el correo electronico');
        $password = $this->secret('Escribe la contraseña');

        $user = User::where('email', $email)->first();
        if (!Auth::attempt(['email' => $email, 'password' => $password])) {

            $this->error('Incorrect credentials.');
            return 1;
        } else {
            $this->info("Loggued as " . $user->name);

            $title = $this->ask('Escribe el titulo del ejercicio');
            $description = $this->ask('Escribe la descripcion del ejercicio');
            $media = $this->ask('Escribe la ruta de la imagen que quieres que se vea reflejada (opcional)');
            $youtube_video_id = $this->ask('Escribe el id del tutorial de youtube (opcional)');

            if (empty($title) || empty($description)) {
                $this->error('Title and description is required.');
                return 1;
            }

            $exercise = Exercise::create([
                'title' => $title,
                'description' => $description,
                'media' => $media,
                'youtube_video_id'=> $youtube_video_id,
                'user_id' => Auth::id(),
            ]);

            $this->info("Exercise '{$exercise->title}' created succesfully.");
            return 0;
        }
    }
}
