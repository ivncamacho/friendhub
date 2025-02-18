<?php

namespace App\Console\Commands;

use App\Models\Exercise;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;

class CreateExerciseCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'exercise:create {email} {password} {title} {description?} {media?} {youtube_video_id?}';

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

        $email = $this->argument('email');
        $password = $this->argument('password');

        $title = $this->argument('title');
        if (empty($title)) {
            $this->error('title is required');
            return;
        }

        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            $this->info("Loggued as {$email}");

            $description = $this->argument('description') ;
            $media = $this->argument('media');
            $youtube_video_id = $this->argument('youtube_video_id');


            $exercise = Exercise::create([
                'title' => $title,
                'description' => $description,
                'media' => $media,
                 'youtube_video_id'=> $youtube_video_id,
                'user_id' => Auth::id(),
            ]);

            $this->info("Exercise '{$exercise->title}' created succesfully.");
        } else {
            $this->error('Incorrect credentials.');
        }
    }
}
