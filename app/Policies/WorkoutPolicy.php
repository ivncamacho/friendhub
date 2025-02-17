<?php

namespace App\Policies;

use App\Models\Exercise;
use App\Models\Workout;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class WorkoutPolicy
{
    use HandlesAuthorization;

    public function authorWorkout(User $user, Workout $workout )
    {
        if ($user->id == $workout->user_id || $user->role == 'admin'){
            return true;
        }else{
            return false;
        }
    }
}
