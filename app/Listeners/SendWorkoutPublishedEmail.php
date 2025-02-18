<?php

namespace App\Listeners;

use App\Events\ExercisePublished;
use App\Events\WorkoutPublished;
use App\Mail\ExercisePublishedMail;
use App\Mail\WorkoutPublishedMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendWorkoutPublishedEmail
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(WorkoutPublished $event): void
    {
        $recipient = auth()->user();

            Mail::to($recipient->email)->send(new WorkoutPublishedMail($event->workout));


    }
}
