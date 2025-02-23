<?php

namespace App\Listeners;

use App\Events\ExercisePublished;
use App\Mail\ExercisePublishedMail;
use Illuminate\Support\Facades\Mail;

class SendExercisePublishedEmail
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
    public function handle(ExercisePublished $event): void
    {
        $recipient = auth()->user();

        Mail::to($recipient->email)->send(new ExercisePublishedMail($event->exercise));

    }
}
