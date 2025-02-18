<?php

use App\Events\ExercisePublished;
use App\Models\Exercise;
use Illuminate\Support\Facades\Event;
use App\Models\User;
use Illuminate\Broadcasting\PrivateChannel;

it('should dispatch the ExercisePublished event when an exercise is created', function () {
    Event::fake();

    $user = User::factory()->create();
    $exercise = Exercise::factory()->create(['user_id' => $user->id]);

    event(new ExercisePublished($exercise));

    Event::assertDispatched(ExercisePublished::class, function ($event) use ($exercise) {
        return $event->exercise->id === $exercise->id;
    });
});

it('should contain the correct exercise data when the ExercisePublished event is dispatched', function () {
    Event::fake();

    $user = User::factory()->create();
    $exercise = Exercise::factory()->create(['user_id' => $user->id]);

    event(new ExercisePublished($exercise));

    Event::assertDispatched(ExercisePublished::class, function ($event) use ($exercise) {
        return $event->exercise->id === $exercise->id && $event->exercise->name === $exercise->name;
    });
});

it('should not dispatch ExercisePublished if no exercise is provided', function () {
    Event::fake();

    event(new ExercisePublished(null));

    Event::assertNotDispatched(ExercisePublished::class);
})->throws(TypeError::class);

it('should be serializable', function () {
    $user = User::factory()->create();
    $exercise = Exercise::factory()->create(['user_id' => $user->id]);

    $event = new ExercisePublished($exercise);

    $serialized = serialize($event);
    $unserialized = unserialize($serialized);

    expect($unserialized)->toBeInstanceOf(ExercisePublished::class)
        ->and($unserialized->exercise->id)->toBe($exercise->id);
});

it('should broadcast on the correct channel', function () {
    $user = User::factory()->create();
    $exercise = Exercise::factory()->create(['user_id' => $user->id]);

    $event = new ExercisePublished($exercise);

    expect($event->broadcastOn())->toMatchArray([
        new PrivateChannel('channel-name'),
    ]);
});
