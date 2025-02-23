<?php

namespace App\Listeners;

use App\Events\WorkoutPublished;
use App\Mail\WorkoutPublishedMail;
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
