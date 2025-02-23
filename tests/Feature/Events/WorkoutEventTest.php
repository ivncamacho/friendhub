<?php

use App\Events\WorkoutPublished;
use App\Listeners\SendWorkoutPublishedEmail;
use App\Mail\WorkoutPublishedMail;
use App\Models\User;
use App\Models\Workout;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;

it('should dispatch the WorkoutPublished event when a workout is created', function () {
    Event::fake();

    $user = User::factory()->create();
    $workout = Workout::factory()->create(['user_id' => $user->id]);

    event(new WorkoutPublished($workout));

    Event::assertDispatched(WorkoutPublished::class, function ($event) use ($workout) {
        return $event->workout->id === $workout->id;
    });
});

it('should contain the correct workout data when the WorkoutPublished event is dispatched', function () {
    Event::fake();

    $user = User::factory()->create();
    $workout = Workout::factory()->create(['user_id' => $user->id]);

    event(new WorkoutPublished($workout));

    Event::assertDispatched(WorkoutPublished::class, function ($event) use ($workout) {
        return $event->workout->id === $workout->id && $event->workout->name === $workout->name;
    });
});

it('should broadcast on the correct channel', function () {
    $user = User::factory()->create();
    $workout = Workout::factory()->create(['user_id' => $user->id]);

    $event = new WorkoutPublished($workout);

    expect($event->broadcastOn())->toMatchArray([
        new PrivateChannel('channel-name'),
    ]);
});

it('should send an email when WorkoutPublished event is handled', function () {
    Mail::fake();
    Queue::fake();

    $user = User::factory()->create();
    $workout = Workout::factory()->create(['user_id' => $user->id]);

    auth()->login($user);

    $event = new WorkoutPublished($workout);
    $listener = new SendWorkoutPublishedEmail;
    $listener->handle($event);

    Mail::assertSent(WorkoutPublishedMail::class, function ($mail) use ($user) {
        return $mail->hasTo($user->email);
    });
});
