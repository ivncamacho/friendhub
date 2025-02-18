<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Los eventos y los oyentes de la aplicación.
     *
     * @var array
     */
    protected $listen = [
        \App\Events\ExercisePublished::class => [
            \App\Listeners\SendExercisePublishedEmail::class,

        ],
    ];

    /**
     * Registra cualquier servicio de eventos para la aplicación.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }
}
