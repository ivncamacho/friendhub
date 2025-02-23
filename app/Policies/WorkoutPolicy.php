<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Workout;
use Illuminate\Auth\Access\HandlesAuthorization;

class WorkoutPolicy
{
    use HandlesAuthorization;

    public function authorWorkout(User $user, Workout $workout)
    {
        if ($user->id == $workout->user_id || $user->hasRole('admin')) {
            return true;
        } else {
            return false;
        }
    }
}
