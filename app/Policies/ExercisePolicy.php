<?php

namespace App\Policies;

use App\Models\Exercise;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ExercisePolicy
{
    use HandlesAuthorization;

    public function authorExercise(User $user, Exercise $exercise)
    {
        if ($user->id == $exercise->user_id || $user->role == 'admin') {
            return true;
        } else {
            return false;
        }
    }
}
