<?php

namespace App\Events;

use App\Models\Exercise;
use App\Models\Workout;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ExercisePublished
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $exercise;

    /**
     * Create a new event instance.
     */
    public function __construct(Exercise $exercise)
    {
        $this->exercise = $exercise;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
