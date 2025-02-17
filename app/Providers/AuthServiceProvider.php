<?php

namespace App\Providers;

use App\Models\Exercise;
use App\Models\Workout;
use App\Policies\ExercisePolicy;
use App\Policies\WorkoutPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Mapeo de policies para los modelos.
     */
    protected $policies = [
        Exercise::class => ExercisePolicy::class,
        Workout::class => WorkoutPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}
